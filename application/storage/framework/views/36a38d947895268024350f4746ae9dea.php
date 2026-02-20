<?php
    $content = getContent('hero.content', true);
    $languages = App\Models\Language::all();
    $pages = App\Models\Page::all();
    $categories = App\Models\Category::whereIsMenuItem(1)->get();
    $products = App\Models\Product::whereStatus(1)
        ->limit(5)
        ->orderBy('id', 'desc')
        ->get();
    $sProduct = $products->where('discount', '>', '0')->first();
?>


<?php $__env->startSection('content'); ?>
<?php if($products && $sProduct): ?>
    <!-- < Hero Section -->
    <section class="hero bg--img"
        style="background-image: url(<?php echo e(getImage(getFilePath('frontend') . '/hero/' . $content->data_values->background_image)); ?>);">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-6 d-flex align-items-center">
                    <div class="hero-left-content">
                        <div class="product-details">
                            <a href="<?php echo e(route('user.paynow', $sProduct->id)); ?>"
                                class="hero-title animate__animated animate__fadeInUp">
                                <?php if(strlen(__($sProduct->title)) > 20): ?>
                                    <?php echo e(substr(__($sProduct->title), 0, 33) . '...'); ?>

                                <?php else: ?>
                                    <?php echo e(__($sProduct->title)); ?>

                                <?php endif; ?>
                            </a>
                            <div class="rating-wrap">
                                <?php
                                    $averageRatingHtml = avgRating($sProduct->id);
                                    echo $averageRatingHtml['ratingHtml'];
                                ?>
                                <p class="avg">(<?php echo e(__($averageRatingHtml['reviewCount'])); ?>)</p>
                            </div>
                            <div class="price-wrap wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                                <div class="price-text-wrap">
                                    <?php if($sProduct->discount > 0): ?>
                                        <h2 class="price me-1">
                                            <?php echo e($general->cur_sym); ?><?php echo e(showAmount($sProduct->final_amount)); ?></h2>
                                        <h4 class="less"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($sProduct->price)); ?></h4>
                                    <?php else: ?>
                                        <h2 class="price"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($sProduct->price)); ?> </h2>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="button-wrap wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                <a class="btn btn--base hero_btn"
                                    href="<?php echo e(route('user.paynow', $sProduct->id)); ?>"><?php echo app('translator')->get('Buy Now'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-6 col-lg-6 col-md-6">
                    <div class="hero-right">
                        <div class="hero-thumb">
                            <a href="<?php echo e(route('user.paynow', $sProduct->id)); ?>">
                                <img src="<?php echo e(getImage(getFilePath('product') . '/' . $sProduct->poster)); ?>" alt="...">
                                <?php if($sProduct->discount > 0): ?>
                                    <?php
                                        $saveAmount = $sProduct->price - $sProduct->final_amount;
                                    ?>
                                    <div class="tag top_image_bounce_2">
                                        <p><?php echo app('translator')->get('Save'); ?> <?php echo e($general->cur_sym); ?><?php echo e(showAmount($saveAmount)); ?></p>
                                    </div>
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- hero key card -->
                <div class="row gy-4 justify-content-center mt-25">
                    <?php $__currentLoopData = $products->slice(1, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <a href="<?php echo e(route('product', ['slug' => slug($product->title), 'id' => $product->id])); ?>">
                                <div class="hero-game-card">
                                    <div class="thumb">
                                        <img src="<?php echo e(getImage(getFilePath('product') . '/' . $product->poster)); ?>"
                                            alt="...">
                                    </div>
                                    <div class="content">
                                        <h6 class="title">
                                            <?php if(strlen(__($product->title)) > 20): ?>
                                                <?php echo e(substr(__($product->title), 0, 32) . '.'); ?>

                                            <?php else: ?>
                                                <?php echo e(__($product->title)); ?>

                                            <?php endif; ?>
                                        </h6>
                                        <p class="price"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($product->final_amount)); ?>

                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!--  Hero Section End -->
    <?php if($sections->secs != null): ?>
        <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make($activeTemplate . 'sections.' . $sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/home.blade.php ENDPATH**/ ?>