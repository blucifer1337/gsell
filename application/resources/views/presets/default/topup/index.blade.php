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

                    </div>
                </div>
                <!-- search box end -->

                <div class="col-xl-9 col-lg-8 main-content">
                    <div class="row gy-4">
                        @forelse ($topUps as $topUp)
                            @php
                                $data = collect($topUp->services_data)->count();
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <a class="card-link-wrapper"
                                    href="{{ route('topup', ['slug' => slug($topUp->name), 'id' => $topUp->id]) }}">
                                    <div class="game-card">
                                        @if ($topUp->discount > 0)
                                            <div class="dis-tag">
                                                <p>-{{ $topUp->discount }}%</p>
                                            </div>
                                        @endif
                                        <div class="thumb">
                                            <img src="{{ getImage(getFilePath('topup') . '/' . 'thumb_' . $topUp->image) }}"
                                                alt="...">
                                        </div>
                                        <div class="content">
                                            <h6 class="title">
                                                @if (strlen(__($topUp->name)) > 30)
                                                    {{ substr(__($topUp->name), 0, 55) . '...' }}
                                                @else
                                                    {{ __($topUp->name) }}
                                                @endif
                                            </h6>
                                            <div class="price-wrap">
                                                <p class="price">{{$data}} @lang(' Items')</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div>
                                <p class="text-muted text-center" colspan="100%">@lang('No Top Up Found')</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
            <!-- pagination -->
            <div class="row py-3 mt-4">
                <div class="col-lg-12 justify-content-end d-flex">
                    <nav aria-label="Page navigation example">
                        @if ($topUps->hasPages())
                            {{ paginateLinks($topUps) }}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Top Up AREA END  -->
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
        })(jQuery);
    </script>
@endpush
