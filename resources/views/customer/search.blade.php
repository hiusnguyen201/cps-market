@extends('layouts.customer.index')

@section('content')
@if (session('success'))
<input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
<input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

<style>
    .btn--e-brand {
        padding: 14px;
        padding-left: 13px;
        border-radius: 0.125rem;
        font-size: 13px;
        width: 100%;
        text-align: center;
        display: block;
        cursor: pointer;
    }

    #addToWishlist {
        border: 0;
        padding: 0;
        background: none;
        cursor: pointer;
        color: #a0a0a0;
        transition: color 110ms ease-in-out;
    }

    #addToWishlist:hover {
        color: #ff4500;
    }
</style>

@if (count($products))
<div class="u-s-p-y-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="shop-w-master">
                    <h1 class="shop-w-master__heading u-s-m-b-30"><i class="fas fa-filter u-s-m-r-8"></i>

                        <span>FILTERS</span>
                    </h1>
                    <div class="shop-w-master__sidebar">
                        <div class="u-s-m-b-30">
                            <div class="shop-w shop-w--style">
                                <div class="shop-w__intro-wrap">
                                    <h1 class="shop-w__h">CATEGORY</h1>

                                    <span class="fas fa-minus shop-w__toggle" data-target="#s-category" data-toggle="collapse"></span>
                                </div>
                                <div class="shop-w__wrap collapse show" id="s-category">
                                    <ul class="shop-w__category-list gl-scroll">
                                        <li class="has-list">

                                            <a href="#">Electronics</a>

                                            <span class="category-list__text u-s-m-l-6">(23)</span>

                                            <span class="js-shop-category-span is-expanded fas fa-plus u-s-m-l-6"></span>
                                            <ul style="display:block">
                                                <li class="has-list">

                                                    <a href="#">3D Printer & Supplies</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">3d Printer</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">3d Printing Pen</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">3d Printing Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">3d Printer Module Board</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Home Audio & Video</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">TV Boxes</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">TV Receiver & Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">3d Printing Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">3d Printer Module Board</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Media Players</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Earphones</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Mp3 Players</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Speakers & Radios</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Microphones</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Video Game Accessories</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Nintendo Video Games Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Sony Video Games Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Xbox Video Games Accessories</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Security & Protection</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Security Cameras</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Alarm System</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Security Gadgets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">CCTV Security Accessories</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Home Audio & Video</a>

                                                    <span class="js-shop-category-span is-expanded fas fa-plus u-s-m-l-6"></span>
                                                    <ul style="display:block">
                                                        <li>

                                                            <a href="#">TV Boxes</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">TV Receiver & Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">3d Printing Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">3d Printer Module Board</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Photography & Camera</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Digital Cameras</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Sport Camera & Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Camera Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Lenses & Accessories</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Arduino Compatible</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Raspberry Pi & Orange Pi</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Module Board</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Smart Robot</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Board Kits</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">DSLR Camera</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Nikon Camera</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Canon Camera</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Sony Camera</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">DSLR Lenses</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Necessary Accessories</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Flash Cards</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Memory Cards</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Flash Pins</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Compact Discs</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-list">

                                            <a href="#">Women's Clothing</a>

                                            <span class="category-list__text u-s-m-l-6">(5)</span>

                                            <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                            <ul>
                                                <li class="has-list">

                                                    <a href="#">Hot Categories</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Dresses</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Blouses & Shirts</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">T-shirts</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Rompers</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Intimates</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Bras</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Brief Sets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Bustiers & Corsets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Panties</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Wedding & Events</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Wedding Dresses</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Evening Dresses</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Prom Dresses</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Flower Dresses</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Bottoms</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Skirts</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Shorts</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Leggings</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Jeans</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Outwear</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Blazers</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Basic Jackets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Trench</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Leather & Suede</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Jackets</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Denim Jackets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Trucker Jackets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Windbreaker Jackets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Leather Jackets</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Accessories</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Tech Accessories</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Headwear</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Baseball Caps</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Belts</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Other Accessories</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Bags</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Wallets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Watches</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Sunglasses</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-list">

                                            <a href="#">Men's Clothing</a>

                                            <span class="category-list__text u-s-m-l-6">(5)</span>

                                            <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                            <ul>
                                                <li class="has-list">

                                                    <a href="#">Hot Sale</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">T-Shirts</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Tank Tops</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Polo</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Shirts</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Outwear</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Hoodies</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Trench</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Parkas</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Sweaters</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Bottoms</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Casual Pants</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Cargo Pants</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Jeans</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Shorts</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Underwear</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Boxers</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Briefs</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Robes</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Socks</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Jackets</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Denim Jackets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Trucker Jackets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Windbreaker Jackets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Leather Jackets</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Sunglasses</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Pilot</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Wayfarer</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Square</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Round</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Accessories</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Eyewear Frames</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Scarves</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Hats</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Belts</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="has-list">

                                                    <a href="#">Other Accessories</a>

                                                    <span class="js-shop-category-span fas fa-plus u-s-m-l-6"></span>
                                                    <ul>
                                                        <li>

                                                            <a href="#">Bags</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Wallets</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Watches</a>
                                                        </li>
                                                        <li>

                                                            <a href="#">Tech Accessories</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>

                                            <a href="#">Food & Supplies</a>

                                            <span class="category-list__text u-s-m-l-6">(0)</span>
                                        </li>
                                        <li>

                                            <a href="#">Furniture & Decor</a>

                                            <span class="category-list__text u-s-m-l-6">(0)</span>
                                        </li>
                                        <li>

                                            <a href="#">Sports & Game</a>

                                            <span class="category-list__text u-s-m-l-6">(0)</span>
                                        </li>
                                        <li>

                                            <a href="#">Beauty & Health</a>

                                            <span class="category-list__text u-s-m-l-6">(0)</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="shop-w shop-w--style">
                                <div class="shop-w__intro-wrap">
                                    <h1 class="shop-w__h">RATING</h1>

                                    <span class="fas fa-minus shop-w__toggle" data-target="#s-rating" data-toggle="collapse"></span>
                                </div>
                                <div class="shop-w__wrap collapse show" id="s-rating">
                                    <ul class="shop-w__list gl-scroll">
                                        <li>
                                            <div class="rating__check">

                                                <input type="checkbox">
                                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                            </div>

                                            <span class="shop-w__total-text">(2)</span>
                                        </li>
                                        <li>
                                            <div class="rating__check">

                                                <input type="checkbox">
                                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>

                                                    <span>& Up</span>
                                                </div>
                                            </div>

                                            <span class="shop-w__total-text">(8)</span>
                                        </li>
                                        <li>
                                            <div class="rating__check">

                                                <input type="checkbox">
                                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>

                                                    <span>& Up</span>
                                                </div>
                                            </div>

                                            <span class="shop-w__total-text">(10)</span>
                                        </li>
                                        <li>
                                            <div class="rating__check">

                                                <input type="checkbox">
                                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>

                                                    <span>& Up</span>
                                                </div>
                                            </div>

                                            <span class="shop-w__total-text">(12)</span>
                                        </li>
                                        <li>
                                            <div class="rating__check">

                                                <input type="checkbox">
                                                <div class="rating__check-star-wrap"><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>

                                                    <span>& Up</span>
                                                </div>
                                            </div>

                                            <span class="shop-w__total-text">(1)</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="shop-w shop-w--style">
                                <div class="shop-w__intro-wrap">
                                    <h1 class="shop-w__h">SHIPPING</h1>

                                    <span class="fas fa-minus shop-w__toggle" data-target="#s-shipping" data-toggle="collapse"></span>
                                </div>
                                <div class="shop-w__wrap collapse show" id="s-shipping">
                                    <ul class="shop-w__list gl-scroll">
                                        <li>

                                            <!--====== Check Box ======-->
                                            <div class="check-box">

                                                <input type="checkbox" id="free-shipping">
                                                <div class="check-box__state check-box__state--primary">

                                                    <label class="check-box__label" for="free-shipping">Free Shipping</label>
                                                </div>
                                            </div>
                                            <!--====== End - Check Box ======-->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="shop-w shop-w--style">
                                <div class="shop-w__intro-wrap">
                                    <h1 class="shop-w__h">PRICE</h1>

                                    <span class="fas fa-minus shop-w__toggle" data-target="#s-price" data-toggle="collapse"></span>
                                </div>
                                <div class="shop-w__wrap collapse show" id="s-price">
                                    <form class="shop-w__form-p" id="price-filter">
                                        <div class="shop-w__form-p-wrap">
                                            <div>

                                                <label for="price-min"></label>

                                                <input class="input-text input-text--primary-style" type="text" id="price-min" name="price_min" placeholder="Min" value="{{ $price_min }}">
                                            </div>
                                            <div>

                                                <label for="price-max"></label>

                                                <input class="input-text input-text--primary-style" type="text" id="price-max" name="price_max" placeholder="Max" value="{{ $price_max }}">
                                            </div>
                                            <div>

                                                <button class="btn btn--icon fas fa-angle-right btn--e-transparent-platinum-b-2" type="submit"></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="shop-w shop-w--style">
                                <div class="shop-w__intro-wrap">
                                    <h1 class="shop-w__h">MANUFACTURER</h1>

                                    <span class="fas fa-minus shop-w__toggle" data-target="#s-manufacturer" data-toggle="collapse"></span>
                                </div>
                                <div class="shop-w__wrap collapse show" id="s-manufacturer">
                                    <ul class="shop-w__list-2">
                                        @foreach ($brands as $brand_id => $brand_name)
                                        <li>
                                            <div class="list__content">
                                                <input type="checkbox" class="brand-checkbox" name="brand" value="{{ $brand_id }}" @if(request()->has('brand_ids') && in_array($brand_id, explode(',', request()->brand_ids)))checked
                                                @endif>
                                                <span>{{ $brand_name }}</span>
                                            </div>
                                            <span class="shop-w__total-text">(23)</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <div class="shop-w shop-w--style">
                                <div class="shop-w__intro-wrap">
                                    <h1 class="shop-w__h">COLOR</h1>

                                    <span class="fas fa-minus shop-w__toggle" data-target="#s-color" data-toggle="collapse"></span>
                                </div>
                                <div class="shop-w__wrap collapse show" id="s-color">
                                    <ul class="shop-w__list gl-scroll">
                                        <li>
                                            <div class="color__check">

                                                <input type="checkbox" id="jet">

                                                <label class="color__check-label" for="jet" style="background-color: #333333"></label>
                                            </div>

                                            <span class="shop-w__total-text">(2)</span>
                                        </li>
                                        <li>
                                            <div class="color__check">

                                                <input type="checkbox" id="folly">

                                                <label class="color__check-label" for="folly" style="background-color: #FF0055"></label>
                                            </div>

                                            <span class="shop-w__total-text">(4)</span>
                                        </li>
                                        <li>
                                            <div class="color__check">

                                                <input type="checkbox" id="yellow">

                                                <label class="color__check-label" for="yellow" style="background-color: #FFFF00"></label>
                                            </div>

                                            <span class="shop-w__total-text">(6)</span>
                                        </li>
                                        <li>
                                            <div class="color__check">

                                                <input type="checkbox" id="granite-gray">

                                                <label class="color__check-label" for="granite-gray" style="background-color: #605F5E"></label>
                                            </div>

                                            <span class="shop-w__total-text">(8)</span>
                                        </li>
                                        <li>
                                            <div class="color__check">

                                                <input type="checkbox" id="space-cadet">

                                                <label class="color__check-label" for="space-cadet" style="background-color: #1D3461"></label>
                                            </div>

                                            <span class="shop-w__total-text">(10)</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="shop-p">
                    <div class="shop-p__toolbar u-s-m-b-30">

                        <div class="shop-p__tool-style">
                            <div class="tool-style__group u-s-m-b-8">

                                <span class="js-shop-grid-target is-active">Grid</span>

                                <span class="js-shop-list-target">List</span>
                            </div>

                            <form id="filterForm">
                                <div class="tool-style__form-wrap">
                                    <div class="u-s-m-b-8">
                                        <select id="perPageSelect" class="select-box select-box--transparent-b-2" name="per_page">
                                            <option value="8" {{ $per_page == 8 ? 'selected' : '' }}>Show: 8</option>
                                            <option value="12" {{ $per_page == 12 ? 'selected' : '' }}>Show: 12</option>
                                            <option value="16" {{ $per_page == 16 ? 'selected' : '' }}>Show: 16</option>
                                            <option value="28" {{ $per_page == 28 ? 'selected' : '' }}>Show: 28</option>
                                        </select>
                                    </div>

                                    <div class="u-s-m-b-8">
                                        <select id="sortBySelect" class="select-box select-box--transparent-b-2" name="sort_by">
                                            <option value="newest" {{ $sort_by == 'newest' ? 'selected' : '' }}>Sort By: Newest Items</option>
                                            <option value="latest" {{ $sort_by == 'latest' ? 'selected' : '' }}>Sort By: Latest Items</option>
                                            <option value="lowest_price" {{ $sort_by == 'lowest_price' ? 'selected' : '' }}>Sort By: Lowest Price</option>
                                            <option value="highest_price" {{ $sort_by == 'highest_price' ? 'selected' : '' }}>Sort By: Highest Price</option>
                                        </select>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                    <div class="shop-p__collection">
                        <div class="row is-grid-active">
                            @foreach ($products as $product)

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product-m">
                                    <div class="product-m__thumb">
                                        @foreach ($product->images as $image)
                                        @if ($image->pin)
                                        <a class="aspect aspect--bg-grey aspect--square u-d-block" href="/{{ $product->category->slug }}/{{ $product->brand->slug }}/{{ $product->slug }}.html">

                                            <img class="aspect__img" src="{{ asset($image->thumbnail) }}" alt="{{ $product->name }}" style="height: 100%; object-fit: contain;">
                                        </a>
                                        @endif
                                        @endforeach

                                        <div class="product-m__add-cart">

                                            <form method="POST" action="/cart">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="action" value="add">
                                                <button class="btn--e-brand" type="submit">Add to Cart</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="product-m__content">
                                        <div class="product-m__category">

                                            <a href="/{{ $product->category->slug }}/{{ $product->brand->slug }}.html">{{ $product->brand->name }}</a>
                                        </div>
                                        <div class="product-m__name">

                                            <a href="/{{ $product->category->slug }}/{{ $product->brand->slug }}/{{ $product->slug }}.html">{{ $product->name }}</a>
                                        </div>
                                        <div class="product-m__rating gl-rating-style"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>

                                            <span class="product-m__review">(23)</span>
                                        </div>
                                        <div class="product-m__price">{{ number_format($product->price, 0, ',', '.') }}&nbsp;₫</div>
                                        <div class="product-m__hover">
                                            <div class="product-m__preview-description">

                                                <span>{{ $product->description }}</span>
                                            </div>
                                            <div class="product-m__wishlist">
                                                @if (in_array($product->id, array_values($wishlists)))
                                                @php
                                                $wishlist_id = array_search($product->id, $wishlists);
                                                @endphp
                                                <form action="/wishlist" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="wishlist_id" value="{{ $wishlist_id }}">
                                                    <button id="addToWishlist" class="pd-detail__click-wrap" type="submit" data-tooltip="tooltip" data-placement="top" title="Remove Wishlist">
                                                        <i class="fas fa-heart" style="color: red;"></i>
                                                    </button>
                                                </form>
                                                @else
                                                <form action="/wishlist" method="post">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button id="addToWishlist" class="pd-detail__click-wrap" type="submit" data-tooltip="tooltip" data-placement="top" title="Add to Wishlist">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="u-s-p-y-60">

                        <!--====== Pagination ======-->
                        {{ $products->appends(Request::all())->links() }}
                        <!--====== End - Pagination ======-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="u-s-p-y-60">

    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 u-s-m-b-30">
                    <div class="empty">
                        <div class="empty__wrap">

                            <span class="empty__big-text">SORRY</span>

                            <span class="empty__text-1">Your search, did not match any products</span>

                            <form class="empty__search-form" method="get" action="/catalogsearch">

                                <label for="search-label"></label>

                                <input class="input-text input-text--primary-style" type="text" id="search-label" placeholder="Search Keywords" name="keyword">

                                <button class="btn btn--icon fas fa-search" type="submit"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Content ======-->
