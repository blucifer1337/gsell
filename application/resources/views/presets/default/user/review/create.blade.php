@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('user.review.submit') }}" method="post">
            @csrf
            <h3>@lang('Submit a review for') <a class="text--primary"
                    href="{{ route('product', ['slug' => slug($product->title), 'id' => $product->id])}}">{{
                    __($product->title) }}</a></h3>
            <div class="star-rating mb-3">
                <i class="las la-star review-star" data-rating="1" id="st1"></i>
                <i class="las la-star review-star" data-rating="2" id="st2"></i>
                <i class="las la-star review-star" data-rating="3" id="st3"></i>
                <i class="las la-star review-star" data-rating="4" id="st4"></i>
                <i class="las la-star review-star" data-rating="5" id="st5"></i>
            </div>
            <input type="hidden" name="rating" id="rating" value="" required>
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <textarea class="form-control form--control  mb-3" name="review" id="" cols="30" rows="10"></textarea>
            <button class="btn btn--base text-end" type="submit">@lang('Submit')</button>
        </form>
    </div>
</div>
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
