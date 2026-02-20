@extends($activeTemplate.'layouts.master')
@section('content')

<section class="contact-section pb-115">
    <div class="container">
        <div class="row py-60">
            @foreach ($reviews as $review)
                <div class="col-xl-4 col-md-6">
                    <div class="blog-card-wraper wow animate__fadeInUp animate__animated" data-wow-delay="0.2s">
                        <div class="game-card-2">
                            <svg class="svg-bg" xmlns="http://www.w3.org/2000/svg" width="422" height="329"
                                viewBox="0 0 422 329">
                                <path
                                    d="M304.072 24.2586L304.218 24.5H304.5H397.793L421.5 48.2071V304.793L397.793 328.5H144.285L130.23 304.745L130.085 304.5H129.8H24.2071L0.5 280.793V24.2071L24.2071 0.5H289.718L304.072 24.2586Z" />
                            </svg>
                            <div class="game-card-thumb-3 clip-2">
                                <img src="{{ getImage(getFilePath('product').'/'. $review->product->image) }}"
                                    alt="review">
                            </div>
                            <span class="discount  d768 card-content"></span>
                        </div>
                        <div class="blog-text-content">
                            <a
                                href="{{ route('user.review.edit', $review->id) }}">
                                <h5 class="blog-title">
                                    @if (strlen(__($review->product->title)) > 18)
                                        {{ substr(__($review->product->title), 0, 25) . '...' }}
                                    @else
                                    {{ __($review->product->title) }}
                                    @endif
                                </h5>
                                {{ substr(strip_tags($review->review), 0, 190) . '...' }}<br>
                            </a>
                            <a
                                href="{{ route('user.review.edit', $review->id) }}">@lang('Edit my review')
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- pagination -->
    </div>
</section>

@endsection

@push('script')
<script>
    $(document).ready(function () {
        "use strict";
        $("#st1").on('click', function () {
            $(".la-star").css("color", "#3e3e3e");
            $("#st1").css("color", "#FF5607");
            $("#rating").val(1);
        });
        $("#st2").on('click', function () {
            $(".la-star").css("color", "#3e3e3e");
            $("#st1, #st2").css("color", "#FF5607");
            $("#rating").val(2);
        });
        $("#st3").on('click', function () {
            $(".la-star").css("color", "#3e3e3e")
            $("#st1, #st2, #st3").css("color", "#FF5607");
            $("#rating").val(3);
        });
        $("#st4").on('click', function () {
            $(".la-star").css("color", "#3e3e3e");
            $("#st1, #st2, #st3, #st4").css("color", "#FF5607");
            $("#rating").val(4);
        });
        $("#st5").on('click', function () {
            $(".la-star").css("color", "#3e3e3e");
            $("#st1, #st2, #st3, #st4, #st5").css("color", "#FF5607");
            $("#rating").val(5);
        });
    });
</script>
@endpush
