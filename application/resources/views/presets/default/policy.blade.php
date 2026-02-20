@extends($activeTemplate.'layouts.frontend')
@section('content')


<section class="cookie-section py-40">
    <img src="{{ asset('assets/images/frontend/shape-bg/privicy-shape-bg.png') }}" alt="" class="policy-bg-images">
    <div class="banner-effect"></div>
    <div class="banner-effect-two"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="coockie-wrap wyg">
                    @php
                        echo $policy->data_values->details
                    @endphp
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

