@php
    $content = getContent('hero.content', true);
    $languages = App\Models\Language::all();
    $pages = App\Models\Page::all();
    $categories = App\Models\Category::whereIsMenuItem(1)->get();
    $products = App\Models\Product::whereStatus(1)
        ->limit(5)
        ->orderBy('id', 'desc')
        ->get();
    $sProduct = $products->where('discount', '>', '0')->first();
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
@if($products && $sProduct)
    <!-- < Hero Section -->
    <section class="hero bg--img"
        style="background-image: url({{ getImage(getFilePath('frontend') . '/hero/' . $content->data_values->background_image) }});">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-6 d-flex align-items-center">
                    <div class="hero-left-content">
                        <div class="product-details">
                            <a href="{{ route('user.paynow', $sProduct->id) }}"
                                class="hero-title animate__animated animate__fadeInUp">
                                @if (strlen(__($sProduct->title)) > 20)
                                    {{ substr(__($sProduct->title), 0, 33) . '...' }}
                                @else
                                    {{ __($sProduct->title) }}
                                @endif
                            </a>
                            <div class="rating-wrap">
                                @php
                                    $averageRatingHtml = avgRating($sProduct->id);
                                    echo $averageRatingHtml['ratingHtml'];
                                @endphp
                                <p class="avg">({{ __($averageRatingHtml['reviewCount']) }})</p>
                            </div>
                            <div class="price-wrap wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                                <div class="price-text-wrap">
                                    @if ($sProduct->discount > 0)
                                        <h2 class="price me-1">
                                            {{ $general->cur_sym }}{{ showAmount($sProduct->final_amount) }}</h2>
                                        <h4 class="less">{{ $general->cur_sym }}{{ showAmount($sProduct->price) }}</h4>
                                    @else
                                        <h2 class="price">{{ $general->cur_sym }}{{ showAmount($sProduct->price) }} </h2>
                                    @endif
                                </div>
                            </div>
                            <div class="button-wrap wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                <a class="btn btn--base hero_btn"
                                    href="{{ route('user.paynow', $sProduct->id) }}">@lang('Buy Now')</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-6 col-lg-6 col-md-6">
                    <div class="hero-right">
                        <div class="hero-thumb">
                            <a href="{{ route('user.paynow', $sProduct->id) }}">
                                <img src="{{ getImage(getFilePath('product') . '/' . $sProduct->poster) }}" alt="...">
                                @if ($sProduct->discount > 0)
                                    @php
                                        $saveAmount = $sProduct->price - $sProduct->final_amount;
                                    @endphp
                                    <div class="tag top_image_bounce_2">
                                        <p>@lang('Save') {{ $general->cur_sym }}{{ showAmount($saveAmount) }}</p>
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- hero key card -->
                <div class="row gy-4 justify-content-center mt-25">
                    @foreach ($products->slice(1, 4) as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('product', ['slug' => slug($product->title), 'id' => $product->id]) }}">
                                <div class="hero-game-card">
                                    <div class="thumb">
                                        <img src="{{ getImage(getFilePath('product') . '/' . $product->poster) }}"
                                            alt="...">
                                    </div>
                                    <div class="content">
                                        <h6 class="title">
                                            @if (strlen(__($product->title)) > 20)
                                                {{ substr(__($product->title), 0, 32) . '.' }}
                                            @else
                                                {{ __($product->title) }}
                                            @endif
                                        </h6>
                                        <p class="price">{{ $general->cur_sym }}{{ showAmount($product->final_amount) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    <!--  Hero Section End -->
    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
