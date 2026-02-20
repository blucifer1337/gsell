<?php
    $content = getContent('discount.content', true);
    $games = App\Models\Product::orderBy('updated_at', 'desc')
        ->where('discount', '>', '0')
        ->whereStatus(1)
        ->limit(6)
        ->get();
?>
<!-- PRODUCT AREA START  -->

<section class="weakly-section py-80 bg--img" style="background: url(<?php echo e(getImage(getFilePath('frontend') . '/discount/' . $content->data_values->background_image)); ?>);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content-2">
                    <div class="title-wrap">
                        <h6 class="title"><?php echo e(__($content->data_values->title)); ?></h6>
                        <a href="<?php echo e(route('products', 'discounts')); ?>" class="btn btn--base"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <a class="card-link-wrapper" href="<?php echo e(route('product', ['slug' => slug($game->title), 'id' => $game->id])); ?>">
                    <div class="game-card">
                        <?php if($game->discount > 0): ?>
                            <div class="dis-tag">
                                <p>-<?php echo e($game->discount); ?>%</p>
                            </div>
                        <?php endif; ?>
                        <div class="thumb">
                            <img src="<?php echo e(getImage(getFilePath('product') . '/' .'thumb_'. $game->image)); ?>" alt="product_image">
                        </div>
                        <div class="content">
                            <h6 class="title">
                                <?php if(strlen(__($game->title)) > 30): ?>
                                    <?php echo e(substr(__($game->title), 0, 55) . '..'); ?>

                                <?php else: ?>
                                    <?php echo e(__($game->title)); ?>

                                <?php endif; ?>
                            </h6>
                            <ul>
                                <li><?php echo __(@$game->platform?->icon) ?></li>
                                <li><?php echo __(@$game->device?->icon) ?></li>
                            </ul>
                            <div class="price-wrap">
                                <?php if($game->discount > 0): ?>
                                    <p class="price">
                                        <?php echo e($general->cur_sym); ?><?php echo e(showAmount($game->final_amount)); ?> </p>
                                    <span class="dis-price">
                                        <?php echo e($general->cur_sym); ?><?php echo e(showAmount($game->price)); ?>

                                    </span>
                                <?php else: ?>
                                    <p class="price">
                                        <?php echo e($general->cur_sym); ?><?php echo e(showAmount($game->price)); ?> </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- PRODUCT AREA END  -->
<?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/sections/discount.blade.php ENDPATH**/ ?>