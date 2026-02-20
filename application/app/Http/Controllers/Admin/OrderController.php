<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\LicenseKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $pageTitle = 'Order List';
        $orders = Order::with('products')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'orders'));
    }


    public function indexPreOrder(Product $product)
    {
        $pageTitle = 'Pre Orders';
        $orders = $product->orders->filter(fn($order) => $order->status !== Order::STATUS_COMPLETED)->paginate(getPaginate());
        return view('admin.order.index_pre_order', compact('pageTitle', 'product', 'orders'));
    }


    public function orderDetails($id)
    {
        $order = Order::find($id);
        $pageTitle = 'Order No: # ' . $order->number;
        $licenseKeys = LicenseKey::where('order_id', $id)->with(['product'])->paginate(getPaginate());
        return view('admin.order.order_details', compact('pageTitle', 'order', 'licenseKeys'));
    }
}
