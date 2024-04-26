        <!--====== Main Header ======-->
        <header class="header--style-1 header--box-shadow">
            <nav class="primary-nav primary-nav-wrapper--border">
                <div class="container">
                    @if (Auth::user() && Auth::user()->status == config('constants.user_status.inactive.value'))
                        <div class="primary-nav" style="justify-content: space-between !important">
                            <div class="row" style="align-items:center;color: #ff4500">
                                <img width="25px" src="{{ asset('images/Logo Icon.png') }}" alt="CpsMarket">
                                <span class="u-s-m-l-6" style="font-weight: 600">CpsMarket</span>
                            </div>
                            <a href="/auth/logout" style="color: #FF4500"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    @else
                        <div class="primary-nav">
                            <div style="display: flex; align-items:center; gap:30px ">
                                <a class="main-logo" href="/">
                                    <div class="row" style="align-items:center;color: #ff4500">
                                        <img width="25px" src="{{ asset('images/Logo Icon.png') }}" alt="CpsMarket">
                                        <span class="u-s-m-l-6" style="font-weight: 600">CpsMarket</span>
                                    </div>
                                </a>
                                <div class="menu-init" id="navigation1">
                                    <button class="btn btn--icon toggle-mega-text toggle-button" type="button"><i
                                            class="fas fa-bars"></i></button>
                                    <div class="ah-lg-mode">
                                        <span class="ah-close" style="text-align: end">✕ Close</span>
                                        <ul class="ah-list">
                                            <li class="has-dropdown">
                                                <span id="homeBtnMobile" class="mega-text">
                                                    <a style="color: #ffffff" href="/"><i
                                                            class="fas fa-home"></i></a>
                                                </span>
                                                <span class="mega-block mega-text"><i class="fas fa-bars"></i></span>
                                                <span class="mega-block js-menu-toggle js-toggle-mark"></span>
                                                <div class="mega-menu" style="display: block">
                                                    <div class="mega-menu-wrap">
                                                        <div class="mega-menu-list">
                                                            <ul>
                                                                @if ($categories && count($categories))
                                                                    @foreach ($categories as $index => $category)
                                                                        <li
                                                                            class="{{ $index == 0 ? 'js-active' : '' }}">
                                                                            <a
                                                                                href="/catalogsearch/result?category_id={{ $category->id }}">
                                                                                <span>{{ $category->name }}</span></a>

                                                                            <span
                                                                                class="js-menu-toggle {{ $index == 0 ? 'js-toggle-mark' : '' }}"></span>
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
                                                                        <div class="col-lg-6">
                                                                            <ul>
                                                                                <li class="mega-list-title">
                                                                                    <span>BRANDS</span>
                                                                                </li>
                                                                                @if (count($category->brands))
                                                                                    @foreach ($category->brands as $brand)
                                                                                        <li>
                                                                                            <a
                                                                                                href="/catalogsearch/result?brand_id={{ $brand->id }}">{{ $brand->name }}</a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <ul>
                                                                                <li class="mega-list-title">
                                                                                    <span>PRICES</span>
                                                                                </li>
                                                                                <li>
                                                                                    <a
                                                                                        href="/catalogsearch/result?category_id={{ $category->id }}&price_min=0&price_max=100000">@convertCurrency(0)
                                                                                        -
                                                                                        @convertCurrency(100000)</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a
                                                                                        href="/catalogsearch/result?category_id={{ $category->id }}&price_min=100000&price_max=200000">@convertCurrency(100000)
                                                                                        -
                                                                                        @convertCurrency(200000)</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a
                                                                                        href="/catalogsearch/result?category_id={{ $category->id }}&price_min=200000&price_max=300000">@convertCurrency(200000)
                                                                                        -
                                                                                        @convertCurrency(300000)</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a
                                                                                        href="/catalogsearch/result?category_id={{ $category->id }}&price_min=300000&price_max=400000">@convertCurrency(300000)
                                                                                        -
                                                                                        @convertCurrency(400000)</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a
                                                                                        href="/catalogsearch/result?category_id={{ $category->id }}&price_min=400000&price_max=500000">@convertCurrency(400000)
                                                                                        -
                                                                                        @convertCurrency(500000)</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <form class="main-form" style="min-width: 200px" method="get"
                                action="/catalogsearch/result">

                                <label for="main-search"></label>

                                <input class="input-text input-text--border-radius input-text--style-1" type="text"
                                    id="main-search" placeholder="Search" name="keyword"
                                    value="{{ request()->keyword ?? '' }}">

                                <button class="btn btn--icon fas fa-search main-search-button" type="submit"></button>
                            </form>

                            <div class="menu-init" id="navigation">
                                <button class="btn btn--icon toggle-button fas fa-cogs" type="button"></button>
                                <div class="ah-lg-mode">
                                    <span class="ah-close" style="text-align: end">✕ Close</span>
                                    <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                                        <li class="has-dropdown" data-tooltip="tooltip" data-placement="left"
                                            title=""
                                            data-original-title="{{ Auth::user() ? Auth::user()->name : 'Account' }}">
                                            <a><i class="far fa-user-circle"></i></a>
                                            <span class="js-menu-toggle js-toggle-mark"></span>
                                            <ul style="width:120px; display:block">
                                                @if (Auth::user())
                                                    <li>
                                                        <a id="auth" href="/member"><i
                                                                class="fas fa-user-circle u-s-m-r-6"></i>
                                                            <span>Member</span></a>
                                                    </li>
                                                    <li>
                                                        <a href="/auth/logout"><i
                                                                class="fas fa-lock-open u-s-m-r-6"></i>
                                                            <span>Signout</span></a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="/auth/register"><i
                                                                class="fas fa-user-plus u-s-m-r-6"></i>
                                                            <span>Signup</span></a>
                                                    </li>
                                                    <li>

                                                        <a href="/auth/login"><i class="fas fa-lock u-s-m-r-6"></i>
                                                            <span>Signin</span></a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                        <li data-tooltip="tooltip" data-placement="left" title="Contact"
                                            data-original-title="Contact">
                                            <a href="tel:+0383460015"><i class="fas fa-phone-volume"></i></a>
                                        </li>
                                        <li data-tooltip="tooltip" data-placement="left" title="Mail"
                                            data-original-title="Mail">
                                            <a href="mailto:hiusnguyen201@gmail.com"><i
                                                    class="far fa-envelope"></i></a>
                                        </li>
                                        <li data-tooltip="tooltip" data-placement="left">
                                            <a class="mini-cart-shop-link" href="{{ route('cart.index') }}"><i
                                                    class="fas fa-shopping-bag"></i>
                                                <span
                                                    class="total-item-round">{{ $countProductsInCart ?? 0 }}</span></a>
                                        </li>
                                        <li class="gtranslate_wrapper">
                                        </li>
                                        <script>
                                            window.gtranslateSettings = {
                                                "default_language": "en",
                                                "languages": ["en", "vi"],
                                                "wrapper_selector": ".gtranslate_wrapper",
                                                "flag_size": 24
                                            }
                                        </script>
                                        <script src="https://cdn.gtranslate.net/widgets/latest/popup.js" defer></script>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </nav>
        </header>
