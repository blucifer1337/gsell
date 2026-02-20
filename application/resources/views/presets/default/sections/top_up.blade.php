@php
    $content = getContent('top_up.content', true);
    $games = App\Models\TopUp::orderBy('updated_at', 'desc')
        ->whereStatus(1)
        ->limit(6)
        ->get();
@endphp
<!-- PRODUCT AREA START  -->

<section class="weakly-section py-80 bg--img" style="background: url({{ getImage(getFilePath('frontend') . '/top_up/' . $content->data_values->background_image) }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content-2">
                    <div class="title-wrap">
                        <h6 class="title">{{ __($content->data_values->title) }}</h6>
                        <a href="{{ route('topups', 'topups') }}" class="btn btn--base">@lang('View All')</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            @foreach ($games as $game)
            @php
                $data = collect($game->services_data)->count();
            @endphp
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <a class="card-link-wrapper" href="{{ route('topup', ['slug' => slug($game->name), 'id' => $game->id]) }}">
                    <div class="game-card">
                        @if ($game->discount > 0)
                            <div class="dis-tag">
                                <p>-{{ $game->discount }}%</p>
                            </div>
                        @endif
                        <div class="thumb">
                            <img src="{{ getImage(getFilePath('topup') . '/' .'thumb_'. $game->image) }}" alt="product_image">
                        </div>
                        <div class="content">
                            <h6 class="title">
                                @if (strlen(__($game->name)) > 30)
                                    {{ substr(__($game->name), 0, 55) . '..' }}
                                @else
                                    {{ __($game->name) }}
                                @endif
                            </h6>
                            <div class="price-wrap">
                                <p class="price">{{$data}} @lang(' Items')</p>
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
