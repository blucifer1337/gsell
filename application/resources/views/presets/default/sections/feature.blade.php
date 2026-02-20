@php
    $content = getContent('feature.content', true);
    $features = getContent('feature.element', false, 7);
@endphp
<!-- FAQ AREA START  -->

<section class="about key-item pt-80">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 d-flex flex-column justify-content-center">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="section-content-3">
                            <h6 class="title">{{ __($content->data_values->heading) }}</h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        @foreach ($features as $feature)
                            <div class="key-feature wow animate__fadeInUp animate__animated mb-5" data-wow-delay="0.1s">
                                <div class="icon-wrapper">
                                    <svg class="svg-bg" width="75" height="68" viewBox="0 0 75 68"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.16937 40.2176L1.73967 40.4662L2.16937 40.2176C-0.0564554 36.3702 -0.0564553 31.6298 2.16937 27.7824L1.73855 27.5332L2.16937 27.7824L14.3549 6.71837C16.5808 2.87079 20.6948 0.5 25.1476 0.5H49.519C53.9717 0.5 58.0857 2.87079 60.3116 6.71837L72.4973 27.7824C74.7231 31.6298 74.7231 36.3702 72.4973 40.2176L60.3116 61.2816C58.0857 65.1292 53.9717 67.5 49.519 67.5H25.1476C20.6948 67.5 16.581 65.1292 14.3551 61.2816L2.16937 40.2176Z" />
                                    </svg>
                                    @php echo $feature->data_values->feature_icon; @endphp
                                </div>

                                <div class="feature-content">
                                    <h6 class="key-title">{{ __($feature->data_values->title) }}</h6>
                                    <p class="key-subtitle">{{ __($feature->data_values->description) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-left-content d-flex justify-content-end">
                    <div class="about-thumb1">
                        <img src="{{ getImage(getFilePath('frontend') . '/feature/' . $content->data_values->feature_image) }}"
                            alt="...">

                        <div class="popup-video-wrap">
                            <div class="promo-video">
                                <div class="waves-block">
                                    <div class="waves wave-1"></div>
                                    <div class="waves wave-2"></div>
                                    <div class="waves wave-3"></div>
                                </div>
                            </div>
                            <a class="play-video popup_video" data-fancybox=""
                                href="https://www.youtube.com/watch?v=s7DbVTkaXn0" tabindex="0">
                                <i class="fa fa-play"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FAQ AREA END  -->
