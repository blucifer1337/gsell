@php
    $content = getContent('contact_us.content', true);
    $firstAd = App\Models\Ad::where('ad_code', 2)->first();
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="getintouch-section">
        <div class="container">
            <div class="row gy-4 flex-wrap-reverse">
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="about-left-content">
                        <div class="about-thumb1">
                            <img src="{{ getImage(getFilePath('frontend') . '/contact_us/' . $content->data_values->contact_image) }}"
                                alt="...">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="section-content-3">
                                <h6 class="title">{{ $content->data_values->title }}</h6>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="getin-touch-card wow animate__fadeInUp animate__animated" data-wow-delay="0.1s">
                                <i class="fas fa-phone-volume"></i>
                                <div class="key-card-content">
                                    <h6 class="key-card-title">@lang('Phone Number')</h6>
                                    <p class="key-card-subtitle"><a
                                            href="{{ $content->data_values->contact_number }}">{{ $content->data_values->contact_number }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="getin-touch-card wow animate__fadeInUp animate__animated" data-wow-delay="0.2s">
                                <i class="far fa-envelope"></i>
                                <div class="key-card-content">
                                    <h6 class="key-card-title">@lang('Email Address')</h6>
                                    <p class="key-card-subtitle"><a
                                            href="{{ $content->data_values->email_address }}">{{ $content->data_values->email_address }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="getin-touch-card wow animate__fadeInUp animate__animated" data-wow-delay="0.3s">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="key-card-content">
                                    <h6 class="key-card-title">@lang('Our Location')</h6>
                                    <p class="key-card-subtitle">{{ $content->data_values->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="getin-touch-card wow animate__fadeInUp animate__animated" data-wow-delay="0.4s">
                                <i class="fas fa-headset"></i>
                                <div class="key-card-content">
                                    <h6 class="key-card-title">@lang('Live Support')</h6>
                                    <p class="key-card-subtitle"><a class="live-support"
                                            href="{{ $content->data_values->support_email }}">{{ $content->data_values->support_email }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section bg--white pb-100">
        <div class="container">
            <div class="row justify-content-center gy-4 py-80">
                <div class="col-lg-4">
                    <div class="contact-right-side">
                        <div class="content">
                            @php
                                echo $content->data_values->contact_title;
                            @endphp
                        </div>
                        <div class="thumb">
                            <img src="{{ getImage(getFilePath('frontend') . '/contact_us/' . 'contact_thumb.png') }}"
                                alt="...">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="get-in-touch wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                        <form method="post" action="" class="verify-gcaptcha">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-4 form-group">
                                        <label class="mb-3 form--label">@lang('Name')</label>
                                        <input name="name" type="text" class="form--control"
                                            value="@if (auth()->user()) {{ auth()->user()->fullname }} @else{{ old('name') }} @endif"
                                            placeholder="Name" @if (auth()->user()) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4 form-group">
                                        <label class="mb-3 form--label">@lang('Email')</label>
                                        <input name="email" type="email" class="form--control"
                                            value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif"
                                            placeholder="Email" @if (auth()->user()) readonly @endif required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="mb-2 form--label">@lang('Subject')</label>
                                <input name="subject" type="text" class="form--control"
                                    value="{{ old('subject') }}" required>
                            </div>
                            <div class="mb-2 form-group mt-4">
                                <label class="mb-3 form--label">@lang('Message')</label>
                                <textarea name="message" class="form--control" placeholder="@lang('Write your note')" required>{{ old('message') }}</textarea>
                            </div>
                            <button class="btn btn--base w-100"> @lang('Send Message')</button>
                        </form>
                    </div>
                </div>
            </div>

            @if ($firstAd)
                <!-- ad image start -->
                <div class="breadcrumb-long-add-wrap">
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
@endsection
