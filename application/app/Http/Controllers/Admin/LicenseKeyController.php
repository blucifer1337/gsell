<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\LicenseKey;
use App\Models\Transaction;
use App\Models\AdminNotification;

class LicenseKeyController extends Controller
{
    public static function purchase($userId, $productId, $amount){

        $user = User::find($userId);
        $product = Product::find($productId);
        $licenseKey = LicenseKey::whereProductId($productId)->whereStatus(0)->first();
        if(!$licenseKey){
            return false;
        }
        $licenseKey->user_id = $userId;
        $licenseKey->sell_amount = $amount;
        $licenseKey->sold_at = now();
        $licenseKey->status = 1;
        $licenseKey->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $product->final_amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = $user->username.'Purchased License key for '.$product->name;
        $transaction->trx = getTrx();
        $transaction->remark = 'Key Purchase';
        $transaction->save();

        $order = new Order;
        $order->user_id = $userId;
        $order->product_id = $productId;
        $order->transaction_id = $transaction->id;
        $order->license_key = $licenseKey->license_key;
        $order->amount = $amount;
        $order->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = '@'.$user->username.'Purchased License';
        $adminNotification->click_url = route('product', ['slug' => slug($product->title), 'id' => $productId]);
        $adminNotification->save();

        notify($user, 'PURCHASED', [
            'username' => $user->username,
            'product_name' => $product->name,
            'amount' => $product->final_amount,
            'license_key' => $licenseKey->license_key
        ]);

        return true;
    }

    public function index($id){

       $pageTitle = 'License Keys for "'. Product::find($id)->title.'"';
        $licenseKeys = LicenseKey::orderBy('created_at', 'desc')->with('user')->where('product_id', $id)->paginate(getPaginate());
        return view('admin.license_key.index', compact('licenseKeys', 'pageTitle', 'id'));
    }

    public function store(Request $request){
        $request->validate([
            'keys' =>'required',
            'product_id' =>'required'
        ]);

        $keys = preg_split('/\r\n|[\r\n]/', $request->keys);

        foreach ($keys as $key) {
            $licenseKey = new LicenseKey;
            $licenseKey->product_id = $request->product_id;
            $licenseKey->license_key = $key;
            $licenseKey->save();
        }

        $notify[] = ['success', 'Keys Added Successfully'];
        return back()->withNotify($notify);
    }

    public function update($id, Request $request){
        $request->validate([
            'license_key' =>'required',
            'product_id' =>'required'
        ]);

        $licenseKey = LicenseKey::find($id);
        $licenseKey->license_key = $request->license_key;
        $licenseKey->status = $request->status;
        if($request->status == 0){
            $licenseKey->user_id = 0;
        }
        $licenseKey->save();

        $notify[] = ['success', 'Key Successfully'];
        return back()->withNotify($notify);
    }

    public function search(Request $request){
        $request->validate([
            'search' => ['required','string','max:255'],
        ]);
        $id = $request->id;
        $pageTitle = 'Search results for "'.$request->search.'"';
        $licenseKeys = LicenseKey::orderBy('created_at', 'desc')->with('user')->where('license_key', 'like', "%$request->search%")->paginate(getPaginate());
        return view('admin.license_key.index', compact('pageTitle', 'licenseKeys', 'id'));
    }
}
