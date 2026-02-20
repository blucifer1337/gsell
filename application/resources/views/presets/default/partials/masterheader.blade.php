@php
    $user = auth()->user();
    $pages = App\Models\Page::all();
    $languages = App\Models\Language::all();
    $categories = App\Models\Category::whereIsMenuItem(1)->get();
    $wishlistCount = App\Models\Wishlist::where('user_id', @auth()->user()->id)->count();
@endphp
<!--========================== Header section Start ==========================-->
<div class="header-main-area">
    <div class="header" id="header">
        <div class="container position-relative">
            <div class="row">
                <div class="header-wrapper">
                    <!-- ham menu -->
                    <i class="fa-sharp fa-solid fa-bars-staggered ham__menu" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"></i>

                    <!-- logo -->
                    <div class="header-menu-wrapper align-items-center d-flex">
                        <div class="logo-wrapper">
                            <a href="{{ route('home') }}" class="normal-logo" id="normal-logo"> <img
                                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="...">
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
                        <ul class="textcolor" id="search_results">
                        </ul>
                    </div>
                    <!-- search box end/> -->

                    <div class="menu-right-wrapper">
                        <ul>
                            <li class="language">
                                <div class="language-box">
                                    <i class="fas fa-globe"></i>
                                    <select class="langSel select">
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->code }}"
                                                @if (Session::get('lang') === $lang->code) selected @endif>
                                                {{ __($lang->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="profile-option">
                                @guest
                                    <a href="{{ route('user.login') }}" class="login-registration-list__link">
                                        <i class="fas fa-user"></i>@lang(' Login')</a>
                                @else
                                    <a href="javascript:void(0)"><i class="las la-user"></i> @lang('Profile')</a>
                                    <div class="profile-dropdown-menu">
                                        <ul>
                                            <li><a href="{{ route('user.profile.setting') }}">@lang('Profile Settings')</a></li>
                                            <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                                            <li><a href="{{ route('user.twofactor') }}">@lang('2Fa Security')</a></li>
                                            <li><a href="{{ route('user.logout') }}"
                                                    class="login-registration-list__link">@lang('Logout ')</a></li>
                                        </ul>
                                    </div>
                                @endguest
                            </li>
                            <li class="login-registration-list__item ">
                                <a href="javascript:void(0)" class="cart-btn">
                                    <i class="las la-shopping-cart"></i>
                                    <span class="count-item" id="cartItem">{{ count((array) session('cart')) }}</span>
                                </a>
                            </li>
                            <li class="login-registration-list__item whishlist">
                                @auth
                                    <a href="{{ route('user.get.wishlist') }}" class="wishlis_btn">
                                        <i class="far fa-heart"></i>
                                        <span class="count-item" id="wishlistItem">{{ __($wishlistCount) }}</span>
                                    </a>
                                @endauth
                            </li>
                        </ul>
                    </div>
                    <div class="mobile-search-box">
                        <div class="mobile-search-wrap">
                            <div class="input-wrap">
                                <form>
                                    <input class="form--control mobile-search-input" placeholder="Search">
                                </form>
                            </div>
                            <button class="mobile-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                            <li>
                                @auth
                                    <a class="{{ Route::is('user.home') ? 'active' : '' }}"
                                        href="{{ route('user.home') }}">
                                        @lang('Dashboard')
                                    </a>
                                @endauth
                            </li>
                            @foreach ($pages as $page)
                                <li>
                                    @if ($page->slug != 'blog' && $page->slug != 'contact')
                                        <a class="{{ request()->is('pages', $page->slug) ? 'active' : '' }}"
                                            href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                                    @endif
                                </li>
                            @endforeach
                            <li>
                                <a class="{{ Route::is('products', 'shop') ? 'active' : '' }}"
                                    href="{{ route('products', 'shop') }}">
                                    @lang('Shop')
                                </a>
                            </li>
                            <li class="profile-option">
                                @auth
                                    <a href="javascript:void(0)"
                                        class="{{ Request::routeIs('user.deposit') ? 'active' : '' }} ">
                                        @lang(' Wallet')
                                    </a>
                                    <div class="profile-dropdown-menu">
                                        <ul>
                                            <li>
                                                @lang(' Balance '){{ $general->cur_sym }}{{ showAmount(Auth::user()->balance) }}
                                            </li>
                                            <li><a href="{{ route('user.deposit') }}"
                                                    class="{{ Request::routeIs('user.deposit') ? 'active' : '' }} ">
                                                    @lang('Deposit')
                                                </a>
                                            </li>
                                            <li><a href="{{ route('user.deposit.history') }}"
                                                    class="{{ Request::routeIs('user.deposit.history') ? 'active' : '' }}">
                                                    @lang('Deposit Log')
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endauth
                            </li>
                            <li>
                                @auth
                                    <a href="{{ route('user.transactions') }}"
                                        class="{{ Request::routeIs('user.transactions') ? 'active' : '' }}">
                                        @lang('Transaction')
                                    </a>
                                @endauth
                            </li>
                            @foreach ($pages as $page)
                                <li>
                                    @if ($page->slug != '/' && $page->slug != 'about' && $page->slug != 'blog')
                                        <a class="{{ request()->is('pages', $page->slug) ? 'active' : '' }}"
                                            href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="menu-right-wrapper">
                        <ul>
                            <li>
                                <a href="{{ route('products', 3) }}"><i class="las la-mouse"></i>@lang(' PC Game')</a>
                            </li>
                            <li>
                                <a href="{{ route('products', 1) }}"><i
                                        class="las la-gamepad"></i>@lang(' PS4 Game')</a>
                            </li>
                            <li>
                                <a href="{{ route('products', 2) }}"><i class="lab la-xbox"></i>@lang(' Xbox game')</a>
                            </li>
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
                    <a href="{{ route('home') }}" class="normal-logo" id="offcanvas-logo-normal">
                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @auth
            @php
                $userFname = $user->firstname;
                $userLname = $user->lastname;
                $fullname = $userFname . ' ' . $userLname;
            @endphp
            <div class="user-info">
                <div class="user-thumb">
                    <a href="userDashboard.html">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image) }}" alt="avatar">
                    </a>
                </div>
                <a href="{{ route('user.home') }}">
                    <h4>{{ __($fullname) }}</h4>
                </a>
            </div>
        @endauth
        <ul class="side-Nav">
            <li>
                @auth
                    <a class="{{ Route::is('user.home') ? 'active' : '' }}" href="{{ route('user.home') }}">
                        @lang('Dashboard')</a>
                @endauth
            </li>
            @foreach ($pages as $page)
                <li>
                    @if ($page->slug != 'blog' && $page->slug != 'contact')
                        <a class="{{ request()->is('pages', $page->slug) ? 'active' : '' }}"
                            href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                    @endif
                </li>
            @endforeach
            <li>
                <button class="cart-btn">@lang('Cart Item')</button>
            </li>
            @foreach ($pages as $page)
                <li>
                    @if ($page->slug != '/' && $page->slug != 'about' && $page->slug != 'blog')
                        <a class="{{ request()->is('pages', $page->slug) ? 'active' : '' }}"
                            href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                    @endif
                </li>
            @endforeach
            <li>
                @guest
                    <a class="{{ Route::is('contact') ? 'active' : '' }}" href="{{ route('user.login') }}">
                        @lang('Login')</a>
                @else
                    <a class="{{ Route::is('contact') ? 'active' : '' }}" href="{{ route('user.logout') }}">
                        @lang('Logout')</a>
                @endguest
            </li>
        </ul>
    </div>
