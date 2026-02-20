@extends($activeTemplate.'layouts.master')
@section('content')
<section class="password-change-section bg--black">
    <div class="dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-body py-60">
                        <div class="row gy-4 justify-content-center">
                            <div class="col-xl-6 col-lg-6">
                                <div class="dashboard-title">
                                    <h6 class="title">@lang('Change Password')</h6>
                                </div>
                                <div class="global-card">
                                    <form action="" method="post">
                                        @csrf
                                        <div class="row gy-3">
                                            <div class="col-sm-12">
                                                <h4>@lang('Change Password')</h4>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form--label" for="password_confirmation" class="mb-3">@lang('Old Password')</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control form--control" name="current_password"
                                                               autocomplete="current-password" placeholder="Old Password" required>
                                                        <div class="password-show-hide fas fa-eye toggle-password-change" data-target="password_confirmation"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form--label" for="password_confirmation" class="mb-3">@lang('New Password')</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control form--control" name="password"
                                                               autocomplete="current-password" placeholder="New Password" required>
                                                        @if($general->secure_password)
                                                        <div class="input-popup">
                                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                                            <p class="error number">@lang('1 number minimum')</p>
                                                            <p class="error special">@lang('1 special character minimum')</p>
                                                            <p class="error minimum">@lang('6 character password')</p>
                                                        </div>
                                                        @endif
                                                        <div class="password-show-hide fas fa-eye toggle-password-change" data-target="password_confirmation"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label  class="form--label" for="password_confirmation" class="mb-3">@lang('Confirm Password')</label>
                                                    <div class="input-group">
                                                        <input type=type="password" class="form-control form--control" name="password_confirmation" autocomplete="current-password" placeholder="Confirm Password" required>
                                                        <div class="password-show-hide fas fa-eye toggle-password-change" data-target="password_confirmation"></div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn--base">@lang('Save Now')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
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
