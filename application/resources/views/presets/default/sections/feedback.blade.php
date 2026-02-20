@php
    $content = getContent('feedback.content', true);
    $feedbacks  = getContent('feedback.element',false);
    $firstAd = App\Models\Ad::where('ad_code', 2)->first();
@endphp
<!-- FEEDBACK AREA START  -->
<section class="testimonial-section py-80">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="section-content">
                        <div class="title-wrap">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h6 class="title-2">{{ $content->data_values->title }}</h6>
                                    <p >{{ $content->data_values->subtitle }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row testimonial-slider">
            @foreach ($feedbacks as $feedback)
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <div class="user-info">
                            <div class="user-thumb">
                                <img src="{{ getImage(getFilePath('frontend') . '/feedback/' . $feedback->data_values->feedback_image) }}" alt="...">
                            </div>
                            <div class="user-description">
                                <h6 class="user-name">{{ __($feedback->data_values->title) }}</h6>
                                <p class="user-title">{{ __($feedback->data_values->designation) }}</p>
                            </div>
                        </div>
                        <div class="content">
                            <p class="discription">
                                {{ __($feedback->description) }}
                                @if (strlen(__($feedback->data_values->description)) > 160)
                                    {{ substr(__($feedback->data_values->description), 0, 300) . '...' }}
                                @else
                                    {{ __($feedback->data_values->description) }}
                                @endif
                            </p>
                        </div>
                        <div class="rating-wrap">
                            <div class="rating">
                                @php echo getRating($feedback->data_values->star_count); @endphp
                            </div>
                            <p class="number">({{$feedback->data_values->star_count}})</p>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        @if ($firstAd)
            <!-- ad image start -->
            <div class="breadcrumb-long-add-wrap mt-5">
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
<!-- FEEDBACK AREA END  -->
