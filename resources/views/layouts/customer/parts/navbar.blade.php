        <!--====== Main Header ======-->
        <header class="header--style-1 header--box-shadow">
            <nav class="primary-nav primary-nav-wrapper--border">
                <div class="container">

                    <!--====== Primary Nav ======-->
                    <div class="primary-nav">

                        <!--====== Main Logo ======-->

                        <a class="main-logo" href="/">
                            THIS IS LOGO
                        </a>
                        <!--====== End - Main Logo ======-->


                        <!--====== Search Form ======-->
                        <form class="main-form" style="min-width: 120px" method="get" action="/catalogsearch/result">

                            <label for="main-search"></label>

                            <input class="input-text input-text--border-radius input-text--style-1" type="text"
                                id="main-search" placeholder="Search" name="keyword"
                                value="{{ request()->keyword ?? '' }}">

                            <button class="btn btn--icon fas fa-search main-search-button" type="submit"></button>
                        </form>
                        <!--====== End - Search Form ======-->


                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation">

                            <button class="btn btn--icon toggle-button fas fa-cogs" type="button"></button>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                                    <li class="has-dropdown" data-tooltip="tooltip" data-placement="left" title=""
                                        data-original-title="{{ Auth::user() ? Auth::user()->name : 'Account' }}">

                                        <a><i class="far fa-user-circle"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:120px">
                                            @if (Auth::user())
                                                <li>
                                                    <a href="/member"><i class="fas fa-user-circle u-s-m-r-6"></i>

                                                        <span>Member</span></a>
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
                                    <li data-tooltip="tooltip" data-placement="left" title=""
                                        data-original-title="Contact">

                                        <a href="tel:+0383460015"><i class="fas fa-phone-volume"></i></a>
                                    </li>
                                    <li data-tooltip="tooltip" data-placement="left" title=""
                                        data-original-title="Mail">

                                        <a href="mailto:hiusnguyen201@gmail.com"><i class="far fa-envelope"></i></a>
                                    </li>
                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->
                    </div>
                    <!--====== End - Primary Nav ======-->
                </div>
            </nav>
            <nav class="secondary-nav-wrapper">
                <div class="container">

                    <!--====== Secondary Nav ======-->
                    <div class="secondary-nav">

                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation1">

                            <button class="btn btn--icon toggle-mega-text toggle-button" type="button">M</button>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list">
                                    <li class="has-dropdown">

                                        <span class="mega-text">M</span>

                                        <!--====== Mega Menu ======-->

                                        <span class="js-menu-toggle"></span>
                                        <div class="mega-menu">
                                            <div class="mega-menu-wrap">
                                                <div class="mega-menu-list">
                                                    <ul>
                                                        @if ($categories && count($categories))
                                                            @foreach ($categories as $index => $category)
                                                                <li class="{{ $index == 0 ? 'js-active' : '' }}">
                                                                    <a
                                                                        href="/catalogsearch/result?category_id={{ $category->id }}">
                                                                        <span>{{ $category->name }}</span></a>

                                                                    <span class="js-menu-toggle js-toggle-mark"></span>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>

                                                @if ($categories && count($categories))
                                                    @foreach ($categories as $index => $category)
                                                        <div
                                                            class="mega-menu-content {{ $index == 0 ? 'js-active' : '' }}">

                                                            <div class="row" style="height: 100%">
                                                                <div class="col-lg-4">
                                                                    <ul>
                                                                        <li class="mega-list-title">
                                                                            <span>BRANDS</span>
                                                                        </li>
                                                                        @if (count($category->brands))
                                                                            @foreach ($category->brands as $brand)
                                                                                <li>
                                                                                    <a
                                                                                        href="/catalogsearch/result?brand_id={{ $category->id }}">{{ $brand->name }}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <ul>
                                                                        <li class="mega-list-title">
                                                                            <span>PRICES</span>
                                                                        </li>
                                                                        <li>

                                                                            <a href="shop-side-version-2.html">TV
                                                                                Boxes</a>
                                                                        </li>
                                                                        <li>

                                                                            <a href="shop-side-version-2.html">TC
                                                                                Receiver
                                                                                &amp; Accessories</a>
                                                                        </li>
                                                                        <li>

                                                                            <a href="shop-side-version-2.html">Display
                                                                                Dongle</a>
                                                                        </li>
                                                                        <li>

                                                                            <a href="shop-side-version-2.html">Home
                                                                                Theater
                                                                                System</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <ul>
                                                                        <li class="mega-list-title">
                                                                            <span>HOT</span>
                                                                        </li>
                                                                        <li>

                                                                            <a
                                                                                href="shop-side-version-2.html">Earphones</a>
                                                                        </li>
                                                                        <li>

                                                                            <a href="shop-side-version-2.html">Mp3
                                                                                Players</a>
                                                                        </li>
                                                                        <li>

                                                                            <a href="shop-side-version-2.html">Speakers
                                                                                &amp;
                                                                                Radios</a>
                                                                        </li>
                                                                        <li>

                                                                            <a
                                                                                href="shop-side-version-2.html">Microphones</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <!--====== End - Mega Menu ======-->
                                    </li>
                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->


                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation2">

                            <button class="btn btn--icon toggle-button fas fa-cog" type="button"></button>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design2 ah-list--link-color-secondary">
                                    <li>
                                        <a href="/catalogsearch/result">NEW ARRIVALS</a>
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
                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->


                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation3">

                            <button class="btn btn--icon toggle-button fas fa-shopping-bag toggle-button-shop"
                                type="button"></button>

                            <span class="total-item-round">{{ $countProductsInCart ?? 0 }}</span>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                                    <li>

                                        <a href="/"><i class="fas fa-home"></i></a>
                                    </li>
                                    <li>

                                        <a href="/wishlist"><i class="far fa-heart"></i></a>
                                    </li>
                                    <li class="has-dropdown">

                                        <a class="mini-cart-shop-link" href="{{ route('cart.index') }}"><i
                                                class="fas fa-shopping-bag"></i>

                                            <span class="total-item-round">{{ $countProductsInCart ?? 0 }}</span></a>
                                        <span class="js-menu-toggle"></span>
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
        </header>
        <!--====== End - Main Header ======-->
