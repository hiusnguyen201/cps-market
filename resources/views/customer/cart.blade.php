@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

    <form id="updateCart" method="post">
        @csrf
        @method('PATCH')
        <input type="hidden" name="quantity">
        <input type="hidden" name="cart_id">
    </form>

    <div class="u-s-p-y-60">
        <div class="section__content">
            <div class="container">
                <div class="breadcrumb">
                    <div class="breadcrumb__wrap">
                        <ul class="breadcrumb__list">
                            <li class="has-separator">
                                <a href="/">Home</a>
                            </li>
                            <li class="is-marked">
                                <a href="/cart">Cart</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="u-s-m-b-60">
        <div class="section__intro u-s-m-b-60">
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

    @if (count($carts))
        <div class="section__content">
            <div class="container u-s-m-b-30">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <table class="table-p">
                                <tbody>
                                    @foreach ($carts as $cart)
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
                                                                href="/{{ $cart->product->category->slug }}">{{ $cart->product->category->name }}</a></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="">
                                                    <span class="table-p__price"
                                                        style="color: #ff4500;font-size: 16px">{{ number_format($cart->product->sale_price, 0, ',', '.') }}&nbsp;₫</span>
                                                    <span class="table-p__price"
                                                        style="text-decoration:line-through">{{ number_format($cart->product->price, 0, ',', '.') }}&nbsp;₫</span>
                                                </div>
                                            </td>
                                            <td class="customtd3">

                                            </td>
                                            <td>
                                                <div class="input-counter">
                                                    <span class="input-counter__minus fas fa-minus"></span>
                                                    <input class="input-counter__text input-counter--text-primary-style"
                                                        type="text" name="quantity" value="{{ $cart->quantity }}"
                                                        data-min="1" data-max="{{ $cart->product->quantity + 1 }}"
                                                        data-cart-id="{{ $cart->id }}" onchange="updateQuantity(this)">

                                                    <span class="input-counter__plus fas fa-plus"></span>
                                                </div>

                                            </td>
                                            <td>
                                                <form class="text-right" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                                    <button class="table-p__delete-link" type="submit"
                                                        style="border: 0; background: none; cursor: pointer;">
                                                        <i class="far fa-trash-alt "></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="u-s-p-b-60">
                <div class="section__content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                                <div class="f-cart">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 u-s-m-b-30">
                                            <div class="f-cart__pad-box">
                                                <div class="u-s-m-b-30">
                                                    <table class="f-cart__table">
                                                        <tbody>
                                                            <tr>
                                                                <td>GRAND TOTAL</td>
                                                                <td id="totalPriceDisplay">
                                                                    {{ number_format($totalPrice, 0, ',', '.') }}&nbsp;₫
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div>
                                                    <a style="display: block; text-align:center" href="/cart/checkout"
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
                <!--====== End - Section Content ======-->
            </div>
        @else
            <div class="text-center" style="margin-bottom: 50px;">
                Your shopping cart is empty ... <span style='font-size:20px;'>&#128577;</span>

                <div style="padding: 20px;" class="buynow">
                    <a href="/" style="color: black; font-weight: 600;">
                        <svg fill="#000000" width="32px" height="32px" viewBox="0 0 512 512"
                            xmlns="http://www.w3.org/2000/svg" transform="rotate(90)matrix(1, 0, 0, 1, 0, 0)">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                stroke="#CCCCCC" stroke-width="7.168000000000001"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M512 199.652c0 23.625-20.65 43.826-44.8 43.826h-99.851c16.34 17.048 18.346 49.766-6.299 70.944 14.288 22.829 2.147 53.017-16.45 62.315C353.574 425.878 322.654 448 272 448c-2.746 0-13.276-.203-16-.195-61.971.168-76.894-31.065-123.731-38.315C120.596 407.683 112 397.599 112 385.786V214.261l.002-.001c.011-18.366 10.607-35.889 28.464-43.845 28.886-12.994 95.413-49.038 107.534-77.323 7.797-18.194 21.384-29.084 40-29.092 34.222-.014 57.752 35.098 44.119 66.908-3.583 8.359-8.312 16.67-14.153 24.918H467.2c23.45 0 44.8 20.543 44.8 43.826zM96 200v192c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V200c0-13.255 10.745-24 24-24h48c13.255 0 24 10.745 24 24zM68 368c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20z">
                                </path>
                            </g>
                        </svg>
                        <div>BUY NOW</div>
                    </a>
                </div>
            </div>
    @endif
@endsection
