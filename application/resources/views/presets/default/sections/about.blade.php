@php
    $content = getContent('about.content', true);
    $abouts = getContent('about.element', false, 7);
@endphp

<section class="about pb-80">
    <div class="container">
        <div class="row gy-4 flex-wrap-reverse">
         <div class="col-lg-6 d-flex align-items-center">
            <div class="about-left-content">
                <div class="about-thumb1">
                    <img src="{{ getImage(getFilePath('frontend') . '/about/' . $content->data_values->about_image) }}" alt="...">
                </div>
            </div>
         </div>
            <div class="col-lg-6 d-flex flex-column justify-content-center">
                <div class="row">
                    <div class="col-xl-10 col-lg-12">
                        <div class="section-content-3">
                            <h6 class="title">{{ __($content->data_values->heading) }}</h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($abouts as $about)
                        <div class="col-lg-6">
                            <div class="about-key-card wow animate__fadeInUp animate__animated" data-wow-delay="0.1s">
                                @php echo $about->data_values->icon @endphp
                                <div class="key-card-content">
                                    <h6 class="key-card-title">{{ __($about->data_values->title) }}</h6>
                                    <p class="key-card-subtitle">{{ __($about->data_values->description) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>




