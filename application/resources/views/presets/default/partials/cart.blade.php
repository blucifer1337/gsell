<div class="cart-box animate__backInRight">
    <button class="close--btn"><i class="fas fa-times"></i></button>
    <div class="mb-4" id="cart-content"></div>
    <div class="cart-total">
        <h6>@lang('Cart totals')</h6>
        <ul class="mb-4">
            <li>@lang('Total '){{ __($general->cur_text) }}
                <span class="total_product_price">0</span>
            </li>
        </ul>
    </div>
    <button class="btn btn--base w-100" id="gotoCheckOut">
        @lang('Proceed To Checkout') ( <span class="allItemCounts">0</span>)</button>
</div>
