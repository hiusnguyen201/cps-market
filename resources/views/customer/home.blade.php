@extends('layouts.customer.index')
@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@section('content')
    <div class="s-skeleton s-skeleton--h-640 s-skeleton--bg-grey">
        <div class="owl-carousel primary-style-3" id="hero-slider">
            <div class="hero-slide hero-slide--7">
                <div class="primary-style-3-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="slider-content slider-content--animation">
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
                    <div class="col-lg-5 col-md-5 u-s-m-b-30">

                        <a class="collection" href="/catalogsearch/result">
                            <div class="aspect aspect--bg-grey aspect--square">

                                <img class="aspect__img collection__img" src="{{ asset('images/Sale2.jpg') }}"
                                    alt="Sale1">
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-7 col-md-7">

                        <a class="collection" href="/catalogsearch/result">
                            <div class="aspect aspect--bg-grey aspect--1286-890">

                                <img class="aspect__img collection__img" src="{{ asset('images/Sale1.jpg') }}"
                                    alt="Sale2">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($sections as $index => $section)
        @if ($categories[$index]->products && count($categories[$index]->products))
            <section class="u-s-p-b-60">
                <div class="section__intro u-s-m-b-30">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section__text-wrap">
                                    <h1 class="section__heading u-c-secondary">TOP TRENDING
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
                                            <a href='/{{ $product->slug }}.html'>

                                                <div class="product-bs__container">
                                                    <div class="product-bs__wrap">
                                                        <div class="aspect aspect--bg-grey aspect--square u-d-block">
                                                            @foreach ($product->images as $image)
                                                                @if ($image->pin == 1)
                                                                    <img src="{{ asset($image->thumbnail) }}"
                                                                        class="aspect__img" alt="">
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <span class="product-bs__category">{{ $product->category->name }}</span>
                                                    <span class="product-bs__name u-s-m-b-10"
                                                        class="product-name">{{ $product->name }}</span>
                                                    <div hidden class="product-bs__rating gl-rating-style">
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
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
            </section>
        @endif
    @endforeach


    <div class="section__content u-s-p-y-60">
        <section class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 u-s-m-b-30">
                    <div class="column-product">
                        <span class="column-product__title u-c-secondary u-s-m-b-25">BEST WEEKLY
                            PRODUCTS</span>
                        <ul class="column-product__list">
                            @foreach ($sections9W as $product)
                                <li class="column-product__item">
                                    <div class="product-l">
                                        <div class="product-l__img-wrap">
                                            <a class="aspect aspect--bg-grey aspect--square u-d-block product-l__link"
                                                href="/{{ $product->slug }}.html">

                                                @foreach ($product->images as $image)
                                                    @if ($image->pin == 1)
                                                        <img src="{{ asset($image->thumbnail) }}" class="aspect__img"
                                                            alt="">
                                                    @endif
                                                @endforeach
                                            </a>
                                        </div>
                                        <div class="product-l__info-wrap u-s-p-r-5">
                                            <span class="product-l__category"><a
                                                    href="/catalogsearch/result?category_id={{ $product->category->id }}">{{ $product->category->name }}</a>
                                            </span>

                                            <span class="product-l__name">

                                                <a href="/{{ $product->slug }}.html"
                                                    class="product-name">{{ $product->name }}</a></span>

                                            <span class="product-l__price">@convertCurrency($product->sale_price ?? $product->price)
                                                @if ($product->sale_price)
                                                    <span class="product-bs__discount">@convertCurrency($product->price)</span>
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

                        <span class="column-product__title u-c-secondary u-s-m-b-25">BEST MONTHLY
                            PRODUCTS</span>
                        <ul class="column-product__list">
                            @foreach ($sections9M as $product)
                                <li class="column-product__item">
                                    <div class="product-l">
                                        <div class="product-l__img-wrap">

                                            <a class="aspect aspect--bg-grey aspect--square u-d-block product-l__link"
                                                href="/{{ $product->slug }}.html">

                                                @foreach ($product->images as $image)
                                                    @if ($image->pin == 1)
                                                        <img src="{{ asset($image->thumbnail) }}" class="aspect__img"
                                                            alt="">
                                                    @endif
                                                @endforeach
                                            </a>
                                        </div>
                                        <div class="product-l__info-wrap u-s-p-r-5">
                                            <span class="product-l__category"><a
                                                    href="/catalogsearch/result?category_id={{ $product->category->id }}">{{ $product->category->name }}</a>
                                            </span>
                                            <span class="product-l__name">
                                                <a href="/{{ $product->slug }}.html"
                                                    class="product-name">{{ $product->name }}</a></span>
                                            <span class="product-l__price">@convertCurrency($product->sale_price ?? $product->price)
                                                @if ($product->sale_price)
                                                    <span class="product-bs__discount">@convertCurrency($product->price)</span>
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
                        <span class="column-product__title u-c-secondary u-s-m-b-25">BEST YEARLY
                            PRODUCTS</span>
                        <ul class="column-product__list">
                            @foreach ($sections9Y as $product)
                                <li class="column-product__item">
                                    <div class="product-l">
                                        <div class="product-l__img-wrap">
                                            <a class="aspect aspect--bg-grey aspect--square u-d-block product-l__link"
                                                href="/{{ $product->slug }}.html">
                                                @foreach ($product->images as $image)
                                                    @if ($image->pin == 1)
                                                        <img src="{{ asset($image->thumbnail) }}" class="aspect__img"
                                                            alt="">
                                                    @endif
                                                @endforeach
                                            </a>
                                        </div>
                                        <div class="product-l__info-wrap u-s-p-r-5">
                                            <span class="product-l__category">
                                                <a
                                                    href="/catalogsearch/result?category_id={{ $product->category->id }}">{{ $product->category->name }}</a></span>
                                            <span class="product-l__name">
                                                <a href="/{{ $product->slug }}.html"
                                                    class="product-name">{{ $product->name }}</a>
                                            </span>
                                            <span class="product-l__price">@convertCurrency($product->sale_price ?? $product->price)
                                                @if ($product->sale_price)
                                                    <span class="product-bs__discount">@convertCurrency($product->price)</span>
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
    </div>
@endsection
