        <!--====== Main Header ======-->
        <header class="header--style-1">
            <!--====== Nav  ======-->
            <nav class="secondary-nav-wrapper">
                <div class="container">
                    <!--====== Secondary Nav ======-->
                    <div class="secondary-nav">
                        <div class="menu-init" id="navigation2">
                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">
                                <span class="ah-close">✕ Close</span>
                                <ul class="ah-list ah-list--design2 ah-list--link-color-secondary">
                                    <li>
                                        <a href="/">
                                            <img src="" alt="">
                                            <span>LOGO</span>
                                        </a>
                                    </li>
                                    <li>
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
                                                                        <a href="/{{ $category->slug }}.html">
                                                                            <span>{{ $category->name }}</span>
                                                                        </a>
                                                                        <span
                                                                            class="js-menu-toggle js-toggle-mark"></span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

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
                                                                                        href="/{{ $category->name }}/{{ $brand->slug }}.html">{{ $brand->name }}</a>
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

                                                    </div>
                                                </div>
                                                <!--====== End - Mega Menu ======-->
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <!--====== End - Menu ======-->
                        </div>

                        <form class="main-form" style="width: 350px">
                            <label for="main-search"></label>
                            <input class="input-text input-text--border-radius input-text--style-1" type="text"
                                id="main-search" placeholder="Search" fdprocessedid="7dpa">

                            <button class="btn btn--icon fas fa-search main-search-button" type="submit"
                                fdprocessedid="ruj13s"></button>
                        </form>

                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation3">

                            <button
                                class="btn btn--icon toggle-button toggle-button--secondary fas fa-shopping-bag toggle-button-shop"
                                type="button"></button>


                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                                    <li class="has-dropdown" data-tooltip="tooltip" data-placement="left"
                                        title="{{ Auth::user() ? Auth::user()->name : 'Account' }}">

                                        <a><i class="far fa-user-circle"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:120px">
                                            @if (Auth::user())
                                                <li>

                                                    <a href="/member"><i class="fas fa-user-circle u-s-m-r-6"></i>

                                                        <span>Account</span></a>
                                                </li>
                                                <li>

                                                    <a href="/auth/logout"><i class="fas fa-lock-open u-s-m-r-6"></i>

                                                        <span>Signout</span></a>
                                                </li>
                                            @else
                                                <li>

                                                    <a href="/auth/register"><i class="fas fa-user-plus u-s-m-r-6"></i>

                                                        <span>Signup</span></a>
                                                </li>
                                                <li>

                                                    <a href="/auth/login"><i class="fas fa-lock u-s-m-r-6"></i>

                                                        <span>Signin</span></a>
                                                </li>
                                            @endif

                                        </ul>
                                        <!--====== End - Dropdown ======-->
                                    </li>


                                    <li class="has-dropdown">

                                        <a href="/cart" class="mini-cart-shop-link"><i
                                                class="fas fa-shopping-bag"></i>
                                            <span class="total-item-round">
                                                {{ Cart::count() }}
                                            </span></a>
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
