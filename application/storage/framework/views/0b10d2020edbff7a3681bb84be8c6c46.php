<?php
    $firstAd = App\Models\Ad::where('ad_code', 6)->first();
?>

<?php $__env->startSection('content'); ?>
    <!-- PRODUCT AREA START  -->
    <section class="search-section pb-60">
        <div class="container">
            <div class="row gy-4">
                <!-- search box -->
                <div class="col-xl-3 col-lg-4">
                    <div class="game-search-box">
                        <div class="search-box-wrap">
                            <input class="form--control" id="searchValue" name="search" type="text" autocomplete="off"
                                placeholder="<?php echo app('translator')->get('Search'); ?>">
                        </div>
                        <div class="item-wrap border-bottom mt-4">
                            <h6 class="title mb-4"><?php echo app('translator')->get('Category'); ?></h6>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form--check mb-20">
                                    <input class="form-check-input filter-by-category"
                                        name="categories_<?php echo e($loop->iteration); ?>" type="checkbox" value="<?php echo e($item->id); ?>"
                                        id="categories_<?php echo e($loop->iteration); ?>">
                                    <label for="categories_<?php echo e($loop->iteration); ?>"
                                        class="form-check-label"><?php echo e($item->name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="item-wrap border-bottom">
                            <h6 class="title mb-4"><?php echo app('translator')->get('Device'); ?></h6>
                            <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form--check mb-20">
                                    <input class="form-check-input filter-by-device" name="devices_<?php echo e($loop->iteration); ?>"
                                        type="checkbox" value="<?php echo e($item->id); ?>" id="devices_<?php echo e($loop->iteration); ?>">
                                    <label for="devices_<?php echo e($loop->iteration); ?>"
                                        class="form-check-label"><?php echo e($item->name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="item-wrap border-bottom">
                            <?php if($firstAd): ?>
                                <!-- ad image start -->
                                <div class="breadcrumb-long-add-wrap mb-3">
                                    <div class="long-add-wrap--thumb">
                                        <a href="<?php echo e(@$firstAd->link); ?>" target="_blank">
                                            <img src="<?php echo e(getImage(getFilePath('adImage') . '/' . @$firstAd->image)); ?>"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- ad image end -->
                            <?php endif; ?>
                        </div>
                        <div class="item-wrap border-bottom">
                            <h6 class="title mb-4"><?php echo app('translator')->get('Platform'); ?></h6>
                            <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form--check mb-20">
                                    <input class="form-check-input filter-by-platfrom"
                                        name="platforms_<?php echo e($loop->iteration); ?>" type="checkbox"
                                        value="<?php echo e($item->id); ?>" id="platforms_<?php echo e($loop->iteration); ?>">
                                    <label for="platforms_<?php echo e($loop->iteration); ?>"
                                        class="form-check-label"><?php echo e($item->name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="item-wrap border-bottom">
                            <h6 class="title mb-4"><?php echo app('translator')->get('Genre'); ?></h6>
                            <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form--check mb-20">
                                    <input class="form-check-input filter-by-genre" name="genres_<?php echo e($loop->iteration); ?>"
                                        type="checkbox" value="<?php echo e($item->id); ?>" id="genres_<?php echo e($loop->iteration); ?>">
                                    <label for="genres_<?php echo e($loop->iteration); ?>"
                                        class="form-check-label"><?php echo e($item->name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <!-- search box end -->

                <div class="col-xl-9 col-lg-8 main-content">
                    <div class="row gy-4">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <a class="card-link-wrapper"
                                    href="<?php echo e(route('product', ['slug' => slug($product->title), 'id' => $product->id])); ?>">
                                    <div class="game-card">
                                        <?php if($product->discount > 0): ?>
                                            <div class="dis-tag">
                                                <p>-<?php echo e($product->discount); ?>%</p>
                                            </div>
                                        <?php endif; ?>
                                        <div class="thumb">
                                            <img src="<?php echo e(getImage(getFilePath('product') . '/' . 'thumb_' . $product->image)); ?>"
                                                alt="...">
                                        </div>
                                        <div class="content">
                                            <h6 class="title">
                                                <?php if(strlen(__($product->title)) > 30): ?>
                                                    <?php echo e(substr(__($product->title), 0, 55) . '...'); ?>

                                                <?php else: ?>
                                                    <?php echo e(__($product->title)); ?>

                                                <?php endif; ?>
                                            </h6>
                                            <ul>
                                                <li><?php echo __(@$product->platform?->icon) ?></li>
                                                <li><?php echo __(@$product->device?->icon) ?></li>
                                            </ul>
                                            <div class="price-wrap">
                                                <?php if($product->discount > 0): ?>
                                                    <p class="price">
                                                        <?php echo e($general->cur_sym); ?><?php echo e(showAmount($product->final_amount)); ?>

                                                    </p>
                                                    <span class="dis-price">
                                                        <?php echo e($general->cur_sym); ?><?php echo e(showAmount($product->price)); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <p class="price">
                                                        <?php echo e($general->cur_sym); ?><?php echo e(showAmount($product->price)); ?> </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div>
                                <p class="text-muted text-center" colspan="100%"><?php echo app('translator')->get('No Product Found'); ?></p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <!-- pagination -->
            <div class="row py-3 mt-4">
                <div class="col-lg-12 justify-content-end d-flex">
                    <nav aria-label="Page navigation example">
                        <?php if($products->hasPages()): ?>
                            <?php echo e(paginateLinks($products)); ?>

                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- PRODUCT AREA END  -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $("#searchValue").on('keyup', function() {

                var categories = [];
                var searchValue = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = $(this).val();

                getFilteredData(categories, devices, platforms, genres, searchValue)

            });

            $("input[type='checkbox'][name^='categories_']").on('click', function() {
                var categories = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = [];
                $('.filter-by-category:checked').each(function() {
                    if (!categories.includes(parseInt($(this).val()))) {
                        categories.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories, devices, platforms, genres, searchValue)
            });
            $("input[type='checkbox'][name^='devices_']").on('click', function() {
                var categories = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = [];
                $('.filter-by-device:checked').each(function() {
                    if (!devices.includes(parseInt($(this).val()))) {
                        devices.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories, devices, platforms, genres, searchValue)
            });
            $("input[type='checkbox'][name^='platforms_']").on('click', function() {
                var categories = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = [];
                $('.filter-by-platfrom:checked').each(function() {
                    if (!platforms.includes(parseInt($(this).val()))) {
                        platforms.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories, devices, platforms, genres, searchValue)
            });
            $("input[type='checkbox'][name^='genres_']").on('click', function() {
                var categories = [];
                var devices = [];
                var platforms = [];
                var genres = [];

                var searchValue = [];
                $('.filter-by-genre:checked').each(function() {
                    if (!genres.includes(parseInt($(this).val()))) {
                        genres.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(categories, devices, platforms, genres, searchValue)
            });

            function getFilteredData(categories, devices, platforms, genres, searchValue) {
                $.ajax({
                    type: "get",
                    url: "<?php echo e(route('product.search.items.all')); ?>",
                    data: {
                        "categories": categories,
                        "devices": devices,
                        "platforms": platforms,
                        "genres": genres,
                        "search": searchValue
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.html) {
                            $('.main-content').html(response.html);
                        }
                        if (response.error) {
                            notify('error', response.error);
                        }
                    }
                });
            }
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/products.blade.php ENDPATH**/ ?>