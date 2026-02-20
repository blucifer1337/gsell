@php
    $content = getContent('gift_card.content', true);
    $giftCards = App\Models\Product::orderBy('updated_at', 'desc')
        ->whereCategoryId(3)
        ->whereStatus(1)
        ->paginate(getPaginate(9));
    $firstAd = App\Models\Ad::where('ad_code', 4)->first();
@endphp

<section class="gift-section py-80">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <h6 class="fw-bold">{{ __($content->data_values->title) }}</h6>
            @foreach ($giftCards as $giftCard)
                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <a href="{{ route('product', ['slug' => slug($giftCard->title), 'id' => $giftCard->id]) }}">
                            <div class="gift-card">
                                <div class="thumb">
                                    <img src="{{ getImage(getFilePath('product') . '/' . $giftCard->poster) }}"
                                        alt="gift_card-image">
                                </div>
                                <div class="content">
                                    <h6 class="title">
                                        @if (strlen(__($giftCard->title)) > 30)
                                            {{ substr(__($giftCard->title), 0, 77) . '...' }}
                                        @else
                                            {{ __($giftCard->title) }}
                                        @endif
                                    </h6>
                                    <div class="rating-wrap">
                                        @php
                                        $averageRatingHtml = avgRating($giftCard->id);
                                        echo $averageRatingHtml['ratingHtml'];
                                        @endphp
                                        <p class="avg">({{__( $averageRatingHtml['reviewCount'])}})</p>
                                    </div>
                                    <div class="price-wrap">
                                        @if ($giftCard->discount > 0)
                                            <p class="price">
                                                {{ $general->cur_sym }}{{ showAmount($giftCard->final_amount) }}</p>
                                            <span class="dis-price">
                                                 {{  $general->cur_sym }}{{ showAmount($giftCard->price) }}
                                            </span>
                                        @else
                                            <p class="price">{{ $general->cur_sym }}{{ showAmount($giftCard->price) }}</p>
                                        @endif
                                        @if ($giftCard->discount > 0)
                                        @php
                                            $saveAmount = $product->price - $product->final_amount;
                                        @endphp
                                        <span class="dis-tag">-{{__($giftCard->discount)}}%</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($giftCards->hasPages())
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-content">
                        <div class="title-wrap d-flex justify-content-end mt-4">
                            <a href="{{ route('products', 'giftcard') }}" class="btn btn--base text-end">@lang('See More...')</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($firstAd)
                <!-- ad image start -->
                <div class="long-add-wrap mt-2">
                    <div class="long-add-wrap--thumb text-center">
                        <a href="{{ @$firstAd->link }}" target="_blank">
                            <img src="{{ getImage(getFilePath('adImage') . '/' . @$firstAd->image) }}" alt="">
                        </a>
                    </div>
                </div>
            @else
                <!-- ad image end -->
            @endif
    </div>
</section>
