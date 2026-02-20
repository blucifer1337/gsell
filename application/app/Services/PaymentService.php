<?php

namespace App\Services;

use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\LicenseKey;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;

class PaymentService
{

    public function checkInsufficientBalance()
    {

        if (floatval(auth()->user()->balance) < $this->getTotalAmount()) {
            return true;
        }
        return false;
    }

    public function updateLicensKey($amount, $productId, $index, $order_id, $quantities)
    {
        $order = Order::findOrFail($order_id);
        foreach (range(1, $quantities) as $key => $quantity) {
            $licenseKey = LicenseKey::whereProductId($productId)->whereStatus(0)->first();
            if ($licenseKey) {
                $licenseKey->user_id = $order->user_id;
                $licenseKey->order_id = $order_id;
                $licenseKey->sell_amount = $amount;
                $licenseKey->sold_at = now();
                $licenseKey->status = 1;
                $licenseKey->save();
            }
        }
    }

    public function storeOrderWithBalance(array $products, $quantities,  $orderType)
    {
        if (!empty($products)) {

            $user= auth()->user();
            $user->balance -= $this->getTotalAmount();
            $user->save();

            $fproduct = $products[0];
            $order = $this->createOrder($fproduct->status, $orderType);
            foreach ($products as $key => $product) {
                $order->products()->attach($product->id, ['license_quantity' => $quantities[$key]]);
                if ($product->status == Product::STATUS_ACTIVE) {
                    $this->updateLicensKey($product->amount, $product->id, $key, $order->id, $quantities[$key]);
                }
            }
        }
    }

    public function storeOrderWithDeposit(array $products, $quantities, $orderType)
    {
        if (!empty($products)) {
            $product = $products[0];
            $order = $this->createOrder($product->status, $orderType);
            foreach ($products as $key => $product) {
                $order->products()->attach($product->id, ['license_quantity' => $quantities[$key]]);
            }
            $this->createDeposit($order->id);
        }
    }

    public function storeTopUpOrder($topUp, $request, $orderType)
    {
        if($request->gateway == 'balance'){
            $user= auth()->user();
            $user->balance -= $this->getTotalAmount();
            $user->save();
        }
        $collectRequest = Collect($request);
        $filterData = $collectRequest->only('game_id', 'server_info', 'user_info', 'quantity');
        $topupData = json_encode($filterData->filter()->all());
        $order = $this->createOrder($topUp, $orderType, $topupData);
        if($request->gateway != 'balance'){
            $this->createDeposit($order->id);
        }
    }

    private function getCharge()
    {
        $amount = request()->amount;
        $fixed_charge = request()->fixed_charge;
        $percent_charge = request()->percent_charge;
        return number_format($fixed_charge + ($amount * $percent_charge / 100), 2);
    }

    private function getTotalAmount()
    {
        return $this->getCharge() + request()->amount;
    }

    private function createOrder($product, $orderType, $topupData = null,)
    {
        $transaction = $this->createTransaction($product, $orderType);
        $order = new Order;
        $order->user_id = auth()->id();
        $order->number = now()->format('Ymd') . '_' . now()->format('His');
        $order->transaction_id = $transaction->id;
        $order->amount = $this->getTotalAmount();
        if ($orderType == 1) {
            if ($product == Product::STATUS_PRE_ORDER && request()->gateway == 'balance') {
                $order->status = Order::STATUS_PROCESS;
            } elseif ($product == Product::STATUS_PRE_ORDER) {
                $order->status = Order::STATUS_PRE_ORDER;
            } elseif ($product == Product::STATUS_ACTIVE && request()->gateway == 'balance') {
                $order->status = Order::STATUS_COMPLETED;
            } else {
                $order->status = Order::STATUS_PENDING;
            }
        }
        else{
            $order->type = $orderType;
            $order->topup_id = $product->id;
            $order->topup_data = $topupData;
            if ($product->status == Product::STATUS_ACTIVE && request()->gateway == 'balance') {
                $order->status = Order::STATUS_COMPLETED;
            } else {
                $order->status = Order::STATUS_PENDING;
            }
        }

        $order->save();
        return $order;
    }

    private function createTransaction($product, $orderType)
    {
        $transaction = new Transaction();
        $transaction->user_id = auth()->id();
        $transaction->amount = $this->getTotalAmount();
        $transaction->post_balance = auth()->user()->balance;
        $transaction->charge = $this->getCharge();
        $transaction->trx = getTrx();
        if ($orderType == 1) {
            if (request()->gateway == 'balance') {
                $transaction->trx_type = '-';
                $transaction->details = auth()->user()->username . ' Purchased License key';
                if ($product == Product::STATUS_PRE_ORDER) {
                    $transaction->remark = 'Product Pre Order Paid';
                } else {
                    $transaction->remark = 'Key Purchase Paid';
                }
            }
            if (request()->gateway != 'balance') {
                $transaction->trx_type = 'Product Payment';
                $transaction->details = auth()->user()->username . ' Purchased License key';
                if ($product == Product::STATUS_PRE_ORDER) {
                    $transaction->remark = 'Product Pre Order Deposit';
                } else {
                    $transaction->remark = 'Key Purchase Deposit';
                }
            }
        }else{
            if (request()->gateway == 'balance') {
                $transaction->trx_type = '-';
                $transaction->details = auth()->user()->username . ' Purchased Top Up "'. request()->quantity. '" Paid';
                $transaction->remark = 'Top Up Purchase Paid';
            }
            if (request()->gateway != 'balance') {
                $transaction->trx_type = 'Top Up Payment ';
                $transaction->details = auth()->user()->username . ' Purchased Top Up "'. request()->quantity. '" Order';
                $transaction->remark = 'Top Up Purchase Deposit';
            }
        }

        $transaction->save();
        return $transaction;
    }

    public function createDeposit($order_id = 0)
    {
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', request()->method_code)->where('currency', request()->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > request()->amount || $gate->max_amount < request()->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + (request()->amount * $gate->percent_charge / 100);
        $payable = request()->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data = new Deposit();
        $data->user_id = auth()->user()->id;
        $data->order_id = $order_id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = request()->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();
        session()->put('Track', $data->trx);
        return $data;
    }
}
