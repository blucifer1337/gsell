@php
    $content = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false, 4);
    $policyPages = getContent('policy_pages.element');
    $pages = App\Models\Page::all();

@endphp

<!-- FOOTER AREA START  -->

<!-- ==================== Footer Start Here ==================== -->
<footer class="footer-area section-bg">
    <div class="footer-top pt-80 pb-4">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-4 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <a href="{{ route('home') }}" class="footer-logo-normal" id="footer-logo-normal">
                                <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="">
                            </a>
                        </div>
                        <p class="footer-item__desc wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                            {{ $content->data_values->short_details }}
                        </p>

                        <ul class="social-list wow animate__animated animate__fadeInUp" data-wow-delay="1s">
                            @foreach ($socialIcons as $icon)
                                <li class="social-list__item">
                                    <a href="{{ $icon->data_values->url }}" class="social-list__link icon-wrapper">
                                        <div class="icon">@php echo $icon->data_values->social_icon; @endphp</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Important Links')</h5>
                        <ul class="footer-menu">
                            @foreach ($pages as $page)
                                @if ($page->slug == 'about')
                                    <li class="footer-menu__item wow animate__fadeInUp animate__animated"
                                        data-wow-delay="0.2s">
                                        <a href="{{ route('pages', $page->slug) }}" class="footer-menu__link">
                                            <i class="fas fa-angle-double-right"></i>
                                            {{ __($page->name) }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                            @foreach ($pages as $page)
                                @if ($page->slug == 'blog')
                                    <li class="footer-menu__item wow animate__fadeInUp animate__animated"
                                        data-wow-delay="0.2s">
                                        <a href="{{ route('pages', $page->slug) }}" class="footer-menu__link"
                                            target="_blank">
                                            <i class="fas fa-angle-double-right"></i>
                                            {{ __($page->name) }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                            <li class="footer-menu__item wow animate__fadeInUp animate__animated" data-wow-delay="0.3s">
                                <a href="{{ route('user.login') }}" class="footer-menu__link" target="_blank">
                                    <i class="fas fa-angle-double-right"></i>@lang('Login')
                                </a>
                            </li>
                            <li class="footer-menu__item wow animate__fadeInUp animate__animated" data-wow-delay="0.3s">
                                <a href="{{ route('user.register') }}" class="footer-menu__link" target="_blank">
                                    <i class="fas fa-angle-double-right"></i>@lang('Registration')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Company Links')</h5>
                        <ul class="footer-menu">
                            @foreach ($policyPages as $policy)
                                <li class="footer-menu__item wow animate__fadeInUp animate__animated"
                                    data-wow-delay="0.2s">
                                    <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                        class="footer-menu__link" target="_blank">
                                        <i class="fas fa-angle-double-right"></i>
                                        {{ __($policy->data_values->title) }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="footer-menu__item wow animate__fadeInUp animate__animated" data-wow-delay="0.3s">
                                <a href="{{ route('cookie.policy') }}" class="footer-menu__link" target="_blank">
                                    <i class="fas fa-angle-double-right"></i>@lang('Cookie Policy')
                                </a>
                            </li>
                            @foreach ($pages as $page)
                                @if ($page->slug == 'contact')
                                    <li class="footer-menu__item wow animate__fadeInUp animate__animated"
                                        data-wow-delay="0.2s">
                                        <a href="{{ route('pages', $page->slug) }}" class="footer-menu__link"
                                            target="_blank">
                                            <i class="fas fa-angle-double-right"></i>
                                            {{ __($page->name) }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Newsletter')</h5>
                        <p class="footer-item__desc">
                            {{ __($content->data_values->subscribe_short_desc) }}
                        </p>
                        <div class="subscribe-box">
                            <form method="post" action="{{ route('subscribe') }}">
                                @csrf
                                <input class="form--control footer-input" type="text" placeholder="Email Address"
                                    required>
                                <button class="btn btn--base sub-btn" type="submit">@lang('Subscribe')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top End-->

    <!-- bottom Footer -->
    <div class="bottom-footer py-4 mb-3 mt-4">
        <div class="container">
            <div class="row text-center gy-2">
                <div class="col-lg-12">
                    <div class="bottom-footer-text">@php echo $content->data_values->website_footer; @endphp</div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ==================== Footer End Here ==================== -->

<div class="scroll-top show">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
            style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 197.514;">
        </path>
    </svg>
    <i class="fas fa-arrow-up"></i>
</div>
