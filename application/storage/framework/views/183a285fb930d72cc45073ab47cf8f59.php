<?php
    $user = auth()->user();
    $pages = App\Models\Page::all();
    $languages = App\Models\Language::all();
    $categories = App\Models\Category::whereIsMenuItem(1)->get();
    $wishlistCount = App\Models\Wishlist::where('user_id', @auth()->user()->id)->count();
    $devices = App\Models\Device::where('is_menu_item', 1)->latest()->take(3)->get();

?>
<!--========================== Header section Start ==========================-->
<div class="header-main-area">
    <div class="header" id="header">
        <div class="container position-relative">
            <div class="row">
                <div class="header-wrapper">
                    <!-- ham menu -->
                    <i class="fas fa-bars  ham__menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                        aria-controls="offcanvasExample"></i>

                    <!-- logo -->
                    <div class="header-menu-wrapper align-items-center d-flex">
                        <div class="logo-wrapper">
                            <a href="<?php echo e(route('home')); ?>" class="normal-logo" id="normal-logo"> <img
                                    src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="...">
                            </a>
                        </div>
                    </div>
                    <!-- / logo -->
                    <!-- < search box -->
                    <div class="search-box-wrap">
                        <form>
                            <input class="form--control header-input" autocomplete="off"
                                placeholder="What are you looking for?" id="searchItems">
                            <button class="btn--base header-sub-btn"><i class="fas fa-search"></i></button>
                        </form>
                        <ul class="textcolor search_results"></ul>
                    </div>
                    <!-- search box end/> -->

                    <div class="menu-right-wrapper">
                        <ul>
                            <li class="language">
                                <div class="language-box">
                                    <i class="fas fa-globe"></i>
                                    <select class="langSel select">
                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($lang->code); ?>"
                                                <?php if(Session::get('lang') === $lang->code): ?> selected <?php endif; ?>>
                                                <?php echo e(__($lang->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </li>
                            <li class="profile-option">
                                <?php if(auth()->guard()->guest()): ?>
                                    <a href="<?php echo e(route('user.login')); ?>" class="login-registration-list__link">
                                        <i class="fas fa-user"></i><?php echo app('translator')->get(' Login'); ?></a>
                                <?php else: ?>
                                    <a href="javascript:void(0)"><i class="las la-user"></i> <?php echo app('translator')->get('Profile'); ?></a>
                                    <div class="profile-dropdown-menu">
                                        <ul>
                                            <li><a href="<?php echo e(route('user.profile.setting')); ?>"><?php echo app('translator')->get('Profile Settings'); ?></a></li>
                                            <li><a href="<?php echo e(route('user.change.password')); ?>"><?php echo app('translator')->get('Change Password'); ?></a></li>
                                            <li><a href="<?php echo e(route('user.twofactor')); ?>"><?php echo app('translator')->get('2Fa Security'); ?></a></li>
                                            <li><a href="<?php echo e(route('user.logout')); ?>"
                                                    class="login-registration-list__link"><?php echo app('translator')->get('Logout '); ?></a></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </li>
                            <li class="login-registration-list__item ">
                                <a href="javascript:void(0)" class="cart-btn">
                                    <i class="las la-shopping-cart"></i>
                                    <span class="count-item" id="cartItem"><?php echo e(count((array) session('cart'))); ?></span>
                                </a>
                            </li>
                            <li class="login-registration-list__item whishlist">
                                <?php if(auth()->guard()->check()): ?>
                                    <a href="<?php echo e(route('user.get.wishlist')); ?>" class="wishlis_btn">
                                        <i class="far fa-heart"></i>
                                        <span class="count-item" id="wishlistItem"><?php echo e(__($wishlistCount)); ?></span>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="mobile-search-box">
                        <div class="mobile-search-wrap">
                            <div class="input-wrap">
                                <form>
                                    <input class="form--control mobile-search-input" placeholder="Search"
                                        id="mobileSearchItems">
                                </form>
                                <ul class="textcolor search_results"></ul>
                            </div>
                            <button class="mobile-search-btn"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="header-wrapper-2">
                    <!-- ham menu -->
                    <i class="fa-sharp fa-solid fa-bars-staggered ham__menu" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    </i>

                    <div class="menu-wrapper">
                        <ul class="main-menu">
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(Request::routeIs('user.*')): ?>
                                    <li>
                                        <a class="<?php echo e(Route::is('user.home') ? 'active' : ''); ?>"
                                            href="<?php echo e(route('user.home')); ?>">
                                            <?php echo app('translator')->get('Dashboard'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Route::is('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                                            <?php echo app('translator')->get('Home'); ?>
                                        </a>
                                    </li>
                                    <li class="profile-option">

                                        <a href="javascript:void(0)"
                                            class="<?php echo e(Request::routeIs('user.deposit') ? 'active' : ''); ?> ">
                                            <?php echo app('translator')->get(' Wallet'); ?>
                                        </a>
                                        <div class="profile-dropdown-menu">
                                            <ul>
                                                <li>
                                                    <?php echo app('translator')->get(' Balance '); ?><?php echo e($general->cur_sym); ?><?php echo e(showAmount(Auth::user()->balance)); ?>

                                                </li>
                                                <li><a href="<?php echo e(route('user.deposit')); ?>"
                                                        class="<?php echo e(Request::routeIs('user.deposit') ? 'active' : ''); ?> ">
                                                        <?php echo app('translator')->get('Deposit'); ?>
                                                    </a>
                                                </li>
                                                <li><a href="<?php echo e(route('user.deposit.history')); ?>"
                                                        class="<?php echo e(Request::routeIs('user.deposit.history') ? 'active' : ''); ?>">
                                                        <?php echo app('translator')->get('Deposit Log'); ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </li>

                                    <li>
                                        <a href="<?php echo e(route('user.transactions')); ?>"
                                            class="<?php echo e(Request::routeIs('user.transactions') ? 'active' : ''); ?>">
                                            <?php echo app('translator')->get('Transaction'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(route('ticket')); ?>"
                                            class="<?php echo e(Request::routeIs('ticket') ? 'active' : ''); ?>">
                                            <?php echo app('translator')->get('My Tickets'); ?>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a class="<?php echo e(Route::is('user.home') ? 'active' : ''); ?>"
                                            href="<?php echo e(route('user.home')); ?>">
                                            <?php echo app('translator')->get('Dashboard'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Route::is('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                                            <?php echo app('translator')->get('Home'); ?>
                                        </a>
                                    </li>
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($page->slug != 'blog' && $page->slug != 'contact' && $page->slug != '/'): ?>
                                            <li>
                                                <a class="<?php echo e(request()->is('pages', $page->slug) ? 'active' : ''); ?>"
                                                    href="<?php echo e(route('pages', $page->slug)); ?>"><?php echo e(__($page->name)); ?>

                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a class="<?php echo e(Route::is('products', 'shop') ? 'active' : ''); ?>"
                                            href="<?php echo e(route('products', 'shop')); ?>">
                                            <?php echo app('translator')->get('Shop'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?php echo e(Route::is('topups', 'topups') ? 'active' : ''); ?>"
                                            href="<?php echo e(route('topups', 'topups')); ?>">
                                            <?php echo app('translator')->get('Top Up'); ?>
                                        </a>
                                    </li>
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($page->slug == 'contact'): ?>
                                            <li>
                                                <a class="<?php echo e(request()->is('pages', $page->slug) ? 'active' : ''); ?>"
                                                    href="<?php echo e(route('pages', $page->slug)); ?>"><?php echo e(__($page->name)); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <li>
                                    <a class="<?php echo e(Route::is('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                                        <?php echo app('translator')->get('Home'); ?>
                                    </a>
                                </li>
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($page->slug == 'about'): ?>
                                        <li>
                                            <a class="<?php echo e(request()->is('pages', $page->slug) ? 'active' : ''); ?>"
                                                href="<?php echo e(route('pages', $page->slug)); ?>"><?php echo e(__($page->name)); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a class="<?php echo e(Route::is('products', 'shop') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('products', 'shop')); ?>">
                                        <?php echo app('translator')->get('Shop'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="<?php echo e(Route::is('topups', 'topups') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('topups', 'topups')); ?>">
                                        <?php echo app('translator')->get('Top Up'); ?>
                                    </a>
                                </li>
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($page->slug == 'contact'): ?>
                                        <li>
                                            <a class="<?php echo e(request()->is('pages', $page->slug) ? 'active' : ''); ?>"
                                                href="<?php echo e(route('pages', $page->slug)); ?>"><?php echo e(__($page->name)); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="menu-right-wrapper">
                        <ul>
                            <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <li>
                                <a href="<?php echo e(route('devices', [$item->id,slug($item->name)])); ?>">
                                    <?php echo $item->icon ?>
                                    <?php echo e(__($item->name)); ?>

                                </a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--========================== Header section End ==========================-->

<!--========================== Sidebar mobile menu wrap Start ==========================-->
<div class="offcanvas offcanvas-start text-bg-light" tabindex="-1" id="offcanvasExample">
    <div class="offcanvas-header">
        <div class="logo">
            <div class="header-menu-wrapper align-items-center d-flex">
                <div class="logo-wrapper">
                    <a href="<?php echo e(route('home')); ?>" class="normal-logo" id="offcanvas-logo-normal">
                        <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="">
                    </a>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php if(auth()->guard()->check()): ?>
            <?php
                $userFname = $user->firstname;
                $userLname = $user->lastname;
                $fullname = $userFname . ' ' . $userLname;
            ?>
            <div class="user-info">
                <div class="user-thumb">
                    <?php if(auth()->user()->image): ?>
                        <a href="<?php echo e(route('user.home')); ?>">
                            <img src="<?php echo e(getImage(getFilePath('userProfile') . '/' . auth()->user()->image)); ?>"
                                alt="user-thumb">
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('user.home')); ?>">
                            <img src="<?php echo e(getImage('assets/presets/default/images/avater/profile.jpg')); ?>"
                                alt="user-thumb">
                        </a>
                    <?php endif; ?>
                </div>
                <a href="<?php echo e(route('user.home')); ?>">
                    <h4><?php echo e(__($fullname)); ?></h4>
                </a>
            </div>
        <?php endif; ?>
        <ul class="side-Nav">
            <li>
                <?php if(auth()->guard()->check()): ?>
                    <a class="<?php echo e(Route::is('user.home') ? 'active' : ''); ?>" href="<?php echo e(route('user.home')); ?>">
                        <?php echo app('translator')->get('Dashboard'); ?></a>
                <?php endif; ?>
            </li>
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <?php if($page->slug != 'blog' && $page->slug != 'contact'): ?>
                        <a class="<?php echo e(request()->is('pages', $page->slug) ? 'active' : ''); ?>"
                            href="<?php echo e(route('pages', $page->slug)); ?>"><?php echo e(__($page->name)); ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a class="<?php echo e(Route::is('products', 'shop') ? 'active' : ''); ?>"
                    href="<?php echo e(route('products', 'shop')); ?>">
                    <?php echo app('translator')->get('Shop'); ?>
                </a>
            </li>
            <li>
                <a class="<?php echo e(Route::is('topups', 'topups') ? 'active' : ''); ?>"
                    href="<?php echo e(route('topups', 'topups')); ?>">
                    <?php echo app('translator')->get('Top Up'); ?>
                </a>
            </li>
            <li>
                <button class="cart-btn"><?php echo app('translator')->get('Cart Item'); ?></button>
            </li>
            <?php if(auth()->guard()->check()): ?>
                <li class="profile-option">

                    <a href="javascript:void(0)" class="<?php echo e(Request::routeIs('user.deposit') ? 'active' : ''); ?> ">
                        <?php echo app('translator')->get(' Wallet'); ?>
                    </a>
                    <div class="profile-dropdown-menu">
                        <ul>
                            <li>
                                <?php echo app('translator')->get(' Balance '); ?><?php echo e($general->cur_sym); ?><?php echo e(showAmount(Auth::user()->balance)); ?>

                            </li>
                            <li><a href="<?php echo e(route('user.deposit')); ?>"
                                    class="<?php echo e(Request::routeIs('user.deposit') ? 'active' : ''); ?> ">
                                    <?php echo app('translator')->get('Deposit'); ?>
                                </a>
                            </li>
                            <li><a href="<?php echo e(route('user.deposit.history')); ?>"
                                    class="<?php echo e(Request::routeIs('user.deposit.history') ? 'active' : ''); ?>">
                                    <?php echo app('translator')->get('Deposit Log'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                </li>

                <li>
                    <a href="<?php echo e(route('user.transactions')); ?>"
                        class="<?php echo e(Request::routeIs('user.transactions') ? 'active' : ''); ?>">
                        <?php echo app('translator')->get('Transaction'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('ticket')); ?>"
                        class="<?php echo e(Request::routeIs('ticket') ? 'active' : ''); ?>">
                        <?php echo app('translator')->get('My Tickets'); ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <?php if($page->slug == 'contact'): ?>
                        <a class="<?php echo e(request()->is('pages', $page->slug) ? 'active' : ''); ?>"
                            href="<?php echo e(route('pages', $page->slug)); ?>"><?php echo e(__($page->name)); ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php if(auth()->guard()->guest()): ?>
                    <a class="<?php echo e(Route::is('contact') ? 'active' : ''); ?>" href="<?php echo e(route('user.login')); ?>">
                        <?php echo app('translator')->get('Login'); ?></a>
                <?php else: ?>
                    <a class="<?php echo e(Route::is('contact') ? 'active' : ''); ?>" href="<?php echo e(route('user.logout')); ?>">
                        <?php echo app('translator')->get('Logout'); ?></a>
                <?php endif; ?>
            </li>

            <li class="language">
                <div class="language-box">
                    <select class="langSel select">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lang->code); ?>" <?php if(Session::get('lang') === $lang->code): ?> selected <?php endif; ?>>
                                <?php echo e(__($lang->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </li>
        </ul>
    </div>
</div>
<!--========================== Sidebar mobile menu wrap End ==========================-->

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "<?php echo e(route('home')); ?>/change/" + $(this).val();
            });

            $(document).on('click', '#gotoCheckOut', gotoCheckOut)
            // Show Cart
            $(document).ready(function() {
                "use strict";
                $('.cart-btn, .request-link').on('click', function() {

                    getCart();

                    $('.cart-box').addClass('show-cart-box');
                    $('.sidebar-overlay').addClass('show');
                });

                $('.close--btn, .sidebar-overlay').on('click', function() {
                    $('.cart-box').removeClass('show-cart-box');
                    $('.sidebar-overlay').removeClass('show');
                });
            });

            // live search
            $(document).on('keyup', '#searchItems', searchItems);
            $(document).on('keyup', '#mobileSearchItems', searchItems);

            // add quantity
            $(document).on('click', '.add', function() {
                var quantityInput = $(this).siblings('#quantityInput');
                let value = quantityInput.val();
                let limit = quantityInput.data('limit')
                let exceed = parseInt(value) + 1;
                if (exceed > limit) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Stock limit exceed'
                    });
                    return;
                }
                if (value > 0) {
                    quantityInput.val(++value)
                    calculateTotalAmount()
                }

            })

            // sub quantity
            $(document).on('click', '.sub', function() {

                var quantityInput = $(this).siblings('#quantityInput');
                var productId = quantityInput.data('product-id');
                let value = quantityInput.val();
                if (value > 1) {
                    quantityInput.val(--value)
                    calculateTotalAmount()
                }
            });
        })

        function deleteCartItem(id) {
            $.ajax({
                url: '<?php echo e(route('remove.cart')); ?>',
                type: 'get',
                data: {
                    'productId': id
                },
                success: function(response) {
                    if (response.hasOwnProperty('message')) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        getCart();
                        updateCartItemCount(response.cartItemCount);
                        setTimeout(function() {
                            calculateTotalAmount();
                            $('.allItemCounts').text(totalSelectedProducts());
                        }, 300)
                    }

                }
            })
        }

        function getCart() {
            $.ajax({
                url: '<?php echo e(route('get.cart')); ?>',
                type: 'get',
                data: {},
                success: function(response) {

                    let items = response.items;
                    let cartContent = $('#cart-content');
                    cartContent.html('');
                    cartContent.html(response.html);
                },

                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errorMessage = xhr.responseJSON.error;
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    } else {
                        var errorMessage =
                            'Error occurred while adding the product to cart.';
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                }
            });
            calculateTotalAmount();
        }

        // checkout
        function gotoCheckOut(event) {
            event.preventDefault();
            let products = $("input[name='products[]']")
            var selectedItems = []
            products.each(function(index, product) {
                if ($(product).is(":checked")) {
                    let item = {
                        id: $(product).val(),
                        quantity: $(product).parent().parent().find('#quantityInput').val()
                    }
                    selectedItems.push(item)
                }
            })

            if (selectedItems.length == 0) {
                $('.cart-box').removeClass('show-cart-box');
                $('.sidebar-overlay').removeClass('show');
                Toast.fire({
                    icon: 'error',
                    title: 'Pleas select any Item'
                });
                return
            }
            let httpQuery = '';
            selectedItems.forEach((item, key) => {
                let productsQuery = `products[${item.id}]=${item.quantity}`
                httpQuery += ((key == 0 ? '?' : '&') + productsQuery);
            });
            window.location.href = "<?php echo e(route('user.paynow')); ?>" + httpQuery
        }

        function allSelectedItems(object) {
            var checked = $(object).is(":checked");
            if (checked) {

                toggleSelectedItems(true);
            } else {
                toggleSelectedItems(false);
            }
            updatProductSelection(this);
        }

        function toggleSelectedItems(checked) {
            let products = $("input[name='products[]']")
            products.each(function(index, product) {
                $(product).prop('checked', checked);
            })
        }

        function anyItemChecked() {
            let products = $("input[name='products[]']")
            var isAllSelected = true;
            products.each(function(index, product) {
                if (!$(product).is(":checked")) {
                    isAllSelected = false;
                }
            })
            return isAllSelected;
        }

        function updatProductSelection(object) {
            $('.allItemCounts').text(totalSelectedProducts());

            $('.allSelectedItems').prop('checked', anyItemChecked());
            calculateTotalAmount();
        }

        function updatProducSelection(object) {
            $('.allItemCounts').text(totalSelectedProducts());

            $('.allSelectedItems').prop('checked', anyItemChecked());
            calculateTotalAmount();
        }

        function calculateTotalAmount() {
            let products = $("input[name='products[]']");
            var total = 0;
            products.each(function(index, product) {
                if ($(product).is(":checked")) {
                    let price = $(product).data('price')
                    let quantity = $(product).parent().parent().find('#quantityInput').val();
                    total += price * quantity;
                }
            })
            $('.total_product_price').text('<?php echo e($general->cur_sym); ?>' + total.toFixed(2));

        }

        function totalSelectedProducts() {
            let products = $("input[name='products[]']")
            var selectedIds = []
            products.each(function(index, product) {
                if ($(product).is(":checked")) {
                    selectedIds.push($(product).val())
                }
            })

            return selectedIds.length
        }

        var timeout = null;

        function searchItems(event) {
            var value = $(this).val()
            if (value.length == 0) {
                $('.search_results').hide()
            }

            clearTimeout(timeout);
            timeout = setTimeout(() => {
                // do something: send an ajax or call a function here
                $.ajax({
                    url: "<?php echo e(route('product.live.search')); ?>",
                    type: 'get',
                    data: {
                        'q': $(this).val()
                    },
                    success: function(products) {
                        var hasProducts = true;
                        var html = '';
                        if (products.length > 0) {
                            products.forEach(product => {
                                html +=
                                    `<li><a href="${product.link}">${product.title}</a></li>`
                            });
                        } else {
                            hasProducts = false;
                            html += `<li class="text-center">No Product Found</li>`
                        }

                        $('.search_results').html('')
                        $('.search_results').show()
                        $('.search_results').html(html)
                        if (hasProducts == false || value.length == 0) {

                            setTimeout(function() {
                                $('.search_results').hide()
                            }, value.length == 0 ? 0 : 4000)
                        }

                    }
                })
            }, 1000);

        }

        function updateCartItemCount(count) {
            $('#cartItem').text(count);
        }

        $('body').on('click', function(event) {
            $('.search_results').hide();
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u539065483/domains/adsunlock.store/public_html/selldigital/application/resources/views/presets/default/partials/header.blade.php ENDPATH**/ ?>