<?php
    $content = getContent('top_up.content', true);
    $games = App\Models\TopUp::orderBy('updated_at', 'desc')
        ->whereStatus(1)
        ->limit(6)
        ->get();
?>
<!-- PRODUCT AREA START  -->

<section class="weakly-section py-80 bg--img" style="background: url(<?php echo e(getImage(getFilePath('frontend') . '/top_up/' . $content->data_values->background_image)); ?>);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content-2">
                    <div class="title-wrap">
                        <h6 class="title"><?php echo e(__($content->data_values->title)); ?></h6>
                        <a href="<?php echo e(route('topups', 'topups')); ?>" class="btn btn--base"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $data = collect($game->services_data)->count();
            ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <a class="card-link-wrapper" href="<?php echo e(route('topup', ['slug' => slug($game->name), 'id' => $game->id])); ?>">
                    <div class="game-card">
                        <?php if($game->discount > 0): ?>
                            <div class="dis-tag">
                                <p>-<?php echo e($game->discount); ?>%</p>
                            </div>
                        <?php endif; ?>
                        <div class="thumb">
                            <img src="<?php echo e(getImage(getFilePath('topup') . '/' .'thumb_'. $game->image)); ?>" alt="product_image">
                        </div>
                        <div class="content">
                            <h6 class="title">
                                <?php if(strlen(__($game->name)) > 30): ?>
                                    <?php echo e(substr(__($game->name), 0, 55) . '..'); ?>

                                <?php else: ?>
                                    <?php echo e(__($game->name)); ?>

                                <?php endif; ?>
                            </h6>
                            <div class="price-wrap">
                                <p class="price"><?php echo e($data); ?> <?php echo app('translator')->get(' Items'); ?></p>
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
<?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/sections/top_up.blade.php ENDPATH**/ ?>