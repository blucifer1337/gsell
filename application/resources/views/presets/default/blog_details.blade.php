@php
    $bannerAd = App\Models\Ad::where('ad_code', 5)->first();
    $boxAd = App\Models\Ad::where('ad_code', 8)->first();
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-details-section py-60">
        <div class="container">
            <div class="row pt-4 gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-details">

                        <div class="blog-item">
                            <div class="blog-item__thumb">
                                <img src="{{ getImage(getFilePath('frontend') . '/blog/' . $blog->data_values->image) }}"
                                    alt="blog-img">
                            </div>
                            <div class="blog-item__content pt-3">
                                <ul class="text-list inline">
                                    <li class="text-list__item"> <span class="text-list__item-icon"><i
                                                class="fas fa-calendar-alt"></i>
                                        </span>{{ $blog->data_values->date }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog-details__content">
                            <h3 class="blog-details__title ">{{ __($blog->data_values->title) }}</h3><br>
                            <p class="blog-details__desc">@php echo $blog->data_values->description; @endphp</p>

                            <div class="blog-details__share mt-5 d-flex align-items-center flex-wrap mb-4">
                                <h5 class="social-share__title mb-0 me-sm-3 me-1 d-inline-block">@lang('Share This')</h5>
                                <ul class="social-list blog-details">
                                    <li class="social-list__item"><a href="https://www.facebook.com"
                                            class="social-list__link"><i class="fab fa-facebook-f"></i></a> </li>
                                    <li class="social-list__item"><a href="https://www.twitter.com"
                                            class="social-list__link"> <i class="fab fa-twitter"></i></a></li>
                                    <li class="social-list__item"><a href="https://www.linkedin.com"
                                            class="social-list__link"> <i class="fab fa-linkedin-in"></i></a></li>
                                    <li class="social-list__item"><a href="https://www.pinterest.com"
                                            class="social-list__link"> <i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- ============================= Blog Details Sidebar Start ======================== -->
                    <div class="blog-sidebar">
                        @if ($boxAd)
                            <!-- ad image start -->
                            <div class="long-add-wrap">
                                <div class="long-add-wrap--thumb">
                                    <a href="{{ @$boxAd->link }}" target="_blank">
                                        <img src="{{ getImage(getFilePath('adImage') . '/' . @$boxAd->image) }}"
                                            alt="">
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- ad image end -->
                        @endif
                    </div>
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('New Article')</h5>
                            @foreach ($latests as $item)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a
                                            href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                                            <img src="{{ getImage(getFilePath('frontend') . '/blog/' . $item->data_values->image) }}"
                                                alt="...">
                                        </a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title">
                                            <a
                                                href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                                                @if (strlen(__($item->data_values->title)) > 50)
                                                    {{ substr(__($item->data_values->title), 0, 50) . '...' }}
                                                @else
                                                    {{ __($item->data_values->title) }}
                                                @endif
                                            </a>
                                        </h6>
                                        <span class="latest-blog__date">{{ __($item->data_values->date) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- ============================= Blog Details Sidebar End ======================== -->
                </div>
            </div>
            @if ($bannerAd)
                <!-- ad image start -->
                <div class="breadcrumb-long-add-wrap mt-5">
                    <div class="long-add-wrap--thumb text-center">
                        <a href="{{ @$bannerAd->link }}" target="_blank">
                            <img src="{{ getImage(getFilePath('adImage') . '/' . @$bannerAd->image) }}" alt="">
                        </a>
                    </div>
                </div>
            @else
                <!-- ad image end -->
            @endif
        </div>
    </section>
@endsection
@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
