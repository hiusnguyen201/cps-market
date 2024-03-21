@extends('layouts.customer.index')



@section('content')
    <!--====== Primary Slider ======-->
    <div class="s-skeleton s-skeleton--h-640 s-skeleton--bg-grey">
        <div class="owl-carousel primary-style-3" id="hero-slider">
            <div class="hero-slide hero-slide--7" style="background: ">
                <div class="primary-style-3-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="slider-content slider-content--animation">

                                    <span class="content-span-1 u-c-white">Update Your Fashion</span>

                                    <span class="content-span-2 u-c-white">10% Discount on Outwear</span>

                                    <span class="content-span-3 u-c-white">Find outwear on best prices</span>

                                    <span class="content-span-4 u-c-white">Starting At

                                        <span class="u-c-brand">$100.00</span></span>

                                    <a class="shop-now-link btn--e-brand" href="shop-side-version-2.html">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide hero-slide--8">
                <div class="primary-style-3-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="slider-content slider-content--animation">

                                    <span class="content-span-1 u-c-white">Open Your Eyes</span>

                                    <span class="content-span-2 u-c-white">10% Off On Intimates</span>

                                    <span class="content-span-3 u-c-white">Find intimates on best prices</span>

                                    <span class="content-span-4 u-c-white">Starting At

                                        <span class="u-c-brand">$100.00</span></span>

                                    <a class="shop-now-link btn--e-brand" href="shop-side-version-2.html">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide hero-slide--9">
                <div class="primary-style-3-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="slider-content slider-content--animation">

                                    <span class="content-span-1 u-c-white">Find Top Brands</span>

                                    <span class="content-span-2 u-c-white">10% Off On Outwear</span>

                                    <span class="content-span-3 u-c-white">Find outwear on best prices</span>

                                    <span class="content-span-4 u-c-white">Starting At

                                        <span class="u-c-brand">$100.00</span></span>

                                    <a class="shop-now-link btn--e-brand" href="shop-side-version-2.html">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Primary Slider ======-->



    <!--====== Section 1 ======-->
    <div class="u-s-p-y-60">

        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 u-s-m-b-30">
                        <div class="promotion-o">
                            <div class="aspect aspect--bg-grey aspect--square">

                                <img class="aspect__img" src="images/promo/promo-img-4.jpg" alt="">
                            </div>
                            <div class="promotion-o__content">

                                <a class="promotion-o__link btn--e-white-brand" href="shop-side-version-2.html">Women's
                                    Clothing</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 u-s-m-b-30">
                        <div class="promotion-o">
                            <div class="aspect aspect--bg-grey aspect--square">

                                <img class="aspect__img" src="images/promo/promo-img-5.jpg" alt="">
                            </div>
                            <div class="promotion-o__content">

                                <a class="promotion-o__link btn--e-white-brand" href="shop-side-version-2.html">Fashion
                                    Accessories</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 u-s-m-b-30">
                        <div class="promotion-o">
                            <div class="aspect aspect--bg-grey aspect--square">

                                <img class="aspect__img" src="images/promo/promo-img-6.jpg" alt="">
                            </div>
                            <div class="promotion-o__content">

                                <a class="promotion-o__link btn--e-white-brand" href="shop-side-version-2.html">Men's
                                    Clothing</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 1 ======-->


    <!--====== Section 2 Phone ======-->
    <div class="">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">

                            <h1 class="section__heading u-c-secondary u-s-m-b-12">MOST OUTSTANDING PHONE</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($sections2 as $section2)
                            <div class="swiper-slide">
                                <div class="product-bs">
                                    <div class="product-bs__container">
                                        @if ($section2->price - $section2->market_price > 0)
                                            <span class="product-bs__discount-label">
                                                <span class="product-bs__discount-percent">SALE
                                                    {{ round((($section2->price - $section2->market_price) * 100) / $section2->price, 0) }}%</span>
                                            </span>
                                        @endif


                                        <div class="product-bs__wrap">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block"
                                                    href="/{{ $section2->slug }}.html">
                                                    @foreach ($section2->images as $image)
                                                        @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                        @break
                                                    @endif
                                                @endforeach
                                            </a>
                                            <div class="product-bs__action-wrap">
                                                <ul class="product-bs__action-list">
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#quick-look"><i
                                                            class="fas fa-search-plus"></i></a>
                                                    </li>
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#add-to-cart"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <span class="product-bs__category">{{ $section2->category->name }}</span>
                                        <span class="product-bs__name">
                                            <a href="/{{ $section2->slug }}.html">{{ $section2->name }}</a></span>
                                        <div class="product-bs__rating gl-rating-style">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="product-bs__review">(23)</span>
                                        </div>

                                        <span
                                            class="product-bs__price">{{ number_format($section2->market_price, 0, ',', '.') }}&nbsp;₫
                                        <span class="product-bs__discount">{{ number_format($section2->price, 0, ',', '.') }}&nbsp;₫</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 2 ======-->


    <!--====== Section 3 Laptop ======-->
    <div class="">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">

                            <h1 class="section__heading u-c-secondary u-s-m-b-12">MOST OUTSTANDING Laptop</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($sections3 as $section3)
                            <div class="swiper-slide">
                                <div class="product-bs">
                                    <div class="product-bs__container">
                                        @if ($section3->price - $section3->market_price > 0)
                                            <span class="product-bs__discount-label">
                                                <span class="product-bs__discount-percent">SALE
                                                    {{ round((($section3->price - $section3->market_price) * 100) / $section3->price, 0) }}%</span>
                                            </span>
                                        @endif


                                        <div class="product-bs__wrap">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block"
                                                    href="/{{ $section3->slug }}.html">
                                                    @foreach ($section3->images as $image)
                                                        @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                        @break
                                                    @endif
                                                @endforeach
                                            </a>
                                            <div class="product-bs__action-wrap">
                                                <ul class="product-bs__action-list">
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#quick-look"><i
                                                            class="fas fa-search-plus"></i></a>
                                                    </li>
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#add-to-cart"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <span class="product-bs__category">{{ $section3->category->name }}</span>
                                        <span class="product-bs__name">
                                            <a href="/{{ $section3->slug }}.html">{{ $section3->name }}</a></span>
                                        <div class="product-bs__rating gl-rating-style">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="product-bs__review">(23)</span>
                                        </div>

                                        <span
                                            class="product-bs__price">{{ number_format($section3->market_price, 0, ',', '.') }}&nbsp;₫
                                        <span class="product-bs__discount">{{ number_format($section3->price, 0, ',', '.') }}&nbsp;₫</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 3 ======-->



    <!--====== Section 4 Earphone ======-->
    <div class="">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">

                            <h1 class="section__heading u-c-secondary u-s-m-b-12">MOST OUTSTANDING EARPHONE</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="swiper2">
                    <div class="swiper-wrapper">
                        @foreach ($sections4 as $section4)
                            <div class="swiper-slide">
                                <div class="product-bs">
                                    <div class="product-bs__container">
                                        @if ($section4->price - $section4->market_price > 0)
                                            <span class="product-bs__discount-label">
                                                <span class="product-bs__discount-percent">SALE
                                                    {{ round((($section4->price - $section4->market_price) * 100) / $section4->price, 0) }}%</span>
                                            </span>
                                        @endif


                                        <div class="product-bs__wrap">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block"
                                                    href="/{{ $section4->slug }}.html">
                                                    @foreach ($section4->images as $image)
                                                        @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                        @break
                                                    @endif
                                                @endforeach
                                            </a>
                                            <div class="product-bs__action-wrap">
                                                <ul class="product-bs__action-list">
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#quick-look"><i
                                                            class="fas fa-search-plus"></i></a>
                                                    </li>
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#add-to-cart"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <span class="product-bs__category">{{ $section4->category->name }}</span>
                                        <span class="product-bs__name">
                                            <a href="/{{ $section4->slug }}.html">{{ $section4->name }}</a></span>
                                        <div class="product-bs__rating gl-rating-style">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="product-bs__review">(23)</span>
                                        </div>

                                        <span
                                            class="product-bs__price">{{ number_format($section4->market_price, 0, ',', '.') }}&nbsp;₫
                                        <span class="product-bs__discount">{{ number_format($section4->price, 0, ',', '.') }}&nbsp;₫</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 4 ======-->



    <!--====== Section 5 Watch ======-->
    <div class="">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">

                            <h1 class="section__heading u-c-secondary u-s-m-b-12">MOST OUTSTANDING WATCH</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="swiper2">
                    <div class="swiper-wrapper">
                        @foreach ($sections5 as $section5)
                            <div class="swiper-slide">
                                <div class="product-bs">
                                    <div class="product-bs__container">
                                        @if ($section5->price - $section5->market_price > 0)
                                            <span class="product-bs__discount-label">
                                                <span class="product-bs__discount-percent">SALE
                                                    {{ round((($section5->price - $section5->market_price) * 100) / $section5->price, 0) }}%</span>
                                            </span>
                                        @endif


                                        <div class="product-bs__wrap">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block"
                                                    href="/{{ $section5->slug }}.html">
                                                    @foreach ($section5->images as $image)
                                                        @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                        @break
                                                    @endif
                                                @endforeach
                                            </a>
                                            <div class="product-bs__action-wrap">
                                                <ul class="product-bs__action-list">
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#quick-look"><i
                                                            class="fas fa-search-plus"></i></a>
                                                    </li>
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#add-to-cart"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <span class="product-bs__category">{{ $section5->category->name }}</span>
                                        <span class="product-bs__name">
                                            <a href="/{{ $section5->slug }}.html">{{ $section5->name }}</a></span>
                                        <div class="product-bs__rating gl-rating-style">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="product-bs__review">(23)</span>
                                        </div>

                                        <span
                                            class="product-bs__price">{{ number_format($section5->market_price, 0, ',', '.') }}&nbsp;₫
                                        <span class="product-bs__discount">{{ number_format($section5->price, 0, ',', '.') }}&nbsp;₫</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 5 ======-->




    <!--====== Section 6 Accessory ======-->
    <div class="">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">

                            <h1 class="section__heading u-c-secondary u-s-m-b-12">MOST OUTSTANDING ACCESORY</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="swiper2">
                    <div class="swiper-wrapper">
                        @foreach ($sections6 as $section6)
                            <div class="swiper-slide">
                                <div class="product-bs">
                                    <div class="product-bs__container">
                                        @if ($section6->price - $section6->market_price > 0)
                                            <span class="product-bs__discount-label">
                                                <span class="product-bs__discount-percent">SALE
                                                    {{ round((($section6->price - $section6->market_price) * 100) / $section6->price, 0) }}%</span>
                                            </span>
                                        @endif


                                        <div class="product-bs__wrap">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block"
                                                    href="/{{ $section6->slug }}.html">
                                                    @foreach ($section6->images as $image)
                                                        @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                        @break
                                                    @endif
                                                @endforeach
                                            </a>
                                            <div class="product-bs__action-wrap">
                                                <ul class="product-bs__action-list">
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#quick-look"><i
                                                            class="fas fa-search-plus"></i></a>
                                                    </li>
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#add-to-cart"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <span class="product-bs__category">{{ $section6->category->name }}</span>
                                        <span class="product-bs__name">
                                            <a href="/{{ $section6->slug }}.html">{{ $section6->name }}</a></span>
                                        <div class="product-bs__rating gl-rating-style">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="product-bs__review">(23)</span>
                                        </div>

                                        <span
                                            class="product-bs__price">{{ number_format($section6->market_price, 0, ',', '.') }}&nbsp;₫
                                        <span class="product-bs__discount">{{ number_format($section6->price, 0, ',', '.') }}&nbsp;₫</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 6 ======-->



    <!--====== Section 7 Secondhand ======-->
    <div class="">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">

                            <h1 class="section__heading u-c-secondary u-s-m-b-12">MOST OUTSTANDING SECOND-HAND</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="swiper2">
                    <div class="swiper-wrapper">
                        @foreach ($sections7 as $section7)
                            <div class="swiper-slide">
                                <div class="product-bs">
                                    <div class="product-bs__container">
                                        @if ($section7->price - $section7->market_price > 0)
                                            <span class="product-bs__discount-label">
                                                <span class="product-bs__discount-percent">SALE
                                                    {{ round((($section7->price - $section7->market_price) * 100) / $section7->price, 0) }}%</span>
                                            </span>
                                        @endif


                                        <div class="product-bs__wrap">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block"
                                                    href="/{{ $section7->slug }}.html">
                                                    @foreach ($section7->images as $image)
                                                        @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                        @break
                                                    @endif
                                                @endforeach
                                            </a>
                                            <div class="product-bs__action-wrap">
                                                <ul class="product-bs__action-list">
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#quick-look"><i
                                                            class="fas fa-search-plus"></i></a>
                                                    </li>
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#add-to-cart"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <span class="product-bs__category">{{ $section7->category->name }}</span>
                                        <span class="product-bs__name">
                                            <a href="/{{ $section7->slug }}.html">{{ $section7->name }}</a></span>
                                        <div class="product-bs__rating gl-rating-style">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="product-bs__review">(23)</span>
                                        </div>

                                        <span
                                            class="product-bs__price">{{ number_format($section7->market_price, 0, ',', '.') }}&nbsp;₫
                                        <span class="product-bs__discount">{{ number_format($section7->price, 0, ',', '.') }}&nbsp;₫</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 7 ======-->



    <!--====== Section 8 Tablet ======-->
    <div class="">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">

                            <h1 class="section__heading u-c-secondary u-s-m-b-12">MOST OUTSTANDING TABLET</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="swiper2">
                    <div class="swiper-wrapper">
                        @foreach ($sections8 as $section8)
                            <div class="swiper-slide">
                                <div class="product-bs">
                                    <div class="product-bs__container">
                                        @if ($section8->price - $section8->market_price > 0)
                                            <span class="product-bs__discount-label">
                                                <span class="product-bs__discount-percent">SALE
                                                    {{ round((($section8->price - $section8->market_price) * 100) / $section8->price, 0) }}%</span>
                                            </span>
                                        @endif


                                        <div class="product-bs__wrap">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block"
                                                    href="/{{ $section8->slug }}.html">
                                                    @foreach ($section8->images as $image)
                                                        @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                        @break
                                                    @endif
                                                @endforeach
                                            </a>
                                            <div class="product-bs__action-wrap">
                                                <ul class="product-bs__action-list">
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#quick-look"><i
                                                            class="fas fa-search-plus"></i></a>
                                                    </li>
                                                    <li>

                                                        <a data-modal="modal" data-modal-id="#add-to-cart"><i
                                                                class="fas fa-plus-circle"></i></a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <span class="product-bs__category">{{ $section8->category->name }}</span>
                                        <span class="product-bs__name">
                                            <a href="/{{ $section8->slug }}.html">{{ $section8->name }}</a></span>
                                        <div class="product-bs__rating gl-rating-style">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span class="product-bs__review">(23)</span>
                                        </div>

                                        <span
                                            class="product-bs__price">{{ number_format($section8->market_price, 0, ',', '.') }}&nbsp;₫
                                        <span class="product-bs__discount">{{ number_format($section8->price, 0, ',', '.') }}&nbsp;₫</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 8 ======-->










    <!--====== Section 9 ======-->
    <div class="u-s-p-b-60">

        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-6 col-sm-6 u-s-m-b-30">
                        <div class="column-product">

                            <span class="column-product__title u-c-secondary u-s-m-b-25">DAILY
                                PRODUCTS</span>
                            <ul class="column-product__list">
                                @foreach ($sections9D as $section9D)
                                    <li class="column-product__item">
                                        <div class="product-l">
                                            <div class="product-l__img-wrap">

                                                <a class="aspect aspect--bg-grey aspect--square u-d-block product-l__link"
                                                    href="/{{ $section9D->slug }}">

                                                    @foreach ($section9D->images as $image)
                                                    @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                    @break
                                                    @endif
                                                    @endforeach
                                                </a>
                                            </div>
                                            <div class="product-l__info-wrap">
                                                <span class="product-l__category">{{ $section9D->category->name }}</span>

                                                <span class="product-l__name">

                                                    <a href="/{{ $section9D->slug }}">{{ $section9D->name }}</a></span>

                                                <span class="product-l__price">{{ number_format($section9D->market_price, 0, ',', '.') }}&nbsp;₫</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 u-s-m-b-30">
                        <div class="column-product">

                            <span class="column-product__title u-c-secondary u-s-m-b-25">WEEKLY
                                PRODUCTS</span>
                            <ul class="column-product__list">
                                @foreach ($sections9W as $section9W)
                                    <li class="column-product__item">
                                        <div class="product-l">
                                            <div class="product-l__img-wrap">

                                                <a class="aspect aspect--bg-grey aspect--square u-d-block product-l__link"
                                                    href="/{{ $section9W->slug }}">

                                                    @foreach ($section9W->images as $image)
                                                    @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                    @break
                                                    @endif
                                                    @endforeach
                                                </a>
                                            </div>
                                            <div class="product-l__info-wrap">
                                                <span class="product-l__category">{{ $section9W->category->name }}</span>

                                                <span class="product-l__name">

                                                    <a href="/{{ $section9W->slug }}">{{ $section9W->name }}</a></span>

                                                <span class="product-l__price">{{ number_format($section9W->market_price, 0, ',', '.') }}&nbsp;₫</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 u-s-m-b-30">
                        <div class="column-product">

                            <span class="column-product__title u-c-secondary u-s-m-b-25">MONTHLY
                                PRODUCTS</span>
                            <ul class="column-product__list">
                                @foreach ($sections9M as $section9M)
                                    <li class="column-product__item">
                                        <div class="product-l">
                                            <div class="product-l__img-wrap">

                                                <a class="aspect aspect--bg-grey aspect--square u-d-block product-l__link"
                                                    href="/{{ $section9M->slug }}">

                                                    @foreach ($section9M->images as $image)
                                                    @if ($image->pin == 1)
                                                        <img src="{{ asset('storage/' . $image->thumbnail) }}"
                                                            class="aspect__img" alt="">
                                                    @break
                                                    @endif
                                                    @endforeach
                                                </a>
                                            </div>
                                            <div class="product-l__info-wrap">
                                                <span class="product-l__category">{{ $section9M->category->name }}</span>

                                                <span class="product-l__name">

                                                    <a href="/{{ $section9M->slug }}">{{ $section9M->name }}</a></span>

                                                <span class="product-l__price">{{ number_format($section9M->market_price, 0, ',', '.') }}&nbsp;₫</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 9 ======-->
@endsection