</div>
<!--========================== Sidebar mobile menu wrap End ==========================-->

@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
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
                url: '{{ route('remove.cart') }}',
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
                        updateCartItemCount(response.cartItemCount);
                        getCart();
                    }

                }
            })
        }

        function getCart() {
            $.ajax({
                url: '{{ route('get.cart') }}',
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
            window.location.href = "{{ route('user.paynow') }}" + httpQuery
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

        function calculateTotalAmount() {
            let products = $("input[name='products[]']")
            var total = 0
            products.each(function(index, product) {
                if ($(product).is(":checked")) {
                    let price = $(product).data('price')
                    let quantity = $(product).parent().parent().find('#quantityInput').val();
                    total += price * quantity;
                }
            })
            $('.total_product_price').text('$' + total);

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
                $('#search_results').hide()
            }

            clearTimeout(timeout);
            timeout = setTimeout(() => {
                // do something: send an ajax or call a function here
                $.ajax({
                    url: "{{ route('product.live.search') }}",
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
                            html += `<li>No Product Found</li>`

                        }

                        $('#search_results').html('')
                        $('#search_results').show()
                        $('#search_results').html(html)
                        if (hasProducts == false || value.length == 0) {

                            setTimeout(function() {
                                $('#search_results').hide()
                            }, value.length == 0 ? 0 : 2000)
                        }

                    }
                })
            }, 1000);

        }

        function updateCartItemCount(count) {
            $('#cartItem').text(count);
        }
    </script>
@endpush
