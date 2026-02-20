@php
    $products = App\Models\Product::orderBy('rating', 'desc')
        ->limit(4)
        ->get();
    $reviews = App\Models\Review::where('product_id', $topUp->id)
        ->with('user')
        ->get();
    $firstAd = App\Models\Ad::where('ad_code', 7)->first();
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- < product details  -->
    <section class="product-details pb-60">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xxl-5 col-lg-6">
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="product-thumb-wrap">
                                <div class="product-details-left__content">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" role="tabpanel" aria-labelledby="tab0"
                                            tabindex="0">
                                            <div class="product-details-left__thumb1">
                                                <img src="{{ getImage(getFilePath('topup') . '/' . $topUp->image) }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="topup-title-wrap mt-4">
                                    <h4 class="title">{{ __($topUp->name) }}</h4>
                                    <p class="mb-3">
                                        @if (strlen(__($topUp->description)) > 90)
                                            @php
                                                echo substr($topUp->description, 0, 115) . '...';
                                            @endphp
                                        @else
                                            @php
                                                echo $topUp->description;
                                            @endphp
                                        @endif
                                    </p>
                                </div>
                                <div class="row gy-4 mt-2">
                                    <div class="col-xxl-5 col-lg-6 col-md-5 col-6">
                                        <div class="thumb-wrap">
                                            <a href="{{ $topUp->apple_store_link }}">
                                                <img src="{{ getImage(getFilePath('topup') . '/applink/' . 'applestore.png') }}"
                                                    alt="...">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-lg-6 col-md-5 col-6">
                                        <div class="thumb-wrap">
                                            <a href="{{ $topUp->play_store_link }}">
                                                <img src="{{ getImage(getFilePath('topup') . '/applink/' . 'palystore.png') }}"
                                                    alt="...">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-lg-6">
                    <form action="{{ route('user.deposit.insert') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="top-up-card">
                            <input type="hidden" name="topUpId" value="{{ $topUp->id }}">
                            <h6 class="title">@lang('Enter Information')</h6>
                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    <div class="mb-4 form-group">
                                        <label class="mb-2 form--label required" for="username">@lang('Id Number')</label>
                                        <input type="text" name="game_id" value="" autocomplete="off"
                                            class="form--control" placeholder="Game Id" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-4 form-group">
                                        <label class="mb-2 form--label required" for="username">@lang('Server')</label>
                                        <input type="text" name="server_info" value="" autocomplete="off"
                                            class="form--control" placeholder="Server Name or Id">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-4 form-group">
                                        <label class="mb-2 form--label required" for="username">@lang('Optional')</label>
                                        <input type="text" name="user_info" value="" autocomplete="off"
                                            class="form--control" placeholder="Username or Email">
                                    </div>
                                </div>
                            </div>
                            <div class="row gy-4 mt-3">
                                @foreach ($topUp->services_data as $key => $item)
                                    @php
                                        $quantity = 'quantity' . $key;
                                        $price = 'price' . $key;
                                    @endphp
                                    <div class="col-lg-4">
                                        <div class="recharge-option">
                                            <div class="form-check">
                                                <input class="form-check-input" name="quantity" type="radio"
                                                value="{{$item->$quantity}}"  id="radio{{ $loop->index }}"
                                                onclick="selectedItemPrice({{ $item->$price }})" required>
                                                <label class="form-check-label" for="radio{{ $loop->index }}">
                                                    {{ __($item->$quantity) }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div>
                                    <input type="hidden" name="amount" value="">
                                    <h5>@lang('Price: ')<span class="total_price">{{ $general->cur_sym }}0</span></h5>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-xxl-8 col-lg-8">
                                    <input type="hidden" name="method_code" id="method_code" value="101">
                                    <input type="hidden" name="currency" id="currency" value="USD">
                                    <div class="">
                                        <div class="form-group">
                                            <input name="fixed_charge" class="fixedCharge" type="hidden">
                                            <input name="percent_charge" class="parcentCharge" type="hidden">

                                            <label class="form-label">@lang('Select Payment Method')</label>
                                            <select class="form-select form--control" name="gateway" required>
                                                <option value="">@lang('Select One')</option>
                                                @auth
                                                    <option value="balance">@lang('Account Balance')
                                                        {{ $general->cur_sym }}{{ showAmount(auth()->user()->balance) }}
                                                    </option>
                                                @endauth
                                                @foreach ($gatewayCurrency as $data)
                                                    <option value="{{ $data->method_code }}" @selected(old('gateway') == $data->method_code)
                                                        data-gateway="{{ $data }}"
                                                        data-fixed="{{ $data->fixed_charge }}"
                                                        data-parcent="{{ $data->percent_charge }}">{{ $data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="preview-details paynow mt-2 d-none">
                                            <span>@lang('Limit')</span>
                                            <span><span class="min fw-bold">0</span> {{ __($general->cur_text) }} - <span
                                                    class="max fw-bold">0</span> {{ __($general->cur_text) }} , </span>
                                            <span>@lang('Charge')</span>
                                            <span><span class="charge fw-bold">0</span> {{ __($general->cur_text) }}
                                                ,</span>
                                            <span>@lang('Payable')</span> <span><span class="payable fw-bold"> 0</span>
                                                {{ __($general->cur_text) }} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-6">
                                    <button type="submit" id="recaptcha"
                                        class="btn btn--base w-100">@lang('Buy Now')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!-- tabpanel -->
            <div class="row mt-3">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs coustome-tabs mb-2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="btn btn--base outline-2 active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab"
                                aria-selected="true">@lang('Description')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="btn btn--base outline-2" id="system-tab" data-bs-toggle="tab"
                                data-bs-target="#system" type="button" role="tab" aria-selected="false"
                                tabindex="-1">@lang('Instruction')</button>
                        </li>
                    </ul>
                    <div class="tab-content ">
                        <div class="tab-pane fade active show" id="description" role="tabpanel"
                            aria-labelledby="description">
                            <div class="description show-list-style mt-3">
                                @php echo $topUp->description; @endphp
                            </div>
                        </div>

                        <!-- System Requiremnets -->
                        <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system">
                            <div class="sytem-req mt-3">
                                <h6 class="fw-bold mb-3">@lang('Instruction')</h6>

                                <div class="row gy-4 mt-2 mb-5">
                                    <div class="col-lg-8">
                                        <div class="table-wrap product-details-table">
                                            @if ($topUp->instruction != null)
                                                @php echo $topUp->instruction; @endphp
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="ins-thumb-wrap">
                                            <img src="{{ getImage(getFilePath('topup_instruct') . '/' . $topUp->instruction_image) }}" alt="">
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tabpanel /> -->
        </div>
    </section>
    <!-- product details  /> -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            "use strict"

            //image hover
            $('button>img').hover(function() {
                var image = this;
                $('#slide_image').attr('src', image.src);
            });

            // add to wishlist
            $(document).on('click', '.addToWishList', function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: '{{ route('wishlist.add') }}',
                    type: 'get',
                    data: {
                        product_id: productId,
                    },
                    success: function(response) {

                        if (response.hasOwnProperty('message')) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            updateWishListCount(response.wishlistCount);
                        } else {
                            Toast.fire({
                                icon: 'warning',
                                title: response.error
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage =
                            'Error occurred while adding the product to wishlist.';
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                });
            });

            function updateWishListCount(count) {
                $('#wishlistItem').text(count);
            }

            // check user
            var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            var userId = {{ auth()->user() ? auth()->user()->id : 'null' }};

            // rating set
            $(document).ready(function() {
                "use strict";
                $('.rating-stars i').on('click', function() {
                    var rating = parseInt($(this).data('rating'));
                    $('#rating').val(rating);
                    updateStars(rating);
                });

                $('#rating').on('input', function() {
                    var rating = $(this).val();
                    updateStars(rating);
                });

                // Function to update stars based on the rating value
                function updateStars(rating) {
                    var stars = $('.rating-list__item_m');
                    if (rating >= 1 && rating <= 5) {
                        stars.each(function(index) {
                            if (index < rating) {
                                $(this).html('<i class="fas fa-star"></i>');
                            } else {
                                $(this).html('<i class="far fa-star"></i>');
                            }
                        });
                    } else {
                        $('#rating').val('');
                        stars.html('<i class="far fa-star"></i>');
                    }
                }
            });


        });

        (function($) {
            "use strict";
            $('select[name=gateway]').on('change',function() {
                if (!$('select[name=gateway]').val()) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                var resource = $('select[name=gateway] option:selected').data('gateway');
                var fixed_charge = parseFloat(resource.fixed_charge);
                var percent_charge = parseFloat(resource.percent_charge);
                var rate = parseFloat(resource.rate)
                if (resource.method.crypto == 1) {
                    var toFixedDigit = 8;
                    $('.crypto_currency').removeClass('d-none');
                } else {
                    var toFixedDigit = 2;
                    $('.crypto_currency').addClass('d-none');
                }
                $('.min').text(parseFloat(resource.min_amount).toFixed(2));
                $('.max').text(parseFloat(resource.max_amount).toFixed(2));
                var amount = parseFloat($('input[name=amount]').val());
                if (!amount) {
                    amount = 0;
                }
                if (amount <= 0) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                $('.preview-details').removeClass('d-none');
                var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                $('.charge').text(charge);
                var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
                $('.payable').text(payable);
                var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(
                    toFixedDigit);
                $('.final_amo').text(final_amo);
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement =
                        `<span class="fw-bold">@lang('Conversion Rate')</span> <span><span  class="fw-bold">1 {{ __($general->cur_text) }} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span></span>`;
                    $('.rate-element').html(rateElement)
                    $('.rate-element').removeClass('d-none');
                    $('.in-site-cur').removeClass('d-none');
                    $('.rate-element').addClass('d-flex');
                    $('.in-site-cur').addClass('d-flex');
                } else {
                    $('.rate-element').html('')
                    $('.rate-element').addClass('d-none');
                    $('.in-site-cur').addClass('d-none');
                    $('.rate-element').removeClass('d-flex');
                    $('.in-site-cur').removeClass('d-flex');
                }
                $('.base-currency').text(resource.currency);
                $('.method_currency').text(resource.currency);
                $('input[name=currency]').val(resource.currency);
                $('input[name=method_code]').val(resource.method_code);
                $('input[name=amount]').on('input');
            });
            $('input[name=amount]').on('input', function() {
                $('select[name=gateway]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });


            $('select[name=gateway]').on('change',function() {
                var fixed = $('select[name=gateway] option:selected').data('fixed');
                var parcent = $('select[name=gateway] option:selected').data('parcent');
                $(".fixedCharge").val(fixed);
                $(".parcentCharge").val(parcent);
            });
        })(jQuery);

        function selectedItemPrice(object) {
            $('.total_price').text('{{ $general->cur_sym }}' + object.toFixed(2));
            $('input[name=amount]').val(object);
        }
    </script>
@endpush
