@extends($activeTemplate . 'layouts.auth')
@section('content')
    @php
        $policyPages = getContent('policy_pages.element', false, null, true);
        $content = getContent('auth_bg.content', true);
    @endphp

    <section class="login-section">
        <div class="logo-wrap">
            <a href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="..."></a>
        </div>
        <div class="container-fluid px-0">

            <div class="row mx-0">
                <div class="col-xl-8 col-lg-6 px-0 d-none d-lg-block">
                    <div class="login-left-section bg--img"
                        style="background-image: url({{ getImage(getFilePath('frontend') . '/auth_bg/' .$content->data_values->background_image) }});">
                        <div class="content-wrap">
                            <h1 class="title">@lang('Welcome to') <span>@lang('G')</span>@lang('Sell')</h1>
                            <p class="subtitle">
                                @lang('There are many variations of passages of Lorem Ipsum
                                        available,majority have suffered alteration in some')
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 px-0">
                    <!-- < sign in components -->
                    <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                        @csrf
                        <div class="login-box">
                           <div class="close-btn-wrapper">
                                <div class="close--btn">
                                    <div class="wrap">
                                        <a href="index.html"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                           </div>

                            <h4 class="title">@lang('Create Your Account')</h4>
                            @if (session()->get('reference') != null)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="referenceBy" class="form-label">@lang('Reference by')</label>
                                        <input type="text" name="referBy" id="referenceBy"
                                            class="form-control form--control" value="{{ session()->get('reference') }}"
                                            readonly>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4 form-group">
                                <label class="form-label">@lang('Username')</label>
                                <input type="text" class="form-control form--control checkUser" name="username"
                                    value="{{ old('username') }}" required>
                                <small class="text-danger usernameExist"></small>
                            </div>

                            <div class="mb-4 form-group">
                                <label class="form-label">@lang('E-Mail Address')</label>
                                <input type="email" class="form-control form--control checkUser" name="email"
                                    value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-4 form-group">
                                <label class="form-label">@lang('Country')</label>
                                <select name="country" class="form-control form--control">
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}"
                                            data-code="{{ $key }}">
                                            {{ __($country->country) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 form-group">
                                <label class="form-label">@lang('Mobile')</label>
                                <div class="input-group ">
                                    <span class="input-group-text mobile-code bg--base text-light border-0">

                                    </span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="number" name="mobile" value="{{ old('mobile') }}"
                                        class="form-control form--control checkUser" required>
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>

                            <div class="mb-4 form-group">
                                <label class="form-label">@lang('Password')</label>
                                <input type="password" class="form-control form--control" name="password" required>
                                @if ($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-4 form-group">
                                <label class="form-label">@lang('Confirm Password')</label>
                                <input type="password" class="form-control form--control" name="password_confirmation"
                                    required>
                            </div>

                            <x-captcha></x-captcha>
                        @if ($general->agree)
                            <div class="mb-4 form-group">
                                <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                <label for="agree">@lang('I agree with') @foreach ($policyPages as $policy)
                                        <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">
                                            {{ __($policy->data_values->title) }}</a>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </label>
                            </div>
                        @endif
                        <div class="mb-4 form-group">
                            <button type="submit" id="recaptcha" class="btn btn--base w-100">
                                @lang('Register')</button>
                        </div>
                        <p class="mb-0">@lang('Already have an account?')
                            <a href="{{ route('user.login') }}">@lang('Login')</a>
                        </p>
                        </div>
                    </form>
                    <!-- sign in components /> -->
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm"
                        data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
    </style>
@endpush
@push('script-lib')
    <script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
