<!-- 404 section -->
<!-- header -->
<!DOCTYPE html>
<html lang="en">



<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@lang('404 Page Not Found')</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/common/css/line-awesome.min.css') }}" />

    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.min.css') }}">
    <!-- Odometer -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">
    <!-- Odometer -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">

    <link rel="stylesheet"
        href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
</head>


<body>

    <!--==================== Preloader Start ====================-->
    @include($activeTemplate . 'partials.preloader')
    <!--==================== Preloader End ====================-->


    @include($activeTemplate . 'partials.header')
    <section class="account">
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 justify-content-center align-items-center" style="height: 90vh">
                    <div class="col-lg-6">
                        <div class="error-wrap text-center">
                            <div class="error__text">
                                <span>@lang('4')</span>
                                <span>@lang('0')</span>
                                <span>@lang('4')</span>
                            </div>
                            <h2 class="error-wrap__title mb-3">@lang('Page Note Found')</h2>
                            <p class="error-wrap__desc">@lang('Page you are looking have been deleted or does not exist')</p>
                            <a href="{{ route('home') }}" class="btn btn--base">
                                <i class="la la-undo"></i>@lang('Go Home')
                                <span style="top: 212.016px; left: 168px;"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include($activeTemplate . 'partials.footer')

    <script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/common/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Slick js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- Odometer js -->
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
    <!-- Appear -->
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.appear.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>
</body>

</html>
