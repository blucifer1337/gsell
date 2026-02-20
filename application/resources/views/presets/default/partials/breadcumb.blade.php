@php
    $firstAd = App\Models\Ad::where('ad_code', 1)->first();
@endphp
<!-- ==================== Breadcumb Start Here ==================== -->
<div class="breadcumb-2">
    <div class="container">
        @if ($firstAd)
            <!-- ad image start -->
            <div class="breadcrumb-long-add-wrap mt-2 mb-4">
                <div class="long-add-wrap--thumb text-center">
                    <a href="{{ @$firstAd->link }}" target="_blank">
                        <img src="{{ getImage(getFilePath('adImage') . '/' . @$firstAd->image) }}" alt="">
                    </a>
                </div>
            </div>
        @else
            <!-- ad image end -->
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb-2__wrapper">
                    <ul class="breadcumb-2__lists">
                        <li class="breadcumb-2__item"><a href="{{ route('home') }}"
                                class="breadcumb-2__link">@lang('Home')</a></li>
                        <li class="breadcumb-2__icon"><i class="fas fa-slash"></i> </li>
                        <li class="breadcumb-2__item">
                            <span class="breadcumb-2__item-text">
                                {{ __($pageTitle) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ==================== Breadcumb End Here ==================== -->
