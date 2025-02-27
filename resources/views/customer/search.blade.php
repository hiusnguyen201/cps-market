@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

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

                                        <span class="fas fa-minus shop-w__toggle" data-target="#s-category"
                                            data-toggle="collapse"></span>
                                    </div>
                                    <div class="shop-w__wrap collapse show" id="s-category">
                                        <ul class="shop-w__list-2">
                                            @if (count($categories))
                                                @foreach ($categories as $category)
                                                    <li>
                                                        <div class="list__content">
                                                            <input type="checkbox" class="category-checkbox" name="category"
                                                                value="{{ $category->id }}"
                                                                {{ request()->has('category_id') && request()->category_id == $category->id ? 'checked' : '' }}>
                                                            <span>{{ $category->name }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="u-s-m-b-30">
                                <div class="shop-w shop-w--style">
                                    <div class="shop-w__intro-wrap">
                                        <h1 class="shop-w__h">PRICE</h1>

                                        <span class="fas fa-minus shop-w__toggle" data-target="#s-price"
                                            data-toggle="collapse"></span>
                                    </div>
                                    <div class="shop-w__wrap collapse show" id="s-price">
                                        <div class="wrapper">
                                            <form action="" id="price-filter">
                                                <div class="price-input">
                                                    <div class="field">
                                                        <span>Min</span>
                                                        <input type="number" id="price-min" name="price_min"
                                                            class="input-min" value="{{ request()->price_min ?? 0 }}">
                                                    </div>
                                                    <div class="separator"></div>
                                                    <div class="field">
                                                        <span>Max</span>
                                                        <input type="number" id="price-max" name="price_max"
                                                            class="input-max"
                                                            value="{{ request()->price_max ?? 100000000 }}">
                                                    </div>
                                                </div>

                                                <div class="range-input">
                                                    <div class="u-s-m-b-30">
                                                        <div class="slider">
                                                            @php
                                                                $leftProgress = request()->price_min
                                                                    ? (request()->price_min / 100000000) * 100
                                                                    : (request()->price_min = 1);
                                                                $rightProgress = request()->price_max
                                                                    ? 100 - (request()->price_max / 100000000) * 100
                                                                    : 0;
                                                            @endphp
                                                            <div class="progress"
                                                                style="left: {{ $leftProgress }}%; right: {{ $rightProgress }}%;">
                                                            </div>
                                                        </div>

                                                        <input type="range" class="range-min" min="0"
                                                            max="100000000" value="{{ request()->price_min ?? 0 }}"
                                                            step="100000">
                                                        <input type="range" class="range-max" min="0"
                                                            max="100000000" value="{{ request()->price_max ?? 100000000 }}"
                                                            step="100000">
                                                    </div>
                                                    <button
                                                        class="priceSearchBtn btn btn--icon fas fa-angle-right btn--e-transparent-platinum-b-2"
                                                        type="submit"></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="u-s-m-b-30">
                                <div class="shop-w shop-w--style">
                                    <div class="shop-w__intro-wrap">
                                        <h1 class="shop-w__h">MANUFACTURER</h1>

                                        <span class="fas fa-minus shop-w__toggle" data-target="#s-manufacturer"
                                            data-toggle="collapse"></span>
                                    </div>
                                    <div class="shop-w__wrap collapse show" id="s-manufacturer">
                                        <ul class="shop-w__list-2">
                                            @if (count($brands))
                                                @foreach ($brands as $brand)
                                                    <li>
                                                        <div class="list__content">
                                                            <input type="checkbox" class="brand-checkbox" name="brand"
                                                                value="{{ $brand->id }}"
                                                                {{ request()->has('brand_id') && request()->brand_id == $brand->id ? 'checked' : '' }}>
                                                            <span>{{ $brand->name }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="shop-p__meta-wrap u-s-m-b-60">

                        <span class="shop-p__meta-text-1">FOUND {{ $countProducts ?? 0 }} RESULTS</span>

                    </div>
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
                                            <select id="perPageSelect" class="select-box select-box--transparent-b-2"
                                                name="per_page">
                                                <option value="8" {{ request()->per_page == 8 ? 'selected' : '' }}>
                                                    Show: 8
                                                </option>
                                                <option value="12" {{ request()->per_page == 12 ? 'selected' : '' }}>
                                                    Show:
                                                    12</option>
                                                <option value="16" {{ request()->per_page == 16 ? 'selected' : '' }}>
                                                    Show:
                                                    16</option>
                                                <option value="28" {{ request()->per_page == 28 ? 'selected' : '' }}>
                                                    Show:
                                                    28</option>
                                            </select>
                                        </div>

                                        <div class="u-s-m-b-8">
                                            <select id="sortBySelect" class="select-box select-box--transparent-b-2"
                                                name="sort_by">
                                                <option value="newest"
                                                    {{ request()->sort_by == 'newest' ? 'selected' : '' }}>
                                                    Sort By: Newest Items</option>
                                                <option value="latest"
                                                    {{ request()->sort_by == 'latest' ? 'selected' : '' }}>
                                                    Sort By: Latest Items</option>
                                                <option value="lowest_price"
                                                    {{ request()->sort_by == 'lowest_price' ? 'selected' : '' }}>Sort By:
                                                    Lowest
                                                    Price</option>
                                                <option value="highest_price"
                                                    {{ request()->sort_by == 'highest_price' ? 'selected' : '' }}>Sort By:
                                                    Highest Price</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                        <div class="shop-p__collection">
                            <div class="row is-grid-active">
                                @if (count($products))
                                    @foreach ($products as $product)
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="product-m">
                                                <div class="product-m__thumb">
                                                    @foreach ($product->images as $image)
                                                        @if ($image->pin)
                                                            <a class="aspect aspect--bg-grey aspect--square u-d-block"
                                                                href="/{{ $product->slug }}.html">

                                                                <img class="aspect__img"
                                                                    src="{{ asset($image->thumbnail) }}"
                                                                    alt="{{ $product->name }}"
                                                                    style="height: 100%; object-fit: contain;">
                                                            </a>
                                                        @endif
                                                    @endforeach

                                                    <div class="product-m__add-cart">
                                                        <form method="POST" action="/cart">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <input type="hidden" name="action" value="add">
                                                            <button style="width:100%;cursor: pointer;padding: 12px"
                                                                class="btn--e-brand" type="submit">Add to
                                                                Cart</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="product-m__content">
                                                    <div class="product-m__category">
                                                        <a
                                                            href="/catalogsearch/result?brand_id={{ $product->brand->id }}">{{ $product->brand->name }}</a>
                                                    </div>
                                                    <div class="product-m__name u-s-m-b-10">
                                                        <a href="/{{ $product->slug }}.html">{{ $product->name }}</a>
                                                    </div>
                                                    <div hidden class="product-m__rating gl-rating-style"><i
                                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                            class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i
                                                            class="far fa-star"></i>

                                                        <span class="product-m__review">(23)</span>
                                                    </div>
                                                    <div class="product-m__price">
                                                        <span
                                                            style="color: #ff4500;font-size:16px;">@convertCurrency($product->sale_price ?? $product->price)</span>
                                                        @if ($product->sale_price)
                                                            <span
                                                                style="color: #333;text-decoration:line-through;margin-left:8px">@convertCurrency($product->price)</span>
                                                        @endif

                                                    </div>
                                                    <div class="product-m__hover">
                                                        <div class="product-m__preview-description">
                                                            <span>{{ $product->description }}</span>
                                                        </div>
                                                        <div class="product-m__wishlist">
                                                            @php
                                                                $wishlist = null;
                                                                if (Auth::user()) {
                                                                    $wishlist = Auth::user()
                                                                        ->wishlist->filter(function ($item) use (
                                                                            $product,
                                                                        ) {
                                                                            return $item->product_id == $product->id;
                                                                        })
                                                                        ->first();
                                                                }
                                                            @endphp
                                                            @if ($wishlist)
                                                                <form action="/wishlist" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="wishlist_id"
                                                                        value="{{ $wishlist->id }}">
                                                                    <button id="addToWishlist"
                                                                        class="pd-detail__click-wrap" type="submit"
                                                                        data-tooltip="tooltip" data-placement="top"
                                                                        title="Remove Wishlist">
                                                                        <i class="fas fa-heart" style="color: red;"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <form action="/wishlist" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product->id }}">
                                                                    <button id="addToWishlist"
                                                                        class="pd-detail__click-wrap" type="submit"
                                                                        data-tooltip="tooltip" data-placement="top"
                                                                        title="Add to Wishlist">
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
                                @endif
                            </div>
                        </div>
                        @if ($products && count($products))
                            <div class="u-s-p-y-60">
                                {{ $products->onEachSide(2)->appends(Request::all())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
