@php
    $user = auth()->user();
    $pages = App\Models\Page::all();
    $languages = App\Models\Language::all();
    $categories = App\Models\Category::whereIsMenuItem(1)->get();
    $wishlistCount = App\Models\Wishlist::where('user_id', @auth()->user()->id)->count();
    $devices = App\Models\Device::where('is_menu_item', 1)->latest()->take(3)->get();

@endphp
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
                        <ul class="textcolor search_results"></ul>
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
                            @auth
                                @if (Request::routeIs('user.*'))
                                    <li>
                                        <a class="{{ Route::is('user.home') ? 'active' : '' }}"
                                            href="{{ route('user.home') }}">
                                            @lang('Dashboard')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                            @lang('Home')
                                        </a>
                                    </li>
                                    <li class="profile-option">

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

                                    </li>

                                    <li>
                                        <a href="{{ route('user.transactions') }}"
                                            class="{{ Request::routeIs('user.transactions') ? 'active' : '' }}">
                                            @lang('Transaction')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('ticket') }}"
                                            class="{{ Request::routeIs('ticket') ? 'active' : '' }}">
                                            @lang('My Tickets')
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="{{ Route::is('user.home') ? 'active' : '' }}"
                                            href="{{ route('user.home') }}">
                                            @lang('Dashboard')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                            @lang('Home')
                                        </a>
                                    </li>
                                    @foreach ($pages as $page)
                                        @if ($page->slug != 'blog' && $page->slug != 'contact' && $page->slug != '/')
                                            <li>
                                                <a class="{{ request()->is('pages', $page->slug) ? 'active' : '' }}"
                                                    href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                    <li>
                                        <a class="{{ Route::is('products', 'shop') ? 'active' : '' }}"
                                            href="{{ route('products', 'shop') }}">
                                            @lang('Shop')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ Route::is('topups', 'topups') ? 'active' : '' }}"
                                            href="{{ route('topups', 'topups') }}">
                                            @lang('Top Up')
                                        </a>
                                    </li>
                                    @foreach ($pages as $page)
                                        @if ($page->slug == 'contact')
                                            <li>
                                                <a class="{{ request()->is('pages', $page->slug) ? 'active' : '' }}"
                                                    href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                <li>
                                    <a class="{{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                        @lang('Home')
                                    </a>
                                </li>
                                @foreach ($pages as $page)
                                    @if ($page->slug == 'about')
                                        <li>
                                            <a class="{{ request()->is('pages', $page->slug) ? 'active' : '' }}"
                                                href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                                        </li>
                                    @endif
                                @endforeach
                                <li>
                                    <a class="{{ Route::is('products', 'shop') ? 'active' : '' }}"
                                        href="{{ route('products', 'shop') }}">
                                        @lang('Shop')
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ Route::is('topups', 'topups') ? 'active' : '' }}"
                                        href="{{ route('topups', 'topups') }}">
                                        @lang('Top Up')
                                    </a>
                                </li>
                                @foreach ($pages as $page)
                                    @if ($page->slug == 'contact')
                                        <li>
                                            <a class="{{ request()->is('pages', $page->slug) ? 'active' : '' }}"
                                                href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endauth
                        </ul>
                    </div>

                    <div class="menu-right-wrapper">
                        <ul>
                            @foreach ($devices as $item)
                             <li>
                                <a href="{{ route('devices', [$item->id,slug($item->name)]) }}">
                                    @php echo $item->icon @endphp
                                    {{__($item->name)}}
                                </a>
                            </li>
                            @endforeach
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
                    @if (auth()->user()->image)
                        <a href="{{ route('user.home') }}">
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()->image) }}"
                                alt="user-thumb">
                        </a>
                    @else
                        <a href="{{ route('user.home') }}">
                            <img src="{{ getImage('assets/presets/default/images/avater/profile.jpg') }}"
                                alt="user-thumb">
                        </a>
                    @endif
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
                <a class="{{ Route::is('products', 'shop') ? 'active' : '' }}"
                    href="{{ route('products', 'shop') }}">
                    @lang('Shop')
                </a>
            </li>
            <li>
                <a class="{{ Route::is('topups', 'topups') ? 'active' : '' }}"
                    href="{{ route('topups', 'topups') }}">
                    @lang('Top Up')
                </a>
            </li>
            <li>
                <button class="cart-btn">@lang('Cart Item')</button>
            </li>
            @auth
                <li class="profile-option">

                    <a href="javascript:void(0)" class="{{ Request::routeIs('user.deposit') ? 'active' : '' }} ">
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

                </li>

                <li>
                    <a href="{{ route('user.transactions') }}"
                        class="{{ Request::routeIs('user.transactions') ? 'active' : '' }}">
                        @lang('Transaction')
                    </a>
                </li>
                <li>
                    <a href="{{ route('ticket') }}"
                        class="{{ Request::routeIs('ticket') ? 'active' : '' }}">
                        @lang('My Tickets')
                    </a>
                </li>
            @endauth
            @foreach ($pages as $page)
                <li>
                    @if ($page->slug == 'contact')
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

            <li class="language">
                <div class="language-box">
                    <select class="langSel select">
                        @foreach ($languages as $lang)
                            <option value="{{ $lang->code }}" @if (Session::get('lang') === $lang->code) selected @endif>
                                {{ __($lang->name) }}</option>
                        @endforeach
                    </select>
                </div>
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
            $('.total_product_price').text('{{ $general->cur_sym }}' + total.toFixed(2));

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
@endpush
