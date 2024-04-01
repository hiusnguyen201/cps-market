        <!--====== Main Header ======-->
        <header class="header--style-1">
            <!--====== Nav  ======-->
            <nav class="secondary-nav-wrapper">
                <div class="container">

                    <!--====== Secondary Nav ======-->
                    <div class="secondary-nav">

                        <!--====== Main Logo ======-->

                        <a href="/">
                            <img src="images/logo/logo-1.png" alt="">
                            <span>THIS IS LOGO</span>
                        </a>
                        <!--====== End - Main Logo ======-->

                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation2">

                            <button class="btn btn--icon toggle-button toggle-button--secondary fas fa-cog"
                                type="button"></button>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design2 ah-list--link-color-secondary">
                                    <li>
                                        <a href="/">HOME</a>
                                    </li>
                                    <li>
                                        <!--====== List ======-->
                                        <ul class="ah-list">
                                            <li class="has-dropdown">
                                                <!--====== Mega Menu ======-->
                                                <span class="js-menu-toggle catalog-btn-dropdown">
                                                    <a>CATALOG<i class="fas fa-angle-down u-s-m-l-6"></i></a>
                                                </span>
                                                <div class="mega-menu">
                                                    <div class="mega-menu-wrap">
                                                        <div class="mega-menu-list">
                                                            <ul>
                                                                @foreach ($categories as $index => $category)
                                                                    <li
                                                                        class="js {{ $index == 0 ? 'js-active' : '' }} ">
                                                                        <a href="/category/{{ $category->slug }}.html">
                                                                            <span>{{ $category->name }}</span>
                                                                        </a>
                                                                        <span
                                                                            class="js-menu-toggle js-toggle-mark"></span>
                                                                    </li>
                                                                @endforeach



                                                            </ul>
                                                        </div>

                                                        <!--====== Phone ======-->
                                                        @foreach ($categories as $index => $category)
                                                            <div
                                                                class="mega-menu-content {{ $index == 0 ? 'js-active' : '' }} ">
                                                                <!--====== Mega Menu Row ======-->
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <ul>

                                                                            <li class="mega-list-title">

                                                                                <a
                                                                                    href="shop-side-version-2.html">BRANDS</a>
                                                                            </li>
                                                                            @foreach ($category->brands as $brand)
                                                                                <li>
                                                                                    <a
                                                                                        href="/brand/{{ $brand->slug }}.html">{{ $brand->name }}</a>
                                                                                </li>
                                                                            @endforeach



                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <ul>
                                                                            <li class="mega-list-title">

                                                                                <a href="shop-side-version-2.html">
                                                                                    PRICE</a>
                                                                            </li>
                                                                            <li>

                                                                                <a
                                                                                    href="shop-side-version-2.html">Iphone</a>
                                                                            </li>
                                                                            <li>

                                                                                <a
                                                                                    href="shop-side-version-2.html">Samsung</a>
                                                                            </li>
                                                                            <li>

                                                                                <a
                                                                                    href="shop-side-version-2.html">Xiaomi</a>
                                                                            </li>
                                                                            <li>

                                                                                <a href="shop-side-version-2.html">Compact
                                                                                    Discs</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <ul>
                                                                            <li class="mega-list-title">

                                                                                <a
                                                                                    href="shop-side-version-2.html">HOT</a>
                                                                            </li>
                                                                            <li>

                                                                                <a
                                                                                    href="shop-side-version-2.html">Iphone</a>
                                                                            </li>
                                                                            <li>

                                                                                <a
                                                                                    href="shop-side-version-2.html">Samsung</a>
                                                                            </li>
                                                                            <li>

                                                                                <a
                                                                                    href="shop-side-version-2.html">Xiaomi</a>
                                                                            </li>
                                                                            <li>

                                                                                <a href="shop-side-version-2.html">Compact
                                                                                    Discs</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <!--====== End - Mega Menu Row ======-->
                                                            </div>
                                                        @endforeach
                                                        <!--====== End - Phone ======-->

                                                    </div>
                                                </div>
                                                <!--====== End - Mega Menu ======-->
                                            </li>
                                        </ul>
                                        <!--====== End - List ======-->
                                    </li>
                                    <li class="has-dropdown">

                                        <a>PAGES<i class="fas fa-angle-down u-s-m-l-6"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:170px">
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Home<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:118px">
                                                    <li>

                                                        <a href="index.html">Home 1</a>
                                                    </li>
                                                    <li>

                                                        <a href="index-2.html">Home 2</a>
                                                    </li>
                                                    <li>

                                                        <a href="index-3.html">Home 3</a>
                                                    </li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Account<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="signin.html">Signin / Already Registered</a>
                                                    </li>
                                                    <li>

                                                        <a href="signup.html">Signup / Register</a>
                                                    </li>
                                                    <li>

                                                        <a href="lost-password.html">Lost Password</a>
                                                    </li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a href="dashboard.html">Dashboard<i
                                                        class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li class="has-dropdown has-dropdown--ul-left-100">

                                                        <a href="dashboard.html">Manage My Account<i
                                                                class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                        <!--====== Dropdown ======-->

                                                        <span class="js-menu-toggle"></span>
                                                        <ul style="width:180px">
                                                            <li>

                                                                <a href="dash-edit-profile.html">Edit Profile</a>
                                                            </li>
                                                            <li>

                                                                <a href="dash-address-book.html">Edit Address Book</a>
                                                            </li>
                                                            <li>

                                                                <a href="dash-manage-order.html">Manage Order</a>
                                                            </li>
                                                        </ul>
                                                        <!--====== End - Dropdown ======-->
                                                    </li>
                                                    <li>

                                                        <a href="dash-my-profile.html">My Profile</a>
                                                    </li>
                                                    <li class="has-dropdown has-dropdown--ul-left-100">

                                                        <a href="dash-address-book.html">Address Book<i
                                                                class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                        <!--====== Dropdown ======-->

                                                        <span class="js-menu-toggle"></span>
                                                        <ul style="width:180px">
                                                            <li>

                                                                <a href="dash-address-make-default.html">Address Make
                                                                    Default</a>
                                                            </li>
                                                            <li>

                                                                <a href="dash-address-add.html">Add New Address</a>
                                                            </li>
                                                            <li>

                                                                <a href="dash-address-edit.html">Edit Address Book</a>
                                                            </li>
                                                        </ul>
                                                        <!--====== End - Dropdown ======-->
                                                    </li>
                                                    <li>

                                                        <a href="dash-track-order.html">Track Order</a>
                                                    </li>
                                                    <li>

                                                        <a href="dash-my-order.html">My Orders</a>
                                                    </li>
                                                    <li>

                                                        <a href="dash-payment-option.html">My Payment Options</a>
                                                    </li>
                                                    <li>

                                                        <a href="dash-cancellation.html">My Returns & Cancellations</a>
                                                    </li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Empty<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="empty-search.html">Empty Search</a>
                                                    </li>
                                                    <li>

                                                        <a href="empty-cart.html">Empty Cart</a>
                                                    </li>
                                                    <li>

                                                        <a href="empty-wishlist.html">Empty Wishlist</a>
                                                    </li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Product Details<i
                                                        class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="product-detail.html">Product Details</a>
                                                    </li>
                                                    <li>

                                                        <a href="product-detail-variable.html">Product Details
                                                            Variable</a>
                                                    </li>
                                                    <li>

                                                        <a href="product-detail-affiliate.html">Product Details
                                                            Affiliate</a>
                                                    </li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Shop Grid Layout<i
                                                        class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="shop-grid-left.html">Shop Grid Left Sidebar</a>
                                                    </li>
                                                    <li>

                                                        <a href="shop-grid-right.html">Shop Grid Right Sidebar</a>
                                                    </li>
                                                    <li>

                                                        <a href="shop-grid-full.html">Shop Grid Full Width</a>
                                                    </li>
                                                    <li>

                                                        <a href="shop-side-version-2.html">Shop Side Version 2</a>
                                                    </li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Shop List Layout<i
                                                        class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="shop-list-left.html">Shop List Left Sidebar</a>
                                                    </li>
                                                    <li>

                                                        <a href="shop-list-right.html">Shop List Right Sidebar</a>
                                                    </li>
                                                    <li>

                                                        <a href="shop-list-full.html">Shop List Full Width</a>
                                                    </li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li>

                                                <a href="cart.html">Cart</a>
                                            </li>
                                            <li>

                                                <a href="wishlist.html">Wishlist</a>
                                            </li>
                                            <li>

                                                <a href="checkout.html">Checkout</a>
                                            </li>
                                            <li>

                                                <a href="faq.html">FAQ</a>
                                            </li>
                                            <li>

                                                <a href="about.html">About us</a>
                                            </li>
                                            <li>

                                                <a href="contact.html">Contact</a>
                                            </li>
                                            <li>

                                                <a href="404.html">404</a>
                                            </li>
                                        </ul>
                                        <!--====== End - Dropdown ======-->
                                    </li>
                                    <li class="has-dropdown">

                                        <a>BLOG<i class="fas fa-angle-down u-s-m-l-6"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:200px">
                                            <li>

                                                <a href="blog-left-sidebar.html">Blog Left Sidebar</a>
                                            </li>
                                            <li>

                                                <a href="blog-right-sidebar.html">Blog Right Sidebar</a>
                                            </li>
                                            <li>

                                                <a href="blog-sidebar-none.html">Blog Sidebar None</a>
                                            </li>
                                            <li>

                                                <a href="blog-masonry.html">Blog Masonry</a>
                                            </li>
                                            <li>

                                                <a href="blog-detail.html">Blog Details</a>
                                            </li>
                                        </ul>
                                        <!--====== End - Dropdown ======-->
                                    </li>
                                    <li>

                                        <a href="shop-side-version-2.html">VALUE OF THE DAY</a>
                                    </li>
                                    <li>

                                        <a href="shop-side-version-2.html">GIFT CARDS</a>
                                    </li>
                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->


                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation3">

                            <button
                                class="btn btn--icon toggle-button toggle-button--secondary fas fa-shopping-bag toggle-button-shop"
                                type="button"></button>

                            <span class="total-item-round">{{ $cartCount }}</span>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                                    <li class="has-dropdown" data-tooltip="tooltip" data-placement="left"
                                        title="Account">

                                        <a><i class="far fa-user-circle"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:120px">
                                            <li>

                                                <a href="/member"><i class="fas fa-user-circle u-s-m-r-6"></i>

                                                    <span>Account</span></a>
                                            </li>
                                            <li>

                                                <a href="/auth/register"><i class="fas fa-user-plus u-s-m-r-6"></i>

                                                    <span>Signup</span></a>
                                            </li>
                                            <li>

                                                <a href="/auth/login"><i class="fas fa-lock u-s-m-r-6"></i>

                                                    <span>Signin</span></a>
                                            </li>
                                            <li>

                                                <a href="/auth/logout"><i class="fas fa-lock-open u-s-m-r-6"></i>

                                                    <span>Signout</span></a>
                                            </li>
                                        </ul>
                                        <!--====== End - Dropdown ======-->
                                    </li>


                                    <li class="has-dropdown">

                                        <a href="/cart" class="mini-cart-shop-link"><i
                                                class="fas fa-shopping-bag"></i>
                                            <span class="total-item-round">{{ $cartCount }}</span></a>
                                    </li>

                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->
                    </div>
                    <!--====== End - Secondary Nav ======-->
                </div>
            </nav>
            <!--====== End - Nav 2 ======-->
        </header>
        <!--====== End - Main Header ======-->
