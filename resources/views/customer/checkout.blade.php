@extends('layouts.customer.index')

@section('content')
    <div class="u-s-p-y-60">
        <div class="u-s-p-b-30">
            <div class="section__content">
                <div class="container">
                    <div class="breadcrumb">
                        <div class="breadcrumb__wrap">
                            <ul class="breadcrumb__list">
                                <li class="has-separator">
                                    <a href="/">Home</a>
                                </li>
                                <li class="has-separator">
                                    <a href="/cart">Cart</a>
                                </li>
                                <li class="is-marked">
                                    <a href="/cart/checkout">Checkout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section__content">
            <div class="container">
                <div class="checkout-f">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="checkout-f__h1">ORDER SUMMARY</h1>
                            <div class="o-summary">
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__item-wrap gl-scroll">
                                        @if (count($carts))
                                            @foreach ($carts as $cart)
                                                <div class="o-card">
                                                    <div class="o-card__flex">
                                                        <div class="o-card__img-wrap">
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
                                                        <div class="o-card__info-wrap">
                                                            <span class="o-card__name">
                                                                <a
                                                                    href="/{{ $cart->product->category->slug }}/{{ $cart->product->brand->slug }}/{{ $cart->product->slug }}.html">{{ $cart->product->name }}</a></span>
                                                            <span class="o-card__quantity">Quantity x
                                                                {{ $cart->quantity }}</span>
                                                            <span
                                                                class="o-card__price">{{ number_format(($cart->product->sale_price ? $cart->product->sale_price : $cart->product->price) * $cart->quantity, 0, ',', '.') }}&nbsp;₫</span>
                                                        </div>
                                                    </div>

                                                    <form action="/cart" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                                        <button type="submit"
                                                            style="background: transparent; border:none; cursor: pointer;">
                                                            <i class="o-card__del far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__box">
                                        <h1 class="checkout-f__h1">CUSTOMER INFORMATION</h1>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="ship-b">
                                                    <div class="u-s-m-b-30">
                                                        <label class="gl-label" for="province">NAME *</label>
                                                        <input disabled name="address" value="{{ $user->name }}"
                                                            fdprocessedid="mf89an"
                                                            class="input-text input-text--primary-style" type="text"
                                                            placeholder="Name...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="ship-b">
                                                    <div class="u-s-m-b-30">
                                                        <label class="gl-label" for="district">PHONE *</label>
                                                        <input disabled name="address" fdprocessedid="mf89an"
                                                            value="{{ $user->phone }}"
                                                            class="input-text input-text--primary-style" type="text"
                                                            placeholder="Phone...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="ship-b">
                                                    <div class="u-s-m-b-30">
                                                        <label class="gl-label" for="ward">EMAIL *</label>
                                                        <input disabled name="address" fdprocessedid="mf89an"
                                                            value="{{ $user->email }}"
                                                            class="input-text input-text--primary-style" type="text"
                                                            placeholder="Email...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__box">
                                        <h1 class="checkout-f__h1">SHIPPING & BILLING</h1>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="ship-b">
                                                    <div class="u-s-m-b-30">
                                                        <label class="gl-label" for="province">PROVINCE *</label>
                                                        <select name="province" class="select-box select-box--primary-style"
                                                            id="province" fdprocessedid="mf89an">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="ship-b">
                                                    <div class="u-s-m-b-30">
                                                        <label class="gl-label" for="district">DISTRICT *</label>
                                                        <select name="district" class="select-box select-box--primary-style"
                                                            id="district" fdprocessedid="mf89an">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="ship-b">
                                                    <div class="u-s-m-b-30">
                                                        <label class="gl-label" for="ward">WARD *</label>
                                                        <select name="ward"
                                                            class="select-box select-box--primary-style" id="ward"
                                                            fdprocessedid="mf89an">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="ship-b">
                                                    <div class="u-s-m-b-30">
                                                        <label class="gl-label" for="ward">ADDRESS *</label>
                                                        <input name="address" fdprocessedid="mf89an"
                                                            class="input-text input-text--primary-style" type="text"
                                                            placeholder="Address...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="ship-b">
                                                    <div class="u-s-m-b-30">
                                                        <label class="gl-label" for="ward">NOTE</label>
                                                        <input name="address" fdprocessedid="mf89an"
                                                            class="input-text input-text--primary-style" type="text"
                                                            placeholder="Note...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__box">
                                        <table class="o-summary__table">
                                            <tbody>
                                                <tr>
                                                    <td>SHIPPING</td>
                                                    <td>Free</td>
                                                </tr>
                                                <tr>
                                                    <td>SUBTOTAL</td>
                                                    <td>{{ number_format($totalPrice, 0, ',', '.') }}&nbsp;₫</td>
                                                </tr>
                                                <tr>
                                                    <td>GRAND TOTAL</td>
                                                    <td>{{ number_format($totalPrice, 0, ',', '.') }}&nbsp;₫</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__box">
                                        <h1 class="checkout-f__h1">PAYMENT INFORMATION</h1>
                                        <form class="checkout-f__payment">
                                            <div class="u-s-m-b-10">

                                                <!--====== Radio Box ======-->
                                                <div class="radio-box">

                                                    <input type="radio" id="cash-on-delivery" name="payment">
                                                    <div class="radio-box__state radio-box__state--primary">

                                                        <label class="radio-box__label" for="cash-on-delivery">Cash on
                                                            Delivery</label>
                                                    </div>
                                                </div>
                                                <!--====== End - Radio Box ======-->

                                                <span class="gl-text u-s-m-t-6">Pay Upon Cash on delivery. (This service is
                                                    only available for some countries)</span>
                                            </div>
                                            <div class="u-s-m-b-10">

                                                <!--====== Radio Box ======-->
                                                <div class="radio-box">

                                                    <input type="radio" id="direct-bank-transfer" name="payment">
                                                    <div class="radio-box__state radio-box__state--primary">

                                                        <label class="radio-box__label" for="direct-bank-transfer">Direct
                                                            Bank Transfer</label>
                                                    </div>
                                                </div>
                                                <!--====== End - Radio Box ======-->

                                                <span class="gl-text u-s-m-t-6">Make your payment directly into our bank
                                                    account. Please use your Order ID as the payment reference. Your order
                                                    will not be shipped until the funds have cleared in our account.</span>
                                            </div>
                                            <div class="u-s-m-b-10">

                                                <!--====== Radio Box ======-->
                                                <div class="radio-box">

                                                    <input type="radio" id="pay-with-check" name="payment">
                                                    <div class="radio-box__state radio-box__state--primary">

                                                        <label class="radio-box__label" for="pay-with-check">Pay With
                                                            Check</label>
                                                    </div>
                                                </div>
                                                <!--====== End - Radio Box ======-->

                                                <span class="gl-text u-s-m-t-6">Please send a check to Store Name, Store
                                                    Street, Store Town, Store State / County, Store Postcode.</span>
                                            </div>
                                            <div class="u-s-m-b-10">

                                                <!--====== Radio Box ======-->
                                                <div class="radio-box">

                                                    <input type="radio" id="pay-with-card" name="payment">
                                                    <div class="radio-box__state radio-box__state--primary">

                                                        <label class="radio-box__label" for="pay-with-card">Pay With
                                                            Credit / Debit Card</label>
                                                    </div>
                                                </div>
                                                <!--====== End - Radio Box ======-->

                                                <span class="gl-text u-s-m-t-6">International Credit Cards must be eligible
                                                    for use within the United States.</span>
                                            </div>
                                            <div class="u-s-m-b-10">

                                                <!--====== Radio Box ======-->
                                                <div class="radio-box">

                                                    <input type="radio" id="pay-pal" name="payment">
                                                    <div class="radio-box__state radio-box__state--primary">

                                                        <label class="radio-box__label" for="pay-pal">Pay Pal</label>
                                                    </div>
                                                </div>
                                                <!--====== End - Radio Box ======-->

                                                <span class="gl-text u-s-m-t-6">When you click "Place Order" below we'll
                                                    take you to Paypal's site to set up your billing information.</span>
                                            </div>
                                            <div class="u-s-m-b-15">

                                                <!--====== Check Box ======-->
                                                <div class="check-box">
                                                    <input type="checkbox" id="term-and-condition">
                                                    <div class="check-box__state check-box__state--primary">

                                                        <label class="check-box__label" for="term-and-condition">I consent
                                                            to the</label>
                                                    </div>
                                                </div>
                                                <!--====== End - Check Box ======-->

                                                <a class="gl-link">Terms of Service.</a>
                                            </div>
                                            <div>
                                                <button id="place-order-btn" class="btn btn--e-brand-b-2"
                                                    type="submit">PLACE
                                                    ORDER</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
