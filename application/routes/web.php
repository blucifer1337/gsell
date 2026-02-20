<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function () {
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');

    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    //blog
    Route::get('/blog','blog');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');


    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
     // subscriber
    Route::post('/subscribe','subscribe')->name('subscribe');

    // product
    Route::get('category/{slug}/{id}', 'categoryProducts')->name('category.products');
    Route::get('products/{type}', 'products')->name('products');
    Route::get('product/{slug}/{id}', 'productDetails')->name('product');
    Route::get('product/search', 'liveSearch')->name('product.live.search');
    Route::get('product/items/search/all', 'productsSearch')->name('product.search.items.all');

    // top up
    Route::get('index/{type}', 'products')->name('topups');
    Route::get('topup/{slug}/{id}', 'topUpDetails')->name('topup');


    Route::get('device/{id}/{slug}', 'devices')->name('devices');

    // addToCart
    Route::get('/cart/add/', 'addToCart')->name('cart.add');
    // cart page
    Route::get('/cart/list','getCart')->name('get.cart');
    // update cart
    Route::get('/update/quantity', 'updateQuantity');
    // remove cart item
    Route::get('/remove/cart/item', 'removeCartItem')->name('remove.cart');
    // add to wishlist
    Route::get('/wishlist/add', 'addToWishList')->name('wishlist.add');
    // checkout
    Route::get('/product/checkout','getCheckout')->name('get.checkout');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});


