@extends('layouts.customer.index')

@section('content')
    <div class="s-skeleton s-skeleton--h-640 s-skeleton--bg-grey">
        <div class="owl-carousel primary-style-3" id="hero-slider">
            <div class="hero-slide hero-slide--7">
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

    <div class="u-s-p-y-60">
        <div class="section__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 u-s-m-b-30">
                        <div class="promotion-o">
                            <div class="aspect aspect--bg-grey aspect--square">

                                <img class="aspect__img" src="./images/Mobile.jpg" alt="">
                            </div>
                            <div class="promotion-o__content">

                                <a class="promotion-o__link btn--e-white-brand" href="/phone.html">Mobile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 u-s-m-b-30">
                        <div class="promotion-o">
                            <div class="aspect aspect--bg-grey aspect--square">

                                <img class="aspect__img" src="./images/Laptop.jpg" alt="">
                            </div>
                            <div class="promotion-o__content">

                                <a class="promotion-o__link btn--e-white-brand" href="/laptop.html">Laptop</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 u-s-m-b-30">
                        <div class="promotion-o">
                            <div class="aspect aspect--bg-grey aspect--square">

                                <img class="aspect__img" src="./images/Watch.jpg" alt="">
                            </div>
                            <div class="promotion-o__content">

                                <a class="promotion-o__link btn--e-white-brand" href="/watch.html">Watch</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($sections as $index => $section)
        <section class="u-s-p-y-60">
            <div class="section__intro u-s-m-b-46">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section__text-wrap">
                                <h1 class="section__heading u-c-secondary u-s-m-b-12">MOST OUTSTANDING
                                    {{ strtoupper($categories[$index]->name) }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section__content">
                <div class="container">
                    <div class="swiper">
                        <div class="swiper-button-prev"></div>

                        <div class="swiper-wrapper">
                            @foreach ($section as $product)
                                <div class="swiper-slide">
                                    @if ($product->sale_price && $product->price - $product->sale_price > 0)
                                        <span class="product-bs__discount-label">
                                            <span class="product-bs__discount-percent">SALE
                                                {{ round((($product->price - $product->sale_price) * 100) / $product->price, 0) }}%</span>
                                        </span>
                                    @endif
                                    <div class="product-bs">
                                        <a
                                            href='/{{ $product->category->slug }}/{{ $product->brand->slug }}/{{ $product->slug }}.html'>

                                            <div class="product-bs__container">
                                                <div class="product-bs__wrap">
                                                    <div class="aspect aspect--bg-grey aspect--square u-d-block">
                                                        @foreach ($product->images as $image)
                                                            @if ($image->pin == 1)
                                                                <img src="{{ asset($image->thumbnail) }}"
                                                                    class="aspect__img" alt="">
                                                            @break
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                            <span class="product-bs__category">{{ $product->category->name }}</span>
                                            <span class="product-bs__name">{{ $product->name }}</span>
                                            <div class="product-bs__rating gl-rating-style">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <span class="product-bs__review">(23)</span>
                                            </div>

                                            <span class="product-bs__price">@convertCurrency($product->sale_price ?? $product->price)
                                                @if ($product->sale_price)
                                                    <span class="product-bs__discount">@convertCurrency($product->price)</span>
                                                @endif
                                            </span>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </section>
@endforeach


<section class="">
    <div class="section__content u-s-p-y-60">
        <section class="container">
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
                                                href="/{{ $section9D->category->slug }}/{{ $section9D->brand->slug }}/{{ $section9D->slug }}.html">
                                                @foreach ($section9D->images as $image)
                                                    @if ($image->pin == 1)
                                                        <img src="{{ asset($image->thumbnail) }}" class="aspect__img"
                                                            alt="">
                                                    @break
                                                @endif
                                            @endforeach
                                        </a>
                                    </div>
                                    <div class="product-l__info-wrap">
                                        <span class="product-l__category">
                                            <a
                                                href="/{{ $section9D->category->slug }}.html">{{ $section9D->category->name }}</a></span>
                                        <span class="product-l__name">
                                            <a
                                                href="/{{ $section9D->category->slug }}/{{ $section9D->brand->slug }}/{{ $section9D->slug }}.html">{{ $section9D->name }}</a>
                                        </span>
                                        <span class="product-l__price">@convertCurrency($section9D->sale_price ?? $section9D->price)
                                            @if ($section9D->sale_price)
                                                <span class="product-bs__discount">@convertCurrency($section9D->price)</span>
                                            @endif
                                        </span>
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
                                            href="/{{ $section9W->category->slug }}/{{ $section9W->brand->slug }}/{{ $section9W->slug }}.html">

                                            @foreach ($section9W->images as $image)
                                                @if ($image->pin == 1)
                                                    <img src="{{ asset($image->thumbnail) }}" class="aspect__img"
                                                        alt="">
                                                @break
                                            @endif
                                        @endforeach
                                    </a>
                                </div>
                                <div class="product-l__info-wrap">
                                    <span class="product-l__category"><a
                                            href="/{{ $section9W->category->slug }}.html">{{ $section9W->category->name }}</a>
                                    </span>

                                    <span class="product-l__name">

                                        <a
                                            href="/{{ $section9W->category->slug }}/{{ $section9W->brand->slug }}/{{ $section9W->slug }}.html">{{ $section9W->name }}</a></span>

                                    <span class="product-l__price">@convertCurrency($section9W->sale_price ?? $section9D->price)
                                        @if ($section9W->sale_price)
                                            <span class="product-bs__discount">@convertCurrency($section9W->price)</span>
                                        @endif
                                    </span>
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
                                        href="/{{ $section9M->category->slug }}/{{ $section9M->brand->slug }}/{{ $section9M->slug }}.html">

                                        @foreach ($section9M->images as $image)
                                            @if ($image->pin == 1)
                                                <img src="{{ asset($image->thumbnail) }}" class="aspect__img"
                                                    alt="">
                                            @break
                                        @endif
                                    @endforeach
                                </a>
                            </div>
                            <div class="product-l__info-wrap">
                                <span class="product-l__category"><a
                                        href="/{{ $section9M->category->slug }}.html">{{ $section9M->category->name }}</a>
                                </span>
                                <span class="product-l__name">
                                    <a
                                        href="/{{ $section9M->category->slug }}/{{ $section9M->brand->slug }}/{{ $section9M->slug }}.html">{{ $section9M->name }}</a></span>
                                <span class="product-l__price">@convertCurrency($section9M->sale_price ?? $section9D->price)
                                    @if ($section9M->sale_price)
                                        <span class="product-bs__discount">@convertCurrency($section9M->price)</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</div>
</section>
@endsection
