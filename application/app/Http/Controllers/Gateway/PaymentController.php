<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Order;
use App\Models\Product;
use App\Models\TopUp;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    public function paynow($id = null)
    {

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })
            ->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';

        if (!is_null($id)) {
            $products = Product::where('id', $id)->get();
        } else {
            $products = Product::whereIn('id', array_keys(request()->products))->get();
        }
        return view($this->activeTemplate . 'user.payment.paynow', compact('gatewayCurrency', 'pageTitle', 'products'));
    }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })
            ->with('method')->orderby('method_code')->get();
        $pageTitle = 'Deposit Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {
        $paymentService = new PaymentService;
        $orderProducts = [];
        $quantities = $request->quantity;
        $orderType = 0;
        $topUp = '';
        $cart = session()->get('cart');

        if (!empty($request->products)) {
            foreach ($request->products as $key => $productId) {
                $product = Product::with('licenseKeys')->find($productId);
                if ($product) {
                    $orderType = 1;
                    array_push($orderProducts, $product);
                    if (isset($cart[$product->id])) {
                        unset($cart[$product->id]);
                        session()->put('cart', $cart);
                    }
                }
            }
        }

        if (!empty($request->topUpId)) {
            $id = intval($request->topUpId);
            $orderType = 2;
            $topUp = TopUp::findOrFail($id);
        }

        if ($request->gateway == 'balance') {
            $hasInsufficientBalance = $paymentService->checkInsufficientBalance();
            if($hasInsufficientBalance){
                $notify[] = ['error', 'Insufficient Balance'];
                return back()->withNotify($notify);
            }
            try {
                if($orderType == 1){
                    $paymentService->storeOrderWithBalance($orderProducts, $quantities, $orderType);
                }else{
                    $paymentService->storeTopUpOrder($topUp, $request, $orderType);
                }
                $notify[] = ['success', 'Successfully Purchased'];
                return to_route('user.home')->withNotify($notify);
            } catch (\Throwable $th) {
                $notify[] = ['error', 'Product Order Occurred'];
                return back()->withNotify($notify);
            }
        }

        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);

        // Users hasn't wallet balance and pay with munual GW
        if (!empty($request->products) || !empty($request->topUpId)) {
            $paymentService->checkInsufficientBalance($request);
            try {
                if($orderType == 1){
                    $paymentService->storeOrderWithDeposit($orderProducts, $quantities, $orderType);
                }else{
                    $paymentService->storeTopUpOrder($topUp, $request, $orderType);
                }
                return to_route('user.deposit.confirm');
            } catch (\Throwable $th) {
                $notify[] = ['error', 'Product Order Occurred'];
                return back()->withNotify($notify);
            }
        }
        else{
            $paymentService->createDeposit();
            return to_route('user.deposit.confirm');
        }
    }

    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }
        $data = Deposit::where('id', $id)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', 0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }

        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);

        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }

    public static function userDataUpdate($deposit, $isManual = null)
    {
        if ($deposit->status == 0 || $deposit->status == 2) {
            $deposit->status = 1;
            $deposit->save();

            $user = User::find($deposit->user_id);

            if($deposit->order_id == 0){
                $user->balance += $deposit->amount;
                $user->save();
            }

            if($deposit->order_id > 0){
                $paymentService = new PaymentService;
                $order = Order::with(['products'])->find($deposit->order_id);
                $order->status == Order::STATUS_PRE_ORDER ? $order->status = Order::STATUS_PROCESS : $order->status = Order::STATUS_COMPLETED;
                $order->save();

                if($order->status == Order::STATUS_COMPLETED && $order->type == 1){
                    foreach ($order->products as $key => $product) {
                        $paymentService->updateLicensKey($product->amount, $product->id, $key, $order->id, $product->pivot->license_quantity);
                    }
                    notify($user,'ORDER APPROVED', [
                        'order_number' => $order->number,
                        'amount' => showAmount($order->amount),
                        'trx' => $deposit->trx,
                        'post_balance' => showAmount($user->balance),
                    ]);
                }
            }
            else{
            $transaction = new Transaction();
            $transaction->user_id = $deposit->user_id;
            $transaction->amount = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = $deposit->charge;
            $transaction->trx_type = '+';
            $transaction->details = 'Deposit Via ' . $deposit->gatewayCurrency()->name;
            $transaction->trx = $deposit->trx;
            $transaction->remark = 'deposit';
            $transaction->save();}

            if (!$isManual) {
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Deposit successful via ' . $deposit->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                'method_name' => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount' => showAmount($deposit->final_amo),
                'amount' => showAmount($deposit->amount),
                'charge' => showAmount($deposit->charge),
                'rate' => showAmount($deposit->rate),
                'trx' => $deposit->trx,
                'post_balance' => showAmount($user->balance),
            ]);
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = 2; // pending
        $data->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = 'Deposit request from ' . $data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name' => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => showAmount($data->final_amo),
            'amount' => showAmount($data->amount),
            'charge' => showAmount($data->charge),
            'rate' => showAmount($data->rate),
            'trx' => $data->trx,
        ]);

        $notify[] = ['success', 'You have deposit request has been taken'];
        return to_route('user.deposit.history')->withNotify($notify);
    }
}
