@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="dashboard-section bg--black">
        <div class="dashboard">
            <div class="container">
                <div class="dashboard-body py-60">
                    <div class="row justify-content-center align-items-center gy-4">
                        <div class="col-lg-6">
                            <div class="global-card">
                                <h6 class="title mb-3">@lang('Payment Options')</h6>
                                <form action="{{ route('user.deposit.insert') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="method_code" id="method_code" value="101">
                                    <input type="hidden" name="currency" id="currency" value="USD">
                                    <div class="form-group mb-3">
                                        <label class="form-label required mb-3" for="gateway">@lang('Select Gateway')</label>
                                        <select class=" select form-control form--control" name="gateway" required=""
                                            id="gateway">
                                            <option value="">@lang('Select One')</option>
                                            @foreach ($gatewayCurrency as $data)
                                                <option value="{{ $data->method_code }}"
                                                    @selected(old('gateway') == $data->method_code)
                                                    data-gateway="{{ $data }}">
                                                    {{ $data->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label mb-3 required" for="amount">@lang('Amount')</label>
                                        <div class="input-group country-code">
                                            <input type="number" name="amount" id="amount" class="form-control form--control"
                                                   value="{{ old('amount') }}" step="any" autocomplete="off"
                                                   required>
                                            <span class="input-group-text right">{{ $general->cur_text }}</span>
                                        </div>
                                    </div>
                                    <div class="preview-details">
                                        <span>@lang('Limit')</span>
                                        <span><span class="min fw-bold">0</span> {{ __($general->cur_text) }} - <span
                                                class="max fw-bold">0</span> {{ __($general->cur_text) }}</span>
                                        <span>@lang('Charge')</span>
                                        <span><span class="charge fw-bold"> 0</span> {{ __($general->cur_text) }}, </span>
                                        <span>@lang('Payable')</span>
                                        <span>
                                            <span class="payable fw-bold">0</span>
                                            {{ __($general->cur_text) }}
                                        </span>
                                    </div>
                                    <button type="submit" class="btn btn--base w-100 mt-3">@lang('Deposit Now')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('select[name=gateway]').change(function() {
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
        })(jQuery);
    </script>
@endpush
