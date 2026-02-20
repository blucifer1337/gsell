<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\Device;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Wishlist;
use App\Models\LicenseKey;
use App\Models\Subscriber;
use Illuminate\Support\Arr;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\TopUp;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    // Product
    public function categoryProducts($slug, $id)
    {
        $category = Category::find($id);
        $products = Product::orderBy('created_at', 'desc')->whereCategoryId($id)->paginate(getPaginate());
        $pageTitle = $category->name;
        return view($this->activeTemplate . 'category', compact('products', 'pageTitle'));
    }

    public function products($type = null)
    {
        if (!is_null($type)) {

            $categories = Category::where('is_menu_item', 1)->get();
            $devices = Device::where('is_menu_item', 1)->get();
            $platforms = Platform::where('is_menu_item', 1)->get();
            $genres = Genre::where('is_menu_item', 1)->get();

            if ($type == 'discounts') {
                $pageTitle = 'Grab what you want before stock runs out';
                $products = Product::orderBy('updated_at', 'desc')
                    ->with(['category', 'device', 'platform', 'genre'])
                    ->where('discount', '>', '0')
                    ->whereIn('status', [1])
                    ->paginate(getPaginate(16));
            }
            elseif ($type == 'tranding') {
                $pageTitle = 'Tranding';
                $products = Product::orderBy('updated_at', 'desc')
                    ->with(['category', 'device', 'platform', 'genre'])
                    ->whereIsTrending(1)
                    ->whereIn('status', [1])
                    ->paginate(getPaginate(16));
            }
            elseif ($type == 'popular') {
                $pageTitle = 'Most Popular';
                $products = Product::orderBy('updated_at', 'desc')
                    ->with(['category', 'device', 'platform', 'genre'])
                    ->whereIn('status', [1])
                    ->paginate(getPaginate(16));
            }
            elseif ($type == 'giftcard') {
                $pageTitle = 'Gift Cards';
                $products = Product::orderBy('updated_at', 'desc')
                    ->whereCategoryId(3)
                    ->whereIn('status', [1])
                    ->paginate(getPaginate(16));
            }
            elseif ($type == 'shop') {
                $pageTitle = 'Shop';
                $products = Product::orderBy('updated_at', 'desc')
                    ->with(['category', 'device', 'platform', 'genre'])
                    ->whereIn('status', [1])
                    ->paginate(getPaginate(16));
            }
            elseif ($type == 'topups') {
                $pageTitle = 'Top Up';
                $topUps = TopUp::orderBy('updated_at', 'desc')
                    ->whereIn('status', [1])
                    ->paginate(getPaginate(16));
                return view($this->activeTemplate . 'topup.index', compact('pageTitle', 'topUps'));
            }
            else {
                $id = 0;
                if ($type == 'playstation') {
                    $pageTitle = 'Playstation';
                    $id = 1;
                } elseif ($type == 'xbox') {
                    $pageTitle = 'Xbox';
                    $id = 2;
                } elseif ($type == 'pc-game') {
                    $pageTitle = 'PC Game';
                    $id = 3;
                }

                $products = Product::orderBy('updated_at', 'desc')
                    ->with(['category', 'device', 'platform', 'genre'])
                    ->whereIn('category_id', [1, 2, 5, 6])
                    ->where('device_id', $id)
                    ->whereIn('status', [1, 2])
                    ->paginate(getPaginate(16));
            }
            return view($this->activeTemplate . 'products', compact('products', 'pageTitle', 'categories', 'devices', 'platforms', 'genres'));
        }
    }

    public function devices($id, $name)
    {
        $categories = Category::where('is_menu_item', 1)->get();
        $devices = Device::where('is_menu_item', 1)->get();
        $platforms = Platform::where('is_menu_item', 1)->get();
        $genres = Genre::where('is_menu_item', 1)->get();
        $deviceName = Device::where('id', $id)->where('is_menu_item', 1)->first();
        $pageTitle = $deviceName->name;

        $products = Product::orderBy('updated_at', 'desc')
            ->with(['category', 'device', 'platform', 'genre'])
            ->whereIn('category_id', [1, 2, 5, 6])
            ->where('device_id', $id)
            ->whereIn('status', [1, 2])
            ->paginate(getPaginate(16));

        return view($this->activeTemplate . 'products', compact('products', 'pageTitle', 'categories', 'devices', 'platforms', 'genres'));
    }

    public function productDetails($slug, $id)
    {
        $product = Product::with(['category', 'device', 'platform', 'genre'])->find($id);
        $productImages = ProductImage::where('product_id', $id)->get();
        $pageTitle = trans('Product Details');
        $reviews = Review::with('user')->where('product_id', $product->id)->paginate(getPaginate());
        $stock = LicenseKey::where('product_id', $id)->whereStatus(0)->count();
        $isWishlist = Wishlist::where('user_id', @auth()->user()->id)->where('product_id', $id)->first();

        return view($this->activeTemplate . 'product_details', compact('product', 'productImages', 'pageTitle', 'stock', 'reviews', 'isWishlist'));
    }

    public function liveSearch(Request $request)
    {
        $products = Product::where('title', 'like', '%' . $request->q . '%')->whereStatus(1)->get();
        return $products->map(function ($product) {
            return [
                'title' => $product->title,
                'link' => route('product', [
                    'slug' => slug($product->title),
                    'id' => $product->id,
                ])
            ];
        });
    }
    // products search
    public function productsSearch(Request $request)
    {

        $categories = $request->input('categories', []);
        $devices = $request->input('devices', []);
        $platforms = $request->input('platforms', []);
        $genres = $request->input('genres', []);
        $search = $request->input('search');

        $query = Product::with(['category', 'device', 'platform', 'genre'])->where('status', 1);

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }
        if (!empty($devices)) {
            $query->whereIn('device_id', $devices);
        }
        if (!empty($platforms)) {
            $query->whereIn('platform_id', $platforms);
        }
        if (!empty($genres)) {
            $query->whereIn('genre_id', $genres);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%");
            });
        }

        $products = $query->get();
        $view = View::make($this->activeTemplate . 'products_filter.products_search', compact('products', 'categories', 'devices', 'platforms', 'genres'))->render();

        return response()->json([
            'html' => $view
        ]);
    }

    // top up
    public function topUpDetails($slug, $id)
    {
        $topUp = TopUp::find($id);
        $pageTitle = trans('Top Up Details');
        $reviews = Review::with('user')->where('product_id', $topUp->id)->paginate(getPaginate());
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();

        return view($this->activeTemplate . 'topup.details', compact('topUp', 'pageTitle', 'gatewayCurrency', 'reviews'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'quantity' => 'required|gt:0'
        ]);

        $id = $request->product_id;
        $stock = LicenseKey::where('product_id', $id)->whereStatus(0)->count();
        $quantity = $request->quantity;

        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);
        $discountedPrice = $product->price - ($product->price * $product->discount / 100);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->title,
                "quantity" => $quantity,
                "price" => ($product->discount != 0) ? $discountedPrice : $product->price,
                "image" => $product->image,
            ];
        }

        // Calculate total quantity
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        // Check available quantity
        if ($totalQuantity > $stock) {
            return response()->json(['error' => 'Product out of stock'], 422);
        }

        session()->put('cart', $cart);
        $cartItemCount = count((array) session('cart'));



        return response()->json([
            'message' => 'Product added to cart',
            'cartItemCount' => $cartItemCount
        ], 200);
    }

    // getcart
    public function getCart()
    {
        $pageTitle = "Your Cart";
        return response()->json([
            'message' => 'Cart List',
            'items' => session()->get('cart'),
            'html' => view($this->activeTemplate . 'partials.cart_content', ['items' => (array)session()->get('cart')])->render()
        ], 200);
    }

    // update quantity
    public function updateQuantity(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');

        if ($productId && $quantity) {
            $cart = session()->get('cart');
            $cart[$productId]["quantity"] = $quantity;
            session()->put('cart', $cart);
        }

        $product = Product::findOrFail($productId);
        if (isset($product->discount)) {
            $discount = $product->price - ($product->price * $product->discount / 100);
            $totalAmount = $quantity * $discount;
        } else {
            $totalAmount = $quantity * $product->price;
        }

        $formattedTotalAmount = number_format($totalAmount, 2);

        return response()->json([
            'totalAmount' => $formattedTotalAmount,
            'quantity' => $quantity,

        ]);
    }

    // remove cart
    public function removeCartItem(Request $request)
    {
        $productId = $request->input('productId');
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $cartItemCount = count((array) session('cart'));

        return response()->json([
            'message' => 'Product removed from the cart',
            'cartItemCount' => $cartItemCount
        ]);
    }
    // checkout
    public function getCheckout()
    {
        if (empty(session('cart'))) {
            $notify[] = ['error', 'at least one product add to cart'];
            return back()->withNotify($notify);
        }

        $pageTitle = "Checkout";
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        return view($this->activeTemplate . 'user.cart.checkout', compact('gatewayCurrency', 'mobileCode', 'pageTitle'));
    }

    //add to wish list
    public function addToWishList(Request $request)
    {

        $productId = $request->product_id;
        if (auth()->check()) {
            $userId = auth()->id();
            $wishlist = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

            if (isset($wishlist)) {
                return response()->json(['error' => 'Product already exists in your wishlist']);
            }

            $wishlist = new Wishlist();
            $wishlist->user_id = $userId;
            $wishlist->product_id = $productId;
            $wishlist->save();
            $wishlistCount = Wishlist::where('user_id', $userId)->count();

            return response()->json([
                'message' => 'Product added to wishlist',
                'wishlistCount' => $wishlistCount
            ], 200);
        }

        return response()->json(['error' => 'Please log in to your account']);
    }

    public function blog()
    {
        $pageTitle = 'Blog';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->firstOrFail();
        $blogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(getPaginate(6));
        return view($this->activeTemplate . 'blog', compact('sections', 'blogs', 'pageTitle'));
    }

    public function blogDetails($slug, $id)
    {
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        $latests = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->limit(5)->get();
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'latests'));
    }

    public function subscribe(Request $request)
    {

        $request->validate([
            'email' => 'required|unique:subscribers',
        ]);

        $subscribe = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();

        $notify[] = ['success', 'You have successfully subscribed to the Newsletter'];
        return back()->withNotify($notify);
    }

    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
}
