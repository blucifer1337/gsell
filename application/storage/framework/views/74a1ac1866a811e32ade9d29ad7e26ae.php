<?php
    $content = getContent('gift_card.content', true);
    $giftCards = App\Models\Product::orderBy('updated_at', 'desc')
        ->whereCategoryId(3)
        ->whereStatus(1)
        ->paginate(getPaginate(9));
    $firstAd = App\Models\Ad::where('ad_code', 4)->first();
?>

<section class="gift-section py-80">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <h6 class="fw-bold"><?php echo e(__($content->data_values->title)); ?></h6>
            <?php $__currentLoopData = $giftCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $giftCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <a href="<?php echo e(route('product', ['slug' => slug($giftCard->title), 'id' => $giftCard->id])); ?>">
                            <div class="gift-card">
                                <div class="thumb">
                                    <img src="<?php echo e(getImage(getFilePath('product') . '/' . $giftCard->poster)); ?>"
                                        alt="gift_card-image">
                                </div>
                                <div class="content">
                                    <h6 class="title">
                                        <?php if(strlen(__($giftCard->title)) > 30): ?>
                                            <?php echo e(substr(__($giftCard->title), 0, 77) . '...'); ?>

                                        <?php else: ?>
                                            <?php echo e(__($giftCard->title)); ?>

                                        <?php endif; ?>
                                    </h6>
                                    <div class="rating-wrap">
                                        <?php
                                        $averageRatingHtml = avgRating($giftCard->id);
                                        echo $averageRatingHtml['ratingHtml'];
                                        ?>
                                        <p class="avg">(<?php echo e(__( $averageRatingHtml['reviewCount'])); ?>)</p>
                                    </div>
                                    <div class="price-wrap">
                                        <?php if($giftCard->discount > 0): ?>
                                            <p class="price">
                                                <?php echo e($general->cur_sym); ?><?php echo e(showAmount($giftCard->final_amount)); ?></p>
                                            <span class="dis-price">
                                                 <?php echo e($general->cur_sym); ?><?php echo e(showAmount($giftCard->price)); ?>

                                            </span>
                                        <?php else: ?>
                                            <p class="price"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($giftCard->price)); ?></p>
                                        <?php endif; ?>
                                        <?php if($giftCard->discount > 0): ?>
                                        <?php
                                            $saveAmount = $product->price - $product->final_amount;
                                        ?>
                                        <span class="dis-tag">-<?php echo e(__($giftCard->discount)); ?>%</span>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($giftCards->hasPages()): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-content">
                        <div class="title-wrap d-flex justify-content-end mt-4">
                            <a href="<?php echo e(route('products', 'giftcard')); ?>" class="btn btn--base text-end"><?php echo app('translator')->get('See More...'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($firstAd): ?>
                <!-- ad image start -->
                <div class="long-add-wrap mt-2">
                    <div class="long-add-wrap--thumb text-center">
                        <a href="<?php echo e(@$firstAd->link); ?>" target="_blank">
                            <img src="<?php echo e(getImage(getFilePath('adImage') . '/' . @$firstAd->image)); ?>" alt="">
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- ad image end -->
            <?php endif; ?>
    </div>
</section>
<?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/sections/gift_card.blade.php ENDPATH**/ ?>