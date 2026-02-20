@php
    $firstAd = App\Models\Ad::where('ad_code', 6)->first();
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- PRODUCT AREA START  -->
    <section class="search-section pb-60">
        <div class="container">
            <div class="row gy-4">
                <!-- search box -->
                <div class="col-xl-3 col-lg-4">
                    <div class="game-search-box">
                        <div class="search-box-wrap">
                            <input class="form--control" id="searchValue" name="search" type="text" autocomplete="off"
                                placeholder="@lang('Search')">
                        </div>
                        <div class="item-wrap border-bottom mt-4">
                            <h6 class="title mb-4">@lang('Category')</h6>
                            @foreach ($categories as $item)
                                <div class="form--check mb-20">
                                    <input class="form-check-input filter-by-category"
                                        name="categories_{{ $loop->iteration }}" type="checkbox" value="{{ $item->id }}"
                                        id="categories_{{ $loop->iteration }}">
                                    <label for="categories_{{ $loop->iteration }}"
                                        class="form-check-label">{{ $item->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="item-wrap border-bottom">
                            <h6 class="title mb-4">@lang('Device')</h6>
                            @foreach ($devices as $item)
                                <div class="form--check mb-20">
                                    <input class="form-check-input filter-by-device" name="devices_{{ $loop->iteration }}"
                                        type="checkbox" value="{{ $item->id }}" id="devices_{{ $loop->iteration }}">
                                    <label for="devices_{{ $loop->iteration }}"
                                        class="form-check-label">{{ $item->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="item-wrap border-bottom">
                            @if ($firstAd)
                                <!-- ad image start -->
                                <div class="breadcrumb-long-add-wrap mb-3">
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
                        <div class="item-wrap border-bottom">
                            <h6 class="title mb-4">@lang('Platform')</h6>
                            @foreach ($platforms as $item)
                                <div class="form--check mb-20">
                                    <input class="form-check-input filter-by-platfrom"
                                        name="platforms_{{ $loop->iteration }}" type="checkbox"
                                        value="{{ $item->id }}" id="platforms_{{ $loop->iteration }}">
                                    <label for="platforms_{{ $loop->iteration }}"
                                        class="form-check-label">{{ $item->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="item-wrap border-bottom">
                            <h6 class="title mb-4">@lang('Genre')</h6>
                            @foreach ($genres as $item)
                                <div class="form--check mb-20">
                                    <input class="form-check-input filter-by-genre" name="genres_{{ $loop->iteration }}"
                                        type="checkbox" value="{{ $item->id }}" id="genres_{{ $loop->iteration }}">
                                    <label for="genres_{{ $loop->iteration }}"
                                        class="form-check-label">{{ $item->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- search box end -->

                <div class="col-xl-9 col-lg-8 main-content">
                    <div class="row gy-4">
                        @forelse ($products as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <a class="card-link-wrapper"
                                    href="{{ route('product', ['slug' => slug($product->title), 'id' => $product->id]) }}">
                                    <div class="game-card">
                                        @if ($product->discount > 0)
                                            <div class="dis-tag">
                                                <p>-{{ $product->discount }}%</p>
                                            </div>
                                        @endif
                                        <div class="thumb">
                                            <img src="{{ getImage(getFilePath('product') . '/' . 'thumb_' . $product->image) }}"
                                                alt="...">
                                        </div>
                                        <div class="content">
                                            <h6 class="title">
                                                @if (strlen(__($product->title)) > 30)
                                                    {{ substr(__($product->title), 0, 55) . '...' }}
                                                @else
                                                    {{ __($product->title) }}
                                                @endif
                                            </h6>
                                            <ul>
                                                <li>@php echo __(@$product->platform?->icon) @endphp</li>
                                                <li>@php echo __(@$product->device?->icon) @endphp</li>
                                            </ul>
                                            <div class="price-wrap">
                                                @if ($product->discount > 0)
                                                    <p class="price">
                                                        {{ $general->cur_sym }}{{ showAmount($product->final_amount) }}
                                                    </p>
                                                    <span class="dis-price">
                                                        {{ $general->cur_sym }}{{ showAmount($product->price) }}
                                                    </span>
                                                @else
                                                    <p class="price">
                                                        {{ $general->cur_sym }}{{ showAmount($product->price) }} </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div>
                                <p class="text-muted text-center" colspan="100%">@lang('No Product Found')</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
            <!-- pagination -->
            <div class="row py-3 mt-4">
                <div class="col-lg-12 justify-content-end d-flex">
                    <nav aria-label="Page navigation example">
                        @if ($products->hasPages())
                            {{ paginateLinks($products) }}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- PRODUCT AREA END  -->
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $("#searchValue").on('keyup', function() {

                var categories = [];
                var searchValue = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = $(this).val();

                getFilteredData(categories, devices, platforms, genres, searchValue)

            });

            $("input[type='checkbox'][name^='categories_']").on('click', function() {
                var categories = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = [];
                $('.filter-by-category:checked').each(function() {
                    if (!categories.includes(parseInt($(this).val()))) {
                        categories.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories, devices, platforms, genres, searchValue)
            });
            $("input[type='checkbox'][name^='devices_']").on('click', function() {
                var categories = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = [];
                $('.filter-by-device:checked').each(function() {
                    if (!devices.includes(parseInt($(this).val()))) {
                        devices.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories, devices, platforms, genres, searchValue)
            });
            $("input[type='checkbox'][name^='platforms_']").on('click', function() {
                var categories = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = [];
                $('.filter-by-platfrom:checked').each(function() {
                    if (!platforms.includes(parseInt($(this).val()))) {
                        platforms.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories, devices, platforms, genres, searchValue)
            });
            $("input[type='checkbox'][name^='genres_']").on('click', function() {
                var categories = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = [];
                $('.filter-by-genre:checked').each(function() {
                    if (!genres.includes(parseInt($(this).val()))) {
                        genres.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories, devices, platforms, genres, searchValue)
            });

            function getFilteredData(categories, devices, platforms, genres, searchValue) {
                $.ajax({
                    type: "get",
                    url: "{{ route('product.search.items.all') }}",
                    data: {
                        "categories": categories,
                        "devices": devices,
                        "platforms": platforms,
                        "genres": genres,
                        "search": searchValue
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.html) {
                            $('.main-content').html(response.html);
                        }
                        if (response.error) {
                            notify('error', response.error);
                        }
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
