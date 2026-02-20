@php $content = getContent('auth_bg.content', true); @endphp
@extends($activeTemplate . 'layouts.auth')
@section('content')
    <section class="login-section">
        <div class="logo-wrap">
            <a href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="..."></a>
        </div>
        <div class="container-fluid px-0">

            <div class="row mx-0">
                <div class="col-xl-8 col-lg-6 px-0 d-none d-lg-block">
                    <div class="login-left-section bg--img"
                        style="background-image: url({{ getImage(getFilePath('frontend') . '/auth_bg/' . $content->data_values->background_image) }});">
                        <div class="content-wrap">
                            <h1 class="title">@lang('Welcome to') <span>@lang('G')</span>@lang('Sell')</h1>
                            <p class="subtitle">
                                @lang('There are many variations of passages of Lorem Ipsum available,majority
                                                                have suffered alteration in some')
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 px-0">
                    <!-- < sign in components -->
                    <form action="{{ route('user.login') }}" method="post">
                        @csrf
                        <div class="login-box">
                            <div class="close-btn-wrapper">
                                <div class="close--btn">
                                    <div class="wrap">
                                        <a href="{{ route('home') }}"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                            </div>

                            <h4 class="title">@lang('Log In Your Account')</h4>
                            <div class="mb-4 form-group">
                                <label class="mb-2 form--label">@lang('Username')</label>
                                <input type="text" name="username" value="{{ old('username') }}" autocomplete="off"
                                        class="form--control" placeholder="Username" required>
                            </div>
                            <div class="mb-4 form-group">
                                <label class="mb-2 form--label">@lang('Password')</label>
                                <input type="password" name="password" autocomplete="off"
                                        class="form--control" placeholder="Password" required>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between mb-2">
                                <label for="password" class="form-label mb-0"></label>
                                <a class="fw-bold forgot-pass" href="{{ route('user.password.request') }}">
                                    @lang('Forgot your password?')
                                </a>
                            </div>
                            <button class="btn btn--base w-100">@lang('Login')</button>
                            <div class="social-option">
                                <div class="text">
                                    <h6>@lang('or')</h6>
                                </div>
                                <p>@lang('Don\'t have any account?') <a href="{{ route('user.register') }}">@lang('Sign Up')</a></p>
                            </div>
                        </div>
                    </form>
                    <!-- sign in components /> -->
                </div>
            </div>
        </div>
    </section>
@endsection
