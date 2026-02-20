@php
    $content = getContent('discount.content', true);
    $games = App\Models\Product::orderBy('updated_at', 'desc')
        ->where('discount', '>', '0')
        ->whereStatus(1)
        ->limit(6)
        ->get();
@endphp
<!-- PRODUCT AREA START  -->

<section class="weakly-section py-80 bg--img" style="background: url({{ getImage(getFilePath('frontend') . '/discount/' . $content->data_values->background_image) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content-2">
                    <div class="title-wrap">
                        <h6 class="title">{{ __($content->data_values->title) }}</h6>
                        <a href="{{ route('products', 'discounts') }}" class="btn btn--base">@lang('View All')</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            @foreach ($games as $game)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <a class="card-link-wrapper" href="{{ route('product', ['slug' => slug($game->title), 'id' => $game->id]) }}">
                    <div class="game-card">
                        @if ($game->discount > 0)
                            <div class="dis-tag">
                                <p>-{{ $game->discount }}%</p>
                            </div>
                        @endif
                        <div class="thumb">
                            <img src="{{ getImage(getFilePath('product') . '/' .'thumb_'. $game->image) }}" alt="product_image">
                        </div>
                        <div class="content">
                            <h6 class="title">
                                @if (strlen(__($game->title)) > 30)
                                    {{ substr(__($game->title), 0, 55) . '..' }}
                                @else
                                    {{ __($game->title) }}
                                @endif
                            </h6>
                            <ul>
                                <li>@php echo __(@$game->platform?->icon) @endphp</li>
                                <li>@php echo __(@$game->device?->icon) @endphp</li>
                            </ul>
                            <div class="price-wrap">
                                @if ($game->discount > 0)
                                    <p class="price">
                                        {{ $general->cur_sym }}{{ showAmount($game->final_amount) }} </p>
                                    <span class="dis-price">
                                        {{ $general->cur_sym }}{{ showAmount($game->price) }}
                                    </span>
                                @else
                                    <p class="price">
                                        {{ $general->cur_sym }}{{ showAmount($game->price) }} </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
        </div>
    </div>
</section>

<!-- PRODUCT AREA END  -->
