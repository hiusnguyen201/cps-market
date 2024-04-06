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

    <div class="u-s-p-y-60 u-s-p-t-60">
        <div class="section__content">
            <div class="container">
                <div class="row">
                    @if (count($wishlists))
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @foreach ($wishlists as $wishlist)
                                <div class="w-r u-s-m-b-30">
                                    <div class="w-r__container">
                                        <div class="w-r__wrap-1">
                                            <div class="w-r__img-wrap">

                                                @foreach ($wishlist->product->images as $image)
                                                    @if ($image->pin == 1)
                                                        <img class="u-img-fluid" style="height: 100%; object-fit: contain;"
                                                            src="{{ asset($image->thumbnail) }}" alt="">
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="w-r__info">

                                                <span class="w-r__name">

                                                    <a
                                                        href="/{{ $wishlist->product->category->slug }}/{{ $wishlist->product->brand->slug }}/{{ $wishlist->product->slug }}.html">{{ $wishlist->product->name }}</a></span>

                                                <span class="w-r__category">

                                                    <a
                                                        href="/{{ $wishlist->product->category->slug }}.html">{{ $wishlist->product->category->name }}</a></span>

                                                <span
                                                    class="w-r__price">{{ number_format($wishlist->product->sale_price, 0, ',', '.') }}&nbsp;₫

                                                    <span
                                                        class="w-r__discount">{{ number_format($wishlist->product->price, 0, ',', '.') }}&nbsp;₫</span></span>
                                            </div>
                                        </div>
                                        <div class="w-r__wrap-2">

                                            <form method="POST" action="/cart" class="w-r__link btn--e-brand-b-2"
                                                style="padding: 0;">
                                                @csrf
                                                <input type="hidden" name="product_id"
                                                    value="{{ $wishlist->product->id }}">
                                                <input type="hidden" name="action" value="add">
                                                <button id="wishlist" class="btn btn--e-brand-b-2 wishlist"
                                                    type="submit">ADD TO CART</button>
                                            </form>

                                            <a class="w-r__link btn--e-transparent-platinum-b-2"
                                                href="/{{ $wishlist->product->category->slug }}/{{ $wishlist->product->brand->slug }}/{{ $wishlist->product->slug }}.html">VIEW</a>

                                            <form action="" method="post"
                                                class="w-r__link btn--e-transparent-platinum-b-2" style="padding: 0;">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">
                                                <button class="pd-detail__click-wrap wishlist"
                                                    type="submit">REMOVE</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-lg-12 col-md-12 u-s-m-b-30">
                            <div class="empty">
                                <div class="empty__wrap">

                                    <span class="empty__big-text">EMPTY</span>

                                    <span class="empty__text-1">No items found on your wishlist.</span>

                                    <a class="empty__redirect-link btn--e-brand" href="/">CONTINUE SHOPPING</a>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
