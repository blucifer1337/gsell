@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="two-fa-section bg--black">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="dashboard-body py-60">
                            <div class="row gy-4 justify-content-center">
                                <div class="dashboard-title">
                                    <h6 class="title">@lang('Two Fa Security')</h6>
                                </div>
                                @if (!auth()->user()->ts)
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="global-card">
                                            <h6 class="mb-5">@lang('Two Factor Authenticator')</h6>

                                            <div class="qr-img mb-4 mx-auto text-center">
                                                <img class="mx-auto" src="{{ $qrCodeUrl }}" alt="qr-img">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label" for="key">@lang('Setup Key')</label>
                                                <div class="input-group">
                                                    <input type="text" name="key" value="{{ $secret }}"
                                                        class="form-control form--control referralURL" readonly id="key">
                                                    <button type="button" id="copyBoard"
                                                        class="input-group-text btn btn--base copytext"
                                                        style="border-radius: 0px;">
                                                        <i class="fa fa-copy"></i> </button>
                                                </div>
                                            </div>

                                            <label class="form-label"><i class="fa fa-info-circle"></i>@lang('Help')</label>
                                            <p>@lang('Google Authenticator is a multifaceted application for cell phones. It
                                                creates coordinated codes utilized during the 2-step confirmation process.
                                                To utilize Google Authenticator, introduce the Google Authenticator
                                                application on your cell phone.')
                                                <a class="text--base"
                                                href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('Download')</a></p>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-xl-8 col-lg-8">
                                    @if (auth()->user()->ts)
                                        <div class="global-card">
                                            <h6>@lang('Disable 2FA Security')</h6>
                                            <form action="{{ route('user.twofactor.disable') }}" method="POST">
                                                <div class="card-body">
                                                    @csrf
                                                    <input type="hidden" name="key" value="{{ $secret }}">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label required" for="code">@lang('Google Authenticatior OTP')</label>
                                                        <input type="text" class="form--control" name="code" required="" id="code">
                                                    </div>
                                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                                </div>
                                            </form>
                                        </div>
                                    @else
                                        <div class="global-card">
                                            <h6>@lang('Enable 2FA Security')</h6>
                                            <form action="{{ route('user.twofactor.enable') }}" method="POST">
                                                <div class="card-body">
                                                    @csrf
                                                    <input type="hidden" name="key" value="{{ $secret }}">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label required" for="code">@lang('Google Authenticatior OTP')</label>
                                                        <input type="text" class="form--control" name="code" required="" id="code">
                                                    </div>
                                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .copied::after {
            background-color: #{{ $general->base_color }};
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').on('click', function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
