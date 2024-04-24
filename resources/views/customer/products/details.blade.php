@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

    <style>
        #addToWishlist {
            font-size: 13px;
            color: #a0a0a0;
            border: 0;
            padding: 0;
            background: none;
            cursor: pointer;
            transition: color 110ms ease-in-out;
        }

        #addToWishlist:hover {
            text-decoration: underline;
            color: #b6b6b6;
        }
    </style>

    <div class="u-s-p-t-90">
        <div class="container">
            <div class="u-s-m-b-30">
                <div class="pd-breadcrumb u-s-m-b-30">
                    <ul class="pd-breadcrumb__list">
                        <li class="has-separator">
                            <a href="/">Home</a>
                        </li>
                        <li class="has-separator">

                            <a
                                href="/catalogsearch/result?category_id={{ $product->category->id }}">{{ $product->category->name }}</a>
                        </li>
                        <li class="has-separator">

                            <a
                                href="/catalogsearch/result?brand_id={{ $product->brand->id }}">{{ $product->brand->name }}</a>
                        </li>
                        <li class="is-marked">

                            <a
                                href="/{{ $product->category->slug }}/{{ $product->brand->slug }}/{{ $product->slug }}.html">{{ $product->name }}</a>
                        </li>
                    </ul>
                </div>
                <!--====== End - Product Breadcrumb ======-->
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <!--====== Product Detail Zoom ======-->
                    <div class="pd u-s-m-b-30">
                        <div class="slider-fouc pd-wrap">
                            <div id="pd-o-initiate">
                                @if (count($product->images))
                                    @foreach ($product->images as $image)
                                        <div class="pd-o-img-wrap" data-src="{{ asset($image->thumbnail) }}">
                                            <img class="u-img-fluid" src="{{ asset($image->thumbnail) }}"
                                                data-zoom-image="{{ asset($image->thumbnail) }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="u-s-m-t-15">
                            <div class="slider-fouc">
                                <div id="pd-o-thumbnail">
                                    @if (count($product->images))
                                        @foreach ($product->images as $image)
                                            <div>
                                                <img class="u-img-fluid" src="{{ asset($image->thumbnail) }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--====== End - Product Detail Zoom ======-->
                </div>
                <div class="col-lg-7">

                    <!--====== Product Right Side Details ======-->
                    <div class="pd-detail">
                        <div>
                            <span class="pd-detail__name">{{ $product->name }}</span>
                        </div>
                        <div>
                            <div class="pd-detail__inline">

                                <span class="pd-detail__price">@convertCurrency($product->sale_price ?? $product->price)</span>
                                @if ($product->sale_price && $product->price - $product->sale_price > 0)
                                    <span
                                        class="pd-detail__discount">({{ round((($product->price - $product->sale_price) * 100) / $product->price, 0) }}%
                                        OFF)
                                    </span>
                                    <span class="pd-detail__del">@convertCurrency($product->price)</span>
                                @endif
                            </div>
                        </div>
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__rating gl-rating-style"><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star-half-alt"></i>

                                <span class="pd-detail__review u-s-m-l-4">

                                    <a data-click-scroll="#view-review">23 Reviews</a></span>
                            </div>
                        </div>
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__inline">

                                <span class="pd-detail__stock">{{ $product->sold }} is sold</span>

                                <span
                                    class="pd-detail__left">{{ $product->quantity > 0 ? 'Only' . ' ' . $product->quantity . ' ' . 'left' : 'Out of stock' }}</span>
                            </div>
                        </div>
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__inline">
                                @php
                                    $wishlistCheck = null;
                                    if ($wishlist) {
                                        $wishlistCheck = $wishlist
                                            ->filter(function ($item) use ($product) {
                                                return $item->product_id == $product->id;
                                            })
                                            ->first();
                                    }
                                @endphp
                                @if ($wishlistCheck)
                                    <form action="/wishlist" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="wishlist_id" value="{{ $wishlistCheck->id }}"><i
                                            class="fas fa-heart u-s-m-r-6" style="color: red;"></i>
                                        <button id="addToWishlist" class="pd-detail__click-wrap" type="submit">
                                            Remove Wishlist
                                        </button>
                                    </form>
                                @else
                                    <form action="/wishlist" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}"><i
                                            class="fas fa-heart u-s-m-r-6"></i>
                                        <button id="addToWishlist" class="pd-detail__click-wrap" type="submit">
                                            Add to Wishlist
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__inline">

                                <span class="pd-detail__click-wrap"><i class="far fa-envelope u-s-m-r-6"></i>

                                    <a href="signin.html">Email me When the price drops</a>

                                    <span class="pd-detail__click-count">(20)</span></span>
                            </div>
                        </div>
                        <div class="u-s-m-b-15">
                            <ul class="pd-social-list">
                                <li>

                                    <a class="s-fb--color-hover" href="https://www.facebook.com/"><i
                                            class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>

                                    <a class="s-tw--color-hover" href="https://twitter.com/"><i
                                            class="fab fa-twitter"></i></a>
                                </li>
                                <li>

                                    <a class="s-insta--color-hover" href="https://www.instagram.com/"><i
                                            class="fab fa-instagram"></i></a>
                                </li>
                                <li>

                                    <a class="s-wa--color-hover" href="https://www.whatsapp.com/"><i
                                            class="fab fa-whatsapp"></i></a>
                                </li>
                                <li>

                                    <a class="s-gplus--color-hover" href="https://www.google.com/"><i
                                            class="fab fa-google-plus-g"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="u-s-m-b-15">
                            <div class="pd-detail__form" style="display: flex; align-items:center; gap:15px">
                                <form method="POST" action="{{ route('cart.create') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="action" value="buy">
                                    <button class="btn btn--e-brand-b-2" type="submit">Buy now</button>
                                </form>
                                <form method="POST" action="{{ route('cart.create') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="action" value="add">
                                    <button class="btn btn--e-brand-b-1" type="submit">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="u-s-m-b-15">

                            <span class="pd-detail__label u-s-m-b-8">Product Policy:</span>
                            <ul class="pd-detail__policy-list">
                                <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                    <span>Buyer Protection.</span>
                                </li>
                                <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                    <span>Full Refund if you don't receive your order.</span>
                                </li>
                                <li><i class="fas fa-check-circle u-s-m-r-8"></i>

                                    <span>Returns accepted if product not as described.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--====== End - Product Right Side Details ======-->
                </div>
            </div>
        </div>
    </div>

    <!--====== Product Detail Tab ======-->
    <div class="u-s-p-y-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pd-tab">
                        <div class="u-s-m-b-30">
                            <ul class="nav pd-tab__list">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#pd-desc">DESCRIPTION</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane  fade show active" id="pd-desc">
                                <div class="pd-tab__desc">
                                    <div class="u-s-m-b-15">
                                        <p>{{ $product->description }}</p>
                                    </div>
                                    <div class="u-s-m-b-15">
                                        <h4>PRODUCT INFORMATION</h4>
                                    </div>
                                    <div class="u-s-m-b-15">
                                        <div class="pd-table gl-scroll">
                                            <table>
                                                <tbody>
                                                    @if ($product->products_attributes && count($product->products_attributes))
                                                        @foreach ($product->products_attributes as $product_attribute)
                                                            <tr>
                                                                <td>{{ $product_attribute->attribute->key }}</td>
                                                                <td>{{ $product_attribute->value }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Product Detail Tab ======-->
    <div class="u-s-p-b-90">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-46">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">
                            <h1 class="section__heading u-c-secondary u-s-m-b-12">SIMILAR BRAND PRODUCTS</h1>
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
                        @foreach ($similarProducts as $product)
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
                                                            <img src="{{ asset($image->thumbnail) }}" class="aspect__img"
                                                                alt="">
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
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    @endsection
