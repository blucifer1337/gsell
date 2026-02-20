<div class="cart-box animate__backInRight">
    <button class="close--btn"><i class="fas fa-times"></i></button>
    <div class="mb-4" id="cart-content"></div>
    <div class="cart-total">
        <h6><?php echo app('translator')->get('Cart totals'); ?></h6>
        <ul class="mb-4">
            <li><?php echo app('translator')->get('Total '); ?><?php echo e(__($general->cur_text)); ?>

                <span class="total_product_price">0</span>
            </li>
        </ul>
    </div>
    <button class="btn btn--base w-100" id="gotoCheckOut">
        <?php echo app('translator')->get('Proceed To Checkout'); ?> ( <span class="allItemCounts">0</span>)</button>
</div>
<?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/partials/cart.blade.php ENDPATH**/ ?>