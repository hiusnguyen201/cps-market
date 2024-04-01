@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

    <section>
        <form id="deleteCart" action="/cart" method="post">
            @csrf
            @method('DELETE')
            <input type="hidden" id="cart_id_del" name="id">
        </form>
    </section>

    <div class="app-content">
        <div class="u-s-m-y-60">
            <div class="section__intro u-s-m-b-60">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section__text-wrap">
                                <h1 class="section__heading u-c-secondary">SHOPPING CART&nbsp;<span
                                        class="fas fa-shopping-bag toggle-button-shop"></span></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section__content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                            <div class="table-responsive">

                                @if (!is_null($carts) && !$carts->isEmpty())
                                    <div class="form-check"
                                        style="padding-bottom: 20px;color: rgb(14, 36, 49);font-size: 16px;padding-left: 5px;padding-top: 5px; position: relative;">
                                        <input type="checkbox" class="form-check-input round-checkbox" id="selectAll">
                                        <label class="form-check-label" for="selectAll"
                                            style="position:absolute; top:3px; left: 25px; cursor: pointer;">Select
                                            all</label>
                                    </div>

                                    <table class="table-p">
                                        <tbody>
                                            @foreach ($carts as $cart)
                                                @if ($cart->product->quantity > 0)
                                                    <!--====== Row ======-->
                                                    <tr data-cart-id="{{ $cart->id }}">
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input round-checkbox product-checkbox"
                                                                    name="id" value="{{ $cart->id }}"
                                                                    data-product-price="{{ $cart->product->price }}"
                                                                    data-product-qty="{{ $cart->quantity }}">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="table-p__box">
                                                                <div class="table-p__img-wrap">
                                                                    @foreach ($cart->product->images as $image)
                                                                        @if ($image->pin == 1)
                                                                            <img class="u-img-fluid"
                                                                                style="height: 100%; object-fit: contain;"
                                                                                src="{{ asset('storage/' . $image->thumbnail) }}"
                                                                                alt="">
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            </div>

                                                            <div class="table-p__info">

                                                                <span class="table-p__name">

                                                                    <a
                                                                        href="product-detail.html">{{ $cart->product->name }}</a></span>

                                                                <span class="table-p__category">

                                                                    <a
                                                                        href="shop-side-version-2.html">{{ $cart->product->category->name }}</a></span>

                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>

                                                        <span class="table-p__price"
                                                            style="color: #ff4500">{{ number_format($cart->product->price, 0, ',', '.') }}&nbsp;₫</span>

                                                    </td>

                                                    <td class="customtd3">
                                                        <span
                                                            class="table-p__price">{{ number_format($cart->product->market_price, 0, ',', '.') }}&nbsp;₫</span>
                                                    </td>

                                                    <td>

                                                        <div class="input-counter">

                                                            <span class="input-counter__minus fas fa-minus"></span>
                                                            @php
                                                                $cartQty = 0;
                                                                if ($cart->quantity > $cart->product->quantity) {
                                                                    $cartQty = $cart->product->quantity;
                                                                } else {
                                                                    $cartQty = $cart->quantity;
                                                                }
                                                            @endphp
                                                            <input
                                                                class="input-counter__text input-counter--text-primary-style"
                                                                type="text" name="quantity"
                                                                value="{{ $cartQty }}" data-min="0"
                                                                data-max="{{ $cart->product->quantity }}"
                                                                data-cart-id="{{ $cart->id }}">

                                                            <p id="message" class="text-center"
                                                                style="color: red; font-size: 10px;"></p>

                                                            <span class="input-counter__plus fas fa-plus"></span>

                                                        </div>

                                                    </td>

                                                    <td>
                                                        <div class="table-p__del-wrap text-right">

                                                            <span class="far fa-trash-alt table-p__delete-link"
                                                                style="border: 0; background: none; cursor: pointer;"
                                                                onclick="deleteCart('{{ $cart->id }}')"></span>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <!--====== End - Row ======-->
                                            @endif
                                        @endforeach

                                        @foreach ($carts as $cart)
                                            @if ($cart->product->quantity == 0)
                                                <!--====== Row ======-->
                                                <tr data-cart-id="{{ $cart->id }}">
                                                    <td></td>

                                                    <td>
                                                        <div class="table-p__box">
                                                            <div class="table-p__img-wrap">
                                                                @foreach ($cart->product->images as $image)
                                                                    @if ($image->pin == 1)
                                                                        <img class="u-img-fluid"
                                                                            style="height: 100%; object-fit: contain;"
                                                                            src="{{ asset('storage/' . $image->thumbnail) }}"
                                                                            alt="">
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <div class="table-p__info">

                                                            <span class="table-p__name">

                                                                <a href="product-detail.html"
                                                                    style="text-decoration: line-through;">{{ $cart->product->name }}</a></span>

                                                            <span class="table-p__category">

                                                                <a href="shop-side-version-2.html"
                                                                    style="text-decoration: line-through;">{{ $cart->product->category->name }}</a></span>

                                                        </div>
                                                    </div>
                                                </td>

                                                <td>

                                                    <span class="table-p__price"
                                                        style="color: #ff4500; text-decoration: line-through;">{{ number_format($cart->product->price, 0, ',', '.') }}&nbsp;₫</span>
                                                    <span
                                                        class="table-p__price customtd">{{ number_format($cart->product->market_price, 0, ',', '.') }}&nbsp;₫</span>
                                                </td>

                                                <td class="customtd3">
                                                    <span
                                                        class="table-p__price">{{ number_format($cart->product->market_price, 0, ',', '.') }}&nbsp;₫</span>
                                                </td>

                                                <td>
                                                    <div class="input-counter">

                                                        <p id="message" class="text-center"
                                                            style="color: red; font-size: 15px; font-weight: 600;">
                                                            Out of stock</p>

                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="table-p__del-wrap text-right">

                                                        <span class="far fa-trash-alt table-p__delete-link"
                                                            style="border: 0; background: none; cursor: pointer;"
                                                            onclick="deleteCart('{{ $cart->id }}')"></span>
                                                    </div>
                                                </td>

                                            </tr>
                                            <!--====== End - Row ======-->
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="route-box">
                        <div class="route-box__g1">

                            <a class="route-box__link" href="/"><i class="fas fa-long-arrow-alt-left"></i>

                                <span>CONTINUE SHOPPING</span></a>
                        </div>

                        <div class="route-box__g2" style="display:flex">
                            <form class="form-delete-all" action="" method="POST">
                                <input type="hidden" name="_method" value="delete">
                                <button style="border: none;cursor: pointer;" class="route-box__link"
                                    type="submit"><i class="fas fa-trash"></i>DELETE
                                    SELECTED</button>
                                @csrf
                            </form>

                            <form class="form-update-all" action="" method="POST">
                                <input type="hidden" name="_method" value="patch">
                                <button style="border: none;cursor: pointer;" class="route-box__link"
                                    type="submit"><i class="fas fa-sync"></i>UPDATE</button>
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="u-s-p-b-60">
    <div class="section__content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                    <form class="f-cart">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 u-s-m-b-30">
                                <div class="f-cart__pad-box">
                                    <div class="u-s-m-b-30">
                                        <table class="f-cart__table">
                                            <tbody>
                                                <tr>
                                                    <td>SHIPPING</td>
                                                    <td id="shippingDisplay">0&nbsp;₫</td>
                                                </tr>
                                                <tr>
                                                    <td>SUBTOTAL</td>
                                                    <td id="subPriceDisplay">0&nbsp;₫</td>
                                                </tr>
                                                <tr>
                                                    <td>GRAND TOTAL</td>
                                                    <td id="totalPriceDisplay">0&nbsp;₫</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <button class="btn btn--e-brand-b-2" type="submit"> PROCEED TO
                                            CHECKOUT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Content ======-->
</div>
@else
<div class="alert alert-warning text-center" style="margin-bottom: 50px;" role="alert">
    Your shopping cart is empty ... <span style='font-size:20px;'>&#128577;</span>

    <div style="padding: 20px;" class="buynow">
        <a href="/" style="color: black; font-weight: 600;">
            <svg fill="#000000" width="32px" height="32px" viewBox="0 0 512 512"
                xmlns="http://www.w3.org/2000/svg" transform="rotate(90)matrix(1, 0, 0, 1, 0, 0)">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC"
                    stroke-width="7.168000000000001"></g>
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
</div>
</div>
</div>
</div>
</div>

@endif

<script src="{{ asset('custom/js/cart.js') }}"></script>
@endsection
