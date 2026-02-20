@php
    $products = App\Models\Product::orderBy('rating', 'desc')
        ->limit(4)
        ->get();
    $reviews = App\Models\Review::where('product_id', $product->id)
        ->with('user')
        ->get();
    $firstAd = App\Models\Ad::where('ad_code', 7)->first();
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- < product details  -->
    <section class="product-details pb-60">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-9">
                    <div class="row mb-3">
                        <div class="col-xl-4 col-lg-5">
                            <div class="product-thumb-wrap">
                                <div class="product-details-left__content">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show"  role="tabpanel"
                                            aria-labelledby="tab0" tabindex="0">
                                            <div class="product-details-left__thumb1">
                                                <img src="{{ getImage(getFilePath('product') . '/' . $product->poster) }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="details-right-content">
                                <div class="product-name">
                                    <h2 class="title">
                                        @if (strlen(__($product->title)) > 30)
                                            {{ substr(__($product->title), 0, 62) . '...' }}
                                        @else
                                            {{ __($product->title) }}
                                        @endif
                                    </h2>
                                </div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rating-wrap">
                                        @php
                                            $averageRatingHtml = avgRating($product->id);
                                            echo $averageRatingHtml['ratingHtml'];
                                        @endphp
                                        <p class="avg">({{ __($averageRatingHtml['reviewCount']) }})</p>
                                    </div>
                                    <div class="stock-status">
                                        @if ($stock == 0 && $product->status == 2)
                                            <h4>@lang('Please Pre Order This Product')</h4>
                                        @elseif($stock > 0)
                                            <span>@lang('In Stock ')</span>
                                        @else
                                            <span>@lang('Out Of Stock')</span>
                                        @endif
                                    </div>
                                    <button class="add-fav-btn active-fav addToWishList" data-id="{{ $product->id }}">
                                        <i class="{{ isset($isWishlist) ? 'fas fa-heart' : 'far fa-heart'}}"></i></button>
                                </div>
                                <div class="price-wrap">


                                    <div class="price">
                                        @if ($product->discount > 0)
                                        <span class="discount-price">
                                            {{ $general->cur_sym }}{{ showAmount($product->price) }}
                                        </span>
                                            <p class="main-price">
                                                {{ $general->cur_sym }}{{ showAmount($product->final_amount) }} </p>

                                        @else
                                            <p class="main-price">{{ $general->cur_sym }}{{ showAmount($product->price) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="subtitle">
                                    @php echo $product->short_description; @endphp
                                </div>
                                <div class="key-details-wrap">
                                    <div class="row align-items-start gy-4">
                                        <div class="col-xl-12 col-lg-12 d-flex align-items-center gap-3">
                                            <div class="key platform">
                                                <span>@php echo __(@$product->platform?->icon) @endphp</span>
                                                <p>{{ __(@$product->platform?->name) }}</p>
                                            </div>
                                            <div class="key brand">
                                                <span>@php echo __(@$product->device?->icon) @endphp</span>
                                                <p>{{ __(@$product->device?->name) }}</p>
                                            </div>
                                            <div class="key version">
                                                <span><i class="fas fa-globe"></i></span>
                                                <p>{{ __(@$product->version) }}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="cta-btn-wrap">
                                    <div class="quantity_box diplay_flex">
                                        <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                        <input class="count-input" type="number" id="quantityInput" value="1"
                                            readonly>
                                        <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                    </div>

                                    @if ($product->status == 2)
                                        @if ($product->hasPreOrder() == 1)
                                            <button class="btn btn--base me-2 pre_order"
                                                data-preorder="{{ $product->hasPreOrder() }}">
                                                @lang('Order Now')
                                            </button>
                                        @else
                                            <a  class="btn btn--base"
                                                href="{{ route('user.paynow', $product->id) }}"
                                                data-preorder="{{ $product->hasPreOrder() }}">@lang('Order Now')</a>
                                        @endif
                                    @elseif ($stock > 0)
                                        <a class="btn btn--base"
                                            href="{{ route('user.paynow', $product->id) }}">@lang('Buy Now')</a>
                                    @endif
                                    <button class="btn btn--base outline  addToCart"
                                        data-id="{{ $product->id }}">@lang('Add to Cart')</button>


                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- tabpanel -->
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs coustome-tabs mb-2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="btn btn--base outline-2 active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab"
                                        aria-selected="true">@lang('Description')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="btn btn--base outline-2" id="system-tab" data-bs-toggle="tab"
                                        data-bs-target="#system" type="button" role="tab" aria-selected="false"
                                        tabindex="-1">@lang('System Requirements')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="btn btn--base outline-2" id="review-tab" data-bs-toggle="tab"
                                        data-bs-target="#review" type="button" role="tab" aria-selected="false"
                                        tabindex="-1">@lang('Reviews')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="btn btn--base outline-2" id="gallery-tab" data-bs-toggle="tab"
                                        data-bs-target="#gallery" type="button" role="tab" aria-selected="false"
                                        tabindex="-1">@lang('Gallery')</button>
                                </li>
                            </ul>
                            <div class="tab-content ">
                                <div class="tab-pane fade active show" id="description" role="tabpanel"
                                    aria-labelledby="description">
                                    <div class="description show-list-style mt-3">
                                        @php echo $product->description; @endphp
                                    </div>
                                </div>
                                <!-- System Requiremnets -->
                                <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system">
                                    <div class="sytem-req mt-3">
                                        <h6 class="fw-bold mb-4">@lang('System Requirements')</h6>

                                        <div class="row gy-4 mt-4">
                                            <div class="col-lg-8">
                                                <div class="table-wrap product-details-table">
                                                    @if ($product->recommended != null && $product->minimum != null)
                                                        <h6 class="title fw-bold">@lang('Minimum')</h6>
                                                        @php echo $product->minimum; @endphp
                                                        <h6 class="title fw-bold mt-5">@lang('Recommended')</h6>
                                                        @php echo $product->recommended; @endphp
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Reviews -->
                                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review">
                                    <div class="review mt-3">
                                        <h6 class="fw-bold mb-4">@lang('Reviews & Ratings')</h6>
                                        <div class="row gy-4">
                                            @forelse ($reviews as $review)
                                                <div class="col-lg-6">
                                                    <div class="testimonial-card review mb-4">
                                                        <div class="user-info">
                                                            <div class="user-thumb">
                                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . $review->user->image) }}" alt="...">
                                                            </div>
                                                            <div class="user-description">
                                                                <h6 class="user-name">
                                                                    {{ $review->user->firstname . ' ' . $review->user->lastname }}
                                                                </h6>
                                                                <p class="user-title">@lang('Customer,')
                                                                    {{ $review->user->address->country }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <p class="discription">
                                                                @if (strlen(__($review->message)) > 119)
                                                                    {{ substr(__($review->message), 0, 190) . '...' }}
                                                                @else
                                                                    {{ __($review->message) }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="rating-wrap">
                                                            <div class="rating">
                                                                @php echo getRating($review->rating); @endphp
                                                            </div>
                                                            <p class="number">({{ $review->rating }})</p>
                                                        </div>

                                                    </div>
                                                </div>
                                            @empty
                                                <div>
                                                    <p class="text-muted text-center">@lang('No Reviews Found')
                                                    </p>
                                                </div>
                                            @endforelse

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class=".contactus-form">
                                            <div class="account-form__content mb-4">
                                                <div class="review-wrap d-flex align-items-center mb-2">
                                                    <p class="stock  fw-bold">@lang('Giving Rating:')</p>
                                                    <ul class="rating-list justify-content-center">
                                                        <li class="rating-list__item rating-list__item_m"><i
                                                                class="fas fa-star"></i></li>
                                                        <li class="rating-list__item rating-list__item_m"><i
                                                                class="fas fa-star"></i></li>
                                                        <li class="rating-list__item rating-list__item_m"><i
                                                                class="fas fa-star"></i></li>
                                                        <li class="rating-list__item rating-list__item_m"><i
                                                                class="fas fa-star"></i></li>
                                                        <li class="rating-list__item rating-list__item_m"><i
                                                                class="fas fa-star"></i></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="review-form-wrap">
                                                <form action="{{ route('user.reviews.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <div class="row gy-3">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <textarea class="form--control" name="message" placeholder="@lang('Message')" id="message"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group bottom-review">
                                                                <label class="form--label"> @lang('Rating:') </label>
                                                                <div class="rating-stars">
                                                                    <input type="hidden" name="rating" id="rating"
                                                                        value="0">
                                                                    <i class="far fa-star" data-rating="1"></i>
                                                                    <i class="far fa-star" data-rating="2"></i>
                                                                    <i class="far fa-star" data-rating="3"></i>
                                                                    <i class="far fa-star" data-rating="4"></i>
                                                                    <i class="far fa-star" data-rating="5"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <button type="submit" class="btn btn--base">
                                                                @lang('Submit') <i class="fas fa-arrow-right"></i>
                                                                <span style="top: 40.6094px; left: 80px;"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Gallery -->
                                <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery">
                                    <div class="recent-view mt-3">
                                        <h6 class="fw-bold mb-4">@lang('Product Gallery')</h6>
                                        <div class="row gy-4">
                                            <div class="product-thumb-wrap">
                                                <div class="product-details-left__content">
                                                    <div class="tab-content" id="myTabContent">
                                                        <div class="tab-pane fade active show" id="tabpane0"
                                                            role="tabpanel" aria-labelledby="tab0" tabindex="0">
                                                            <div class="product-details-left__thumb">
                                                                @if ($productImages->first())
                                                                    <img id="slide_image"
                                                                        src="{{ getImage(getFilePath('product') . '/' . $productImages->first()->image) }}"
                                                                        alt="">
                                                                @else
                                                                    <img id="slide_image"
                                                                        src="{{ getImage(getFilePath('product') . '/' . $product->image) }}"
                                                                        alt="">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-details-left__nav">
                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        @forelse ($productImages as $productImg)
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link active"
                                                                    id="tab{{ $loop->index }}" data-bs-toggle="tab"
                                                                    data-bs-target="#tabpane{{ $loop->index }}"
                                                                    type="button" role="tab"

                                                                    aria-selected="true" tabindex="-1">
                                                                    <img data-index="{{ $loop->index }}"
                                                                        src="{{ getImage(getFilePath('product') . '/' . $productImg->image) }}"
                                                                        alt="product image">
                                                                </button>
                                                            </li>
                                                        @empty
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link active" id="tab100"
                                                                    data-bs-toggle="tab" data-bs-target="#tabpane100"
                                                                    type="button" role="tab"

                                                                    tabindex="-1">
                                                                    <img data-index="100"
                                                                        src="{{ getImage(getFilePath('product') . '/' . $product->poster) }}"
                                                                        alt="">
                                                                </button>
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tabpanel /> -->
                </div>
                <div class="col-lg-3">


                    <div class="game-search-box">
                        <div class="item-wrap">
                            <h6 class="title mb-4">@lang('Latest')</h6>
                            @foreach ($products as $product)
                                <a href="{{ route('product', ['slug' => slug($product->title), 'id' => $product->id]) }}">
                                    <div class="new-product">
                                        <div class="thumb">
                                            <img src="{{ getImage(getFilePath('product') . '/' . $product->image) }}"
                                                alt="...">
                                        </div>
                                        <div class="content">

                                            <h6 class="name">
                                                @if (strlen(__($product->title)) > 18)
                                                    {{ substr(__($product->title), 0, 33) . '...' }}
                                                @else
                                                    {{ __($product->title) }}
                                                @endif
                                            </h6>

                                            <div class="price-wrap">
                                                @if ($product->discount > 0)
                                                    <p class="price">
                                                        {{ $general->cur_sym }}{{ showAmount($product->final_amount) }}
                                                    </p>
                                                    <span class="text-decoration-line-through">
                                                        {{ $general->cur_sym }}{{ showAmount($product->price) }}
                                                    </span>
                                                @else
                                                    <p class="main-price">
                                                        {{ $general->cur_sym }}{{ showAmount($product->price) }} </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="item-wrap">
                            @if ($firstAd)
                                <!-- ad image start -->
                                <div class="breadcrumb-long-add-wrap">
                                    <div class="long-add-wrap--thumb">
                                        <a href="{{ @$firstAd->link }}" target="_blank">
                                            <img src="{{ getImage(getFilePath('adImage') . '/' . @$firstAd->image) }}"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                            @else
                                <!-- ad image end -->
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product details  /> -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            "use strict"

            //image hover
            $('button>img').hover(function() {
                var image = this;
                $('#slide_image').attr('src', image.src);
            });

            // add to cart
            $(document).on('click', '.addToCart', function() {
                var productId = $(this).data('id');
                var quantity = $('#quantityInput').val();

                $.ajax({
                    url: '{{ route('cart.add') }}',
                    type: 'get',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                    },
                    success: function(response) {
                        if (response.hasOwnProperty('message')) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            updateCartItemCount(response.cartItemCount);
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errorMessage = xhr.responseJSON.error;
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        } else {
                            var errorMessage =
                                'Error occurred while adding the product to cart.';
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        }
                    }
                });
            });

            // update cart
            function updateCartItemCount(count) {
                $('#cartItem').text(count);
            }

            // add to wishlist
            $(document).on('click', '.addToWishList', function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: '{{ route('wishlist.add') }}',
                    type: 'get',
                    data: {
                        product_id: productId,
                    },
                    success: function(response) {

                        if (response.hasOwnProperty('message')) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            updateWishListCount(response.wishlistCount);
                        } else {
                            Toast.fire({
                                icon: 'warning',
                                title: response.error
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage =
                            'Error occurred while adding the product to wishlist.';
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                });
            });

            function updateWishListCount(count) {
                $('#wishlistItem').text(count);
            }

            // check user
            var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            var userId = {{ auth()->user() ? auth()->user()->id : 'null' }};

            // rating set
            $(document).ready(function() {
                "use strict";
                $('.rating-stars i').on('click', function() {
                    var rating = parseInt($(this).data('rating'));
                    $('#rating').val(rating);
                    updateStars(rating);
                });

                $('#rating').on('input', function() {
                    var rating = $(this).val();
                    updateStars(rating);
                });

                // Function to update stars based on the rating value
                function updateStars(rating) {
                    var stars = $('.rating-list__item_m');
                    if (rating >= 1 && rating <= 5) {
                        stars.each(function(index) {
                            if (index < rating) {
                                $(this).html('<i class="fas fa-star"></i>');
                            } else {
                                $(this).html('<i class="far fa-star"></i>');
                            }
                        });
                    } else {
                        $('#rating').val('');
                        stars.html('<i class="far fa-star"></i>');
                    }
                }
            });

            // user's pre order check
            $(document).on('click', '.pre_order', function() {
                var isPreOrder = $(this).data('preorder');
                if (isPreOrder == 1) {
                    Toast.fire({
                        icon: 'error',
                        title: `This product you've already ordered.`
                    });
                }
            });
        });
    </script>
@endpush
