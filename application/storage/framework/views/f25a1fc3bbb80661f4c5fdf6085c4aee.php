<?php
    $content = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false, 4);
    $policyPages = getContent('policy_pages.element');
    $pages = App\Models\Page::all();

?>

<!-- FOOTER AREA START  -->

<!-- ==================== Footer Start Here ==================== -->
<footer class="footer-area section-bg">
    <div class="footer-top pt-80 pb-4">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-4 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <a href="<?php echo e(route('home')); ?>" class="footer-logo-normal" id="footer-logo-normal">
                                <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="">
                            </a>
                        </div>
                        <p class="footer-item__desc wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                            <?php echo e($content->data_values->short_details); ?>

                        </p>

                        <ul class="social-list wow animate__animated animate__fadeInUp" data-wow-delay="1s">
                            <?php $__currentLoopData = $socialIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="social-list__item">
                                    <a href="<?php echo e($icon->data_values->url); ?>" class="social-list__link icon-wrapper">
                                        <div class="icon"><?php echo $icon->data_values->social_icon; ?></div>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Important Links'); ?></h5>
                        <ul class="footer-menu">
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page->slug == 'about'): ?>
                                    <li class="footer-menu__item wow animate__fadeInUp animate__animated"
                                        data-wow-delay="0.2s">
                                        <a href="<?php echo e(route('pages', $page->slug)); ?>" class="footer-menu__link">
                                            <i class="fas fa-angle-double-right"></i>
                                            <?php echo e(__($page->name)); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page->slug == 'blog'): ?>
                                    <li class="footer-menu__item wow animate__fadeInUp animate__animated"
                                        data-wow-delay="0.2s">
                                        <a href="<?php echo e(route('pages', $page->slug)); ?>" class="footer-menu__link"
                                            target="_blank">
                                            <i class="fas fa-angle-double-right"></i>
                                            <?php echo e(__($page->name)); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="footer-menu__item wow animate__fadeInUp animate__animated" data-wow-delay="0.3s">
                                <a href="<?php echo e(route('user.login')); ?>" class="footer-menu__link" target="_blank">
                                    <i class="fas fa-angle-double-right"></i><?php echo app('translator')->get('Login'); ?>
                                </a>
                            </li>
                            <li class="footer-menu__item wow animate__fadeInUp animate__animated" data-wow-delay="0.3s">
                                <a href="<?php echo e(route('user.register')); ?>" class="footer-menu__link" target="_blank">
                                    <i class="fas fa-angle-double-right"></i><?php echo app('translator')->get('Registration'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Company Links'); ?></h5>
                        <ul class="footer-menu">
                            <?php $__currentLoopData = $policyPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="footer-menu__item wow animate__fadeInUp animate__animated"
                                    data-wow-delay="0.2s">
                                    <a href="<?php echo e(route('policy.pages', [slug($policy->data_values->title), $policy->id])); ?>"
                                        class="footer-menu__link" target="_blank">
                                        <i class="fas fa-angle-double-right"></i>
                                        <?php echo e(__($policy->data_values->title)); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="footer-menu__item wow animate__fadeInUp animate__animated" data-wow-delay="0.3s">
                                <a href="<?php echo e(route('cookie.policy')); ?>" class="footer-menu__link" target="_blank">
                                    <i class="fas fa-angle-double-right"></i><?php echo app('translator')->get('Cookie Policy'); ?>
                                </a>
                            </li>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page->slug == 'contact'): ?>
                                    <li class="footer-menu__item wow animate__fadeInUp animate__animated"
                                        data-wow-delay="0.2s">
                                        <a href="<?php echo e(route('pages', $page->slug)); ?>" class="footer-menu__link"
                                            target="_blank">
                                            <i class="fas fa-angle-double-right"></i>
                                            <?php echo e(__($page->name)); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Newsletter'); ?></h5>
                        <p class="footer-item__desc">
                            <?php echo e(__($content->data_values->subscribe_short_desc)); ?>

                        </p>
                        <div class="subscribe-box">
                            <form method="post" action="<?php echo e(route('subscribe')); ?>">
                                <?php echo csrf_field(); ?>
                                <input class="form--control footer-input" type="text" placeholder="Email Address"
                                    required>
                                <button class="btn btn--base sub-btn" type="submit"><?php echo app('translator')->get('Subscribe'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top End-->

    <!-- bottom Footer -->
    <div class="bottom-footer py-4 mb-3 mt-4">
        <div class="container">
            <div class="row text-center gy-2">
                <div class="col-lg-12">
                    <div class="bottom-footer-text"><?php echo $content->data_values->website_footer; ?></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ==================== Footer End Here ==================== -->

<div class="scroll-top show">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
            style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 197.514;">
        </path>
    </svg>
    <i class="fas fa-arrow-up"></i>
</div>
<?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/partials/footer.blade.php ENDPATH**/ ?>