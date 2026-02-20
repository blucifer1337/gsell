<?php
    $firstAd = App\Models\Ad::where('ad_code', 1)->first();
?>
<!-- ==================== Breadcumb Start Here ==================== -->
<div class="breadcumb-2">
    <div class="container">
        <?php if($firstAd): ?>
            <!-- ad image start -->
            <div class="breadcrumb-long-add-wrap mt-2 mb-4">
                <div class="long-add-wrap--thumb text-center">
                    <a href="<?php echo e(@$firstAd->link); ?>" target="_blank">
                        <img src="<?php echo e(getImage(getFilePath('adImage') . '/' . @$firstAd->image)); ?>" alt="">
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- ad image end -->
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb-2__wrapper">
                    <ul class="breadcumb-2__lists">
                        <li class="breadcumb-2__item"><a href="<?php echo e(route('home')); ?>"
                                class="breadcumb-2__link"><?php echo app('translator')->get('Home'); ?></a></li>
                        <li class="breadcumb-2__icon"><i class="fas fa-slash"></i> </li>
                        <li class="breadcumb-2__item">
                            <span class="breadcumb-2__item-text">
                                <?php echo e(__($pageTitle)); ?>

                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ==================== Breadcumb End Here ==================== -->
<?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/partials/breadcumb.blade.php ENDPATH**/ ?>