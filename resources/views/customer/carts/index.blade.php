@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

    <form id="updateCart" method="post" action="{{ route('cart.update') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="quantity">
        <input type="hidden" name="cart_id">
    </form>

    @if (count($carts))
        <div class="u-s-p-y-60">
            <div class="u-s-p-b-60">
                <div class="section__content">
                    <div class="container">
                        <div class="breadcrumb">
                            <div class="breadcrumb__wrap">
                                <ul class="breadcrumb__list">
                                    <li class="has-separator">
                                        <a href="/">Home</a>
                                    </li>
                                    <li class="is-marked">
                                        <a href="{{ route('cart.index') }}">Cart</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="u-s-m-b-60">
                <div class="section__intro">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section__text-wrap">
                                    <h1 class="section__heading u-c-secondary">SHOPPING CART</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section__content">
                <div class="container u-s-m-b-30">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table-responsive mb-3">
                                <table class="table-p">
                                    <tbody>
                                        @foreach ($carts as $cart)
                                            @if ($cart->product)
                                                <tr data-cart-id="{{ $cart->id }}">
                                                    <td>
                                                        <div class="table-p__box">
                                                            <div class="table-p__img-wrap">
                                                                @foreach ($cart->product->images as $image)
                                                                    @if ($image->pin == 1)
                                                                        <a
                                                                            href="/{{ $cart->product->category->slug }}/{{ $cart->product->brand->slug }}/{{ $cart->product->slug }}.html"><img
                                                                                class="u-img-fluid"
                                                                                style="height: 100%; object-fit: contain;"
                                                                                src="{{ asset($image->thumbnail) }}"
                                                                                alt="{{ $cart->product->name }}"></a>
                                                                    @endif
                                                                @endforeach
                                                            </div>

                                                            <div class="table-p__info">
                                                                <span class="table-p__name">
                                                                    <a
                                                                        href="/{{ $cart->product->category->slug }}/{{ $cart->product->brand->slug }}/{{ $cart->product->slug }}.html">{{ $cart->product->name }}</a></span>
                                                                <span class="table-p__category">
                                                                    <a
                                                                        href="/catalogsearch/result?category_id={{ $cart->product->category->id }}">{{ $cart->product->category->name }}</a></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <span class="table-p__price"
                                                                style="color: #ff4500;font-size: 16px">@convertCurrency($cart->product->sale_price ?? $cart->product->price)</span>
                                                            @if ($cart->product->sale_price)
                                                                <span class="table-p__price"
                                                                    style="text-decoration:line-through">@convertCurrency($cart->product->price)</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="customtd3">

                                                    </td>
                                                    <td>
                                                        <div class="input-counter">
                                                            <span class="input-counter__minus fas fa-minus"></span>
                                                            <input
                                                                class="input-counter__text input-counter--text-primary-style"
                                                                type="text" name="quantity"
                                                                value="{{ $cart->quantity }}" data-min="1"
                                                                data-max="{{ $cart->product->quantity + 1 }}"
                                                                data-cart-id="{{ $cart->id }}"
                                                                onchange="updateQuantity(this)">

                                                            <span class="input-counter__plus fas fa-plus"></span>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <form class="text-right" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="cart_id"
                                                                value="{{ $cart->id }}">
                                                            <button class="table-p__delete-link" type="submit"
                                                                style="border: 0; background: none; cursor: pointer;">
                                                                <i class="far fa-trash-alt "></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section__content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="f-cart">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="f-cart__pad-box">
                                            <div class="u-s-m-b-30">
                                                <table class="f-cart__table">
                                                    <tbody>
                                                        <tr>
                                                            <td>GRAND TOTAL</td>
                                                            <td id="totalPriceDisplay">
                                                                @convertCurrency($totalPrice)
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div>
                                                <a style="display: block; text-align:center"
                                                    href="{{ route('cart.checkout') }}"
                                                    class="btn btn--e-brand-b-2">PROCEED TO
                                                    CHECKOUT</a>
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
    @else
        <div class="u-s-p-y-120">
            <div class="section__content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 u-s-m-b-30">
                            <div class="empty">
                                <div class="empty__wrap">

                                    <span class="empty__big-text">EMPTY</span>

                                    <span class="empty__text-1">No items found on your cart.</span>

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


    @if (!Auth::user())
        <div class="modal fade new-l" id="newsletter-modal" style="padding: 0px">
            <div class="modal-dialog modal-dialog-centered" style="margin: auto;">
                <div class="modal-content modal--shadow">
                    <div class="modal-body">
                        <div class="new-l__section u-s-m-y-20">
                            <div class="u-s-m-b-16 new-l--center">
                                <h3 class="new-l__h3" style="color:#ff4500">Member</h3>
                            </div>
                            <div class="u-s-m-b-24 new-l--center">
                                <p class="new-l__p1"
                                    style="font-size: 15px;font-weight: 700;line-height: 20px;padding: 1px;color: #4a4a4a">
                                    Please log in to your Member account to make payments more easily.
                                </p>
                            </div>
                            <div class="row u-s-m-x-0 l-f-o" style="border: none">
                                <div class="col-6 u-s-p-x-12">
                                    <a href="/auth/register" style="display: block"
                                        class="btn btn--e-transparent-brand-b-2">Sign
                                        up</a>
                                </div>
                                <div class="col-6 u-s-p-x-12">
                                    <a href="/auth/login" style="display: block" class="btn btn--e-brand-b-2">Sign
                                        in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
