<?php

namespace App\Http\Controllers\User;

use App\Models\Form;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\Wishlist;
use App\Lib\FormProcessor;
use App\Models\Transaction;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Models\LicenseKey;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();
        $pageTitle = 'My Orders';
        $orders = Order::with('products')->whereUserId($user->id)->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'orders'));
    }

    public function profile()
    {
        $pageTitle = 'My Profile';
        $user = auth()->user();
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.profile', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function changeProfileImage(Request $request, $id)
    {
        $this->validate($request, [
            'file_upload' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $user = auth()->user();

        if ($request->hasFile('file_upload')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->file_upload, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $user->save();
        $notify[] = ['success', 'Profile photo has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function orderDetails($id)
    {
        $user = auth()->user();
        $pageTitle = 'My Orders';
        $order = Order::find($id);
        $licenseKeys = LicenseKey::where('order_id', $id)->with(['product'])->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order_datils', compact('pageTitle', 'order', 'licenseKeys'));
    }


    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx', $request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('user_id', auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type', $request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == 2) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act', 'kyc')->first();
        return view($this->activeTemplate . 'user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate . 'user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->first();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);
        $user = auth()->user();
        $user->kyc_data = $userData;
        $user->kv = 2;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ];
        $user->reg_step = 1;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    //review store
    public function reviewStore(Request $request)
    {

        $auth = auth()->user();

        $product_id = $request->product_id;

        $existingReview = Review::where('user_id', $auth->id)->where('product_id', $product_id)->first();

        if ($existingReview) {
            $notify[] = ['error', 'You have already submitted a review for this product'];
            return back()->withNotify($notify);
        }

        $isOrder = Order::where('user_id', $auth->id)->where('status', 1)->with('products')->get();


        if ($isOrder->isEmpty()) {
            $notify[] = ['error', 'Please purchase this product first before reviewing it'];
            return back()->withNotify($notify);
        }

        $orderedProductIds = $isOrder->pluck('products.*.id')->flatten()->toArray();

        if (!in_array($product_id, $orderedProductIds)) {
            $notify[]= ['error', 'Please purchase this product first before reviewing it'];
            return back()->withNotify($notify);
        }

        $request->validate([
            'message' => 'required',
        ]);

        $review = new Review();
        $review->product_id = $request->product_id;
        $review->user_id =  $auth->id;
        $review->message = $request->message;
        $review->rating = $request->rating;
        $review->save();
        $notify[] = ['success', 'Review submitted successfully'];
        return back()->withNotify($notify);
    }

    // get wishlist page
    public function getWishList()
    {
        $pageTitle = 'Wishlists';
        $wishlists = Wishlist::with(['product', 'product.productImages'])
            ->latest()
            ->paginate(getPaginate());


        return view($this->activeTemplate . 'user.wishlist.index', compact('pageTitle', 'wishlists'));
    }
    // remove wishlist
    public function removeWishList(Request $request)
    {
        $wishlistId = $request->input('wishlist_id');

        $wishlist = Wishlist::where('user_id', auth()->user()->id)->findOrFail($wishlistId);
        $wishlist->delete();

        $wishlistsCount = Wishlist::where('user_id', auth()->user()->id)->count();

        return response()->json([
            'message' => 'Wishlist item removed from wishlists',
            'wishlistsCount' => $wishlistsCount,
        ]);
    }
}
