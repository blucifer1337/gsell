@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row gy-4 justify-content-center">
    <div class="col-lg-8 justify-content-center">
        <div class="user-profile payment-info">
            <form action="{{ route('user.data.submit') }}" method="post" role="form"
            enctype="multipart/form-data">
            @csrf
                <div class="row gy-3">
                    <div class="col-lg-12">
                        <h4 class="mb-1">@lang('Personal Information')</h4>
                    </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                            <label class="text-white mb-1">@lang('First name')</label>
                            <input type="text" name="firstname" class="form-control form--control"
                                value="{{ $user->firstname }}">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                            <label class="text-white mb-1">@lang('Last Name')</label>
                            <input type="text" name="lastname" class="form-control form--control"
                                value="{{ $user->lastname }}">
                        </div>
                        <div class=" col-xl-4 col-lg-4 col-md-4 form-group">
                            <label class="text-white mb-1">@lang('Username')</label>
                            <input type="text" name="username" class="form-control form--control"
                                value="{{ $user->username }}">
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                            <label class="text-white mb-1">@lang('Email')</label>
                            <input type=" email" name="email" class="form-control form--control"
                            value="{{ $user->email }}" disabled>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                            <label class="text-white mb-1">@lang('Country')</label>
                            <select name="country" class="form-control form--control">
                                @foreach($countries as $key => $country)
                                <option data-mobile_code="{{ $country->dial_code }}"
                                    value="{{ $country->country }}" data-code="{{ $key }}" {{ @$user->
                                    address->country == $country->country ? 'selected' : null }}>{{
                                    __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 form-group">
                            <label class="text-white mb-1">@lang('Mobile') (+{{ $user->mobile }})</label>
                            <div class="input-group">
                                <span class="input-group-text mobile-code">
                                </span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">
                                <input type="number" name="mobile" value="" class="form--control checkUser">
                            </div>
                            <small class="text-danger mobileExist"></small>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                            <label class="text-white mb-1">@lang('Address')</label>
                            <input type="text" name="address" class="form-control form--control"
                                value="{{ $user->address !== null ? @$user->address->address : ''}}">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                            <label class="text-white mb-1">@lang('Zip Code')</label>
                            <input type="text" name="zip" class="form-control form--control"
                                value="{{ $user->address !== null ? @$user->address->zip : ''}}">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                            <label class="text-white mb-1">@lang('State')</label>
                            <input type="text" name="state" class="form-control form--control"
                                value="{{ $user->address !== null ? @$user->address->state : ''}}">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                            <label class="text-white mb-1">@lang('City')</label>
                            <input type="text" name="city" class="form-control form--control"
                                value="{{ $user->address !== null ? @$user->address->city : ''}}">
                        </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn--base w-100">@lang('Save Now')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if ($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
        @endif

        $('select[name=country]').on('change',function () {
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        });
        $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
        $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        @if ($general -> secure_password)
            $('input[name=password]').on('input', function () {
                secure_password($(this));
            });

        $('[name=password]').on('focus',function () {
            $(this).closest('.form-group').addClass('hover-input-popup');
        });

        $('[name=password]').on('focusout',function () {
            $(this).closest('.form-group').removeClass('hover-input-popup');
        });
        @endif
    })(jQuery);
</script>
@endpush
