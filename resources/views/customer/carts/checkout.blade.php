@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

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
                                    <a href="{{ route('cart.index') }}">Cart</a>
                                </li>
                                <li class="is-marked">
                                    <a href="{{ route('cart.checkout') }}">Checkout</a>
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
                    <div class="row" style="justify-content: center">
                        <div class="col-lg-10">
                            <h1 class="checkout-f__h1">ORDER SUMMARY</h1>
                            <div class="o-summary">
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__item-wrap gl-scroll">
                                        @if (Auth::user()->carts && count(Auth::user()->carts))
                                            @foreach (Auth::user()->carts as $cart)
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
                                                            <span class="o-card__price">@convertCurrency($cart->product->sale_price ?? $cart->product->price)</span>
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('cart.delete') }}" method="post">
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
                                <form action="" id="payment-info_form" method="post">
                                    @csrf
                                    <div class="o-summary__section u-s-m-b-30">
                                        <div class="o-summary__box">
                                            <h1 class="checkout-f__h1">CUSTOMER INFORMATION</h1>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="ship-b">
                                                        <div class="u-s-m-b-30">
                                                            <label class="gl-label">NAME *</label>
                                                            <input name="customer_name" value="{{ Auth::user()->name }}"
                                                                fdprocessedid="mf89an"
                                                                class="input-text input-text--primary-style" type="text"
                                                                placeholder="Name...">

                                                            @error('customer_name')
                                                                <span style="color: red">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="ship-b">
                                                        <div class="u-s-m-b-30">
                                                            <label class="gl-label">PHONE *</label>
                                                            <input name="customer_phone" fdprocessedid="mf89an"
                                                                value="{{ Auth::user()->phone }}"
                                                                class="input-text input-text--primary-style" type="tel"
                                                                placeholder="Phone...">

                                                            @error('customer_phone')
                                                                <span style="color: red">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="ship-b">
                                                        <div class="u-s-m-b-30">
                                                            <label class="gl-label">EMAIL *</label>
                                                            <input name="customer_email" fdprocessedid="mf89an"
                                                                value="{{ Auth::user()->email }}"
                                                                class="input-text input-text--primary-style" type="email"
                                                                placeholder="Email...">

                                                            @error('customer_email')
                                                                <span style="color: red">{{ $message }}</span>
                                                            @enderror
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
                                                            <select name="province" old-data="{{ old('province') }}"
                                                                class="select-box select-box--primary-style"
                                                                id="province" fdprocessedid="mf89an">
                                                            </select>

                                                            @error('province')
                                                                <span style="color: red">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="ship-b">
                                                        <div class="u-s-m-b-30">
                                                            <label class="gl-label" for="district">DISTRICT *</label>
                                                            <select name="district" old-data="{{ old('district') }}"
                                                                class="select-box select-box--primary-style"
                                                                id="district" fdprocessedid="mf89an">
                                                            </select>

                                                            @error('district')
                                                                <span style="color: red">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="ship-b">
                                                        <div class="u-s-m-b-30">
                                                            <label class="gl-label">WARD *</label>
                                                            <select id="ward" name="ward"
                                                                old-data="{{ old('ward') }}"
                                                                class="select-box select-box--primary-style"
                                                                fdprocessedid="mf89an">
                                                            </select>

                                                            @error('ward')
                                                                <span style="color: red">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="ship-b">
                                                        <div class="u-s-m-b-30">
                                                            <label class="gl-label">ADDRESS *</label>
                                                            <input name="address" fdprocessedid="mf89an"
                                                                class="input-text input-text--primary-style"
                                                                type="text" placeholder="Address..."
                                                                value="{{ old('address') }}">

                                                            @error('address')
                                                                <span style="color: red">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="ship-b">
                                                        <div class="u-s-m-b-30">
                                                            <label class="gl-label">NOTE</label>
                                                            <input name="note" fdprocessedid="mf89an"
                                                                class="input-text input-text--primary-style"
                                                                type="text" placeholder="Note..."
                                                                value="{{ old('note') }}">

                                                            @error('note')
                                                                <span style="color: red">{{ $message }}</span>
                                                            @enderror
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
                                                        <td>SUBTOTAL</td>
                                                        <td><span>@convertCurrency($totalPrice)</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>SHIPPING</td>
                                                        <td><span>@convertShippingFee(config('constants.shipping_fee'))</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>GRAND TOTAL</td>
                                                        <td><span>@convertCurrency($totalPrice + config('constants.shipping_fee'))</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="o-summary__section u-s-m-b-30">
                                        <div class="o-summary__box">
                                            <h1 class="checkout-f__h1">PAYMENT INFORMATION</h1>
                                            <div class="checkout-f__payment">
                                                @if (config('constants.payment_method'))
                                                    @foreach (config('constants.payment_method') as $method)
                                                        <div class="u-s-m-b-20">
                                                            <div class="radio-box">
                                                                <input
                                                                    {{ old('payment_method') != '' && old('payment_method') == $method['value'] ? 'checked' : '' }}
                                                                    type="radio" name="payment_method"
                                                                    data="{{ $method['redirect'] }}"
                                                                    value="{{ $method['value'] }}">
                                                                <div class="radio-box__state radio-box__state--primary">
                                                                    <label
                                                                        class="radio-box__label">{{ $method['title'] }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @error('payment_method')
                                                    <span style="color: red">{{ $message }}</span>
                                                @enderror

                                                <div>
                                                    <button disabled id="place-order-btn" class="btn btn--e-brand-b-2"
                                                        type="submit">PLACE
                                                        ORDER</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
