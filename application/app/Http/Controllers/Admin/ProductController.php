<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Device;
use App\Models\Genre;
use App\Models\LicenseKey;
use App\Models\Order;
use App\Models\Platform;
use App\Models\Product;
use App\Models\ProductImage;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $pageTitle = 'Products';
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'products'));
    }

    public function create()
    {

        $pageTitle = 'Publish a new product';
        $categories = Category::all();
        $devices = Device::all();
        $platforms = Platform::all();
        $genres = Genre::all();
        return view('admin.product.create', compact('pageTitle', 'categories', 'devices', 'platforms', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'numeric|nullable|between:0,100',
            'category_id' => 'required|integer',
            'description' => 'required',
            'short_description' => 'required|string|max:130',
            'status' => 'required',
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'poster' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
        $purifier = new \HTMLPurifier();
        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->is_trending = $request->is_trending;
        $product->discount = $request->discount;
        $product->version = $request->version;
        $product->category_id = $request->category_id;
        $product->device_id = $request->device_id;
        $product->platform_id = $request->platform_id;
        $product->genre_id = $request->genre_id;
        $product->description = $purifier->purify($request->description);
        $product->short_description = $purifier->purify($request->short_description);
        $product->minimum = $purifier->purify($request->minimum);
        $product->recommended = $purifier->purify($request->recommended);
        $product->status = $request->status;

        if ($request->discount) {
            $product->discount = $request->discount;
            $product->final_amount = $request->price - ($request->discount / 100) * $request->price;
        } else {
            $product->final_amount = $request->price;
        }

        if ($request->hasFile('image')) {
            try {
                $product->image = fileUploader($request->image, getFilePath('product'), getFileSize('product'), null, '256x224');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('poster')) {
            try {
                $product->poster = fileUploader($request->poster, getFilePath('product'), getFileSize('product_poster'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $product->save();

        if ($request->images) {
            foreach ($request->images as $image) {
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = fileUploader($image, getFilePath('product'), getFileSize('product'));
                $productImage->save();
            }
        }
        $notify[] = ['success', 'Product published successfully'];
        return to_route('admin.product.index')->withNotify($notify);
    }

    public function Edit($id)
    {
        $product = Product::find($id);
        $productImages = ProductImage::where('product_id', $id)->get();
        $pageTitle = 'Edit ' . $product->name . ' product';
        $categories = Category::all();
        $devices = Device::all();
        $platforms = Platform::all();
        $genres = Genre::all();
        return view('admin.product.edit', compact('pageTitle', 'product', 'categories', 'devices', 'platforms', 'genres', 'productImages'));
    }

    //-----------Product Update-----------\\
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'numeric|nullable|between:0,100',
            'category_id' => 'required|integer',
            'description' => 'required',
            'short_description' => 'required',
            'status' => 'required',
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'poster' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
        $purifier = new \HTMLPurifier();
        $product = Product::find($id);
        $product->title = $request->title;
        $product->price = $request->price;
        $product->is_trending = $request->is_trending;
        $product->discount = $request->discount;
        $product->version = $request->version;
        $product->category_id = $request->category_id;
        $product->device_id = $request->device_id;
        $product->platform_id = $request->platform_id;
        $product->genre_id = $request->genre_id;
        $product->description = $purifier->purify($request->description);
        $product->short_description = $request->short_description;
        $product->minimum = $purifier->purify($request->minimum);
        $product->recommended = $purifier->purify($request->recommended);
        $product->status = $request->status;

        $oldImageIds = is_null($request->image_id) ? [] : $request->image_id;
        $updatedImages = $request->images;
        $productImageIds = $product->productImages->pluck('id')->toArray();

        if ($request->discount) {
            $product->discount = $request->discount;
            $product->final_amount = $request->price - ($request->discount / 100) * $request->price;
        } else {
            $product->final_amount = $request->price;
        }

        if ($request->hasFile('image')) {
            try {
                $old = $product->image;
                $product->image = fileUploader($request->image, getFilePath('product'), getFileSize('product'), $old, '256x224');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('poster')) {
            try {
                $old = $product->poster;
                $product->poster = fileUploader($request->poster, getFilePath('product'), getFileSize('product_poster'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $product->save();

        if (!is_null($updatedImages)) {
            foreach ($updatedImages as $id => $image) {
                if (in_array($id, $oldImageIds)) {
                    $productImage = ProductImage::find($id);
                    if ($productImage) {
                        $productImage->image = fileUploader($image, getFilePath('product'), getFileSize('product'));
                        $productImage->save();
                    }
                } else {
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = fileUploader($image, getFilePath('product'), getFileSize('product'));
                    $productImage->save();
                }
            }
        }

        foreach ($productImageIds as $imageId) {
            if (!in_array($imageId, $oldImageIds)) {
                $productImage = ProductImage::find($imageId);
                if ($productImage) {
                    $productImage->delete();
                }
            }
        }

        $notify[] = ['success', 'Product updated successfully'];
        return back()->withNotify($notify);
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => ['required', 'string', 'max:255'],
        ]);
        $pageTitle = 'Search results for "' . $request->search . '"';
        $products = Product::orderBy('created_at', 'desc')->where('title', 'like', "%$request->search%")->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'products'));
    }

    public function licenseKeyDispatch(Request $request)
    {
        $orders = $request->orders;
        if (!$request->filled('orders')) {
            $notify[] = ['error', 'Pleas select any Item'];
            return back()->withNotify($notify);
        } else {
            $orders = Order::with('products')->whereIn('id', $request->orders)->get();
            foreach ($orders as $order) {
                $products = $order->products;
                foreach ($products as $product) {
                    $product->load(['licenseKeys']);
                    $licenseKeys = $product->licenseKeys;
                    $licenseKeys = $licenseKeys->filter(function ($licenseKey) {
                        return $licenseKey->status == 0;
                    })->values();

                    if ($licenseKeys->isNotEmpty()) {
                        foreach ($licenseKeys as $key => $licenseKey) {
                            if ($order && $order->status == Order::STATUS_PROCESS) {
                                $order->status = Order::STATUS_COMPLETED;
                                $order->save();
                                $lKey = LicenseKey::whereProductId($product->id)->whereStatus(0)->first();
                                if ($lKey) {
                                    $lKey->user_id = $order->user_id;
                                    $lKey->order_id = $order->id;
                                    $lKey->sell_amount = $product->amount;
                                    $lKey->sold_at = now();
                                    $lKey->status = 1;
                                    $lKey->save();
                                }
                            } else {
                                $notify[] = ['error', 'Order Deposit not accepted'];
                                return back()->withNotify($notify);
                            }
                        }
                    } else {
                        $notify[] = ['error', 'Please enter product license key first'];
                        return back()->withNotify($notify);
                    }
                }
            }
        }
    }
}
