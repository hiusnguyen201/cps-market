@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

    <style>
        .wishlist {
            font-size: 12px;
            font-weight: 600;
            border: 0;
            background: none;
            cursor: pointer;
            padding: 15px 32px;
        }
    </style>

    @if (count($wishlist))
        <div class="u-s-p-y-60">
            <!--====== Section Content ======-->
            <div class="section__content">
                <div class="container">
                    <div class="breadcrumb">
                        <div class="breadcrumb__wrap">
                            <ul class="breadcrumb__list">
                                <li class="has-separator">
                                    <a href="/">Home</a>
                                </li>
                                <li class="has-separator">
                                    <a href="/member">Member</a>
                                </li>
                                <li class="is-marked">

                                    <a href="/wishlist">Wishlist</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="u-s-p-b-60">
            <div class="section__content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @if (count($wishlist))
                                @foreach ($wishlist as $item)
                                    <div class="w-r u-s-m-b-30">
                                        <div class="w-r__container">
                                            <div style="{{ $item->product->deleted_at ? 'opacity: 0.6;pointer-events: none' : '' }}"
                                                class="w-r__wrap-1" style="max-width: 550px">
                                                <div class="w-r__img-wrap">
                                                    @foreach ($item->product->images as $image)
                                                        @if ($image->pin == 1)
                                                            @if (!$item->product->deleted_at)
                                                                <a href="/{{ $item->product->slug }}.html">
                                                                    <img class="u-img-fluid"
                                                                        style="height: 100%; object-fit: contain;"
                                                                        src="{{ asset($image->thumbnail) }}" alt="">
                                                                </a>
                                                            @else
                                                                <img class="u-img-fluid"
                                                                    style="height: 100%; object-fit: contain;"
                                                                    src="{{ asset($image->thumbnail) }}" alt="">
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="w-r__info">
                                                    <span class="w-r__name">
                                                        @if (!$item->product->deleted_at)
                                                            <a class="product-name"
                                                                href="/{{ $item->product->slug }}.html">{{ $item->product->name }}</a>
                                                        @else
                                                            {{ $item->product->name }}
                                                        @endif
                                                    </span>
                                                    <span class="w-r__category">
                                                        <a
                                                            href="/catalogsearch/result?category_id={{ $item->product->category->id }}">{{ $item->product->category->name }}</a></span>
                                                    <span class="w-r__price">@convertCurrency($item->product->sale_price ?? $item->product->price)
                                                        @if ($item->product->sale_price)
                                                            <span class="w-r__discount">@convertCurrency($item->product->price)</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="w-r__wrap-2">
                                                @if (!$item->product->deleted_at)
                                                    <form method="POST" action="/cart" class="w-r__link btn--e-brand-b-2"
                                                        style="padding: 0;">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $item->product->id }}">
                                                        <input type="hidden" name="action" value="add">
                                                        <button id="wishlist" class="btn btn--e-brand-b-2 wishlist"
                                                            type="submit">ADD TO CART</button>
                                                    </form>
                                                @endif

                                                @if ($item->product->deleted_at)
                                                    <p class="u-s-m-b-10" style="color:red">Product does not exist</p>
                                                @endif

                                                <form action="" method="post"
                                                    class="w-r__link btn--e-transparent-platinum-b-2" style="padding: 0;">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="wishlist_id" value="{{ $item->id }}">
                                                    <button class="pd-detail__click-wrap wishlist"
                                                        type="submit">REMOVE</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="u-s-p-y-120">
            <div class="section__content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 u-s-m-b-30">
                            <div class="empty">
                                <div class="empty__wrap">
                                    <span class="empty__big-text">EMPTY</span>

                                    <span class="empty__text-1">No items found on your wishlist.</span>

                                    <a class="empty__redirect-link btn--e-brand" href="/catalogsearch/result">CONTINUE
                                        SHOPPING</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