</div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#perPageSelect, #sortBySelect').change(function() {
            sort_show_Filter();
        });

        $('#price-filter').submit(function(event) {
            event.preventDefault();
            priceFilter();
        });

        $('.brand-checkbox').change(function() {
            brandsFilter();
        });

        function sort_show_Filter() {
            let perPage = $('#perPageSelect').val();
            let sortBy = $('#sortBySelect').val();

            let searchParams = new URLSearchParams(window.location.search);

            searchParams.forEach((value, key) => {
                searchParams.set(key, value);
            });

            searchParams.set('per_page', perPage);
            searchParams.set('sort_by', sortBy);
            searchParams.set('page', 1);

            let newUrl = window.location.pathname + '?' + searchParams.toString();
            window.location.href = newUrl;
        }

        function priceFilter() {
            let price_min = $('#price-min').val();
            let price_max = $('#price-max').val();

            if (price_min && price_max && price_min > price_max) {
                price_max = parseInt(price_min) + 1;
            }

            let searchParams = new URLSearchParams(window.location.search);
            searchParams.forEach((value, key) => {
                searchParams.set(key, value);
            });

            searchParams.set('price_min', price_min);
            searchParams.set('price_max', price_max);
            searchParams.set('page', 1);

            let newUrl = window.location.pathname + '?' + searchParams.toString();
            window.location.href = newUrl;
        }

        function brandsFilter() {
            let selectedBrands = $('.brand-checkbox:checked');
            let brandIds = selectedBrands.map(function() {
                return $(this).val();
            }).get();

            let searchParams = new URLSearchParams(window.location.search);
            searchParams.set('brand_ids', brandIds.join(','));
            searchParams.set('page', 1);

            let newUrl = window.location.pathname + '?' + searchParams.toString();
            window.location.href = newUrl;
        }

    });
</script>


@endsection