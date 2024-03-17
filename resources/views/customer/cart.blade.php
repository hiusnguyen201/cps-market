@extends('layouts.customer.index')

@section('content')
<div class="app-content">

    <!--====== Section 1 ======-->

    <!--====== End - Section 1 ======-->


    <!--====== Section 2 ======-->
    <div class="u-s-p-b-60">

        <!--====== Section Intro ======-->
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
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                        <div class="table-responsive">

                            @if ($carts->isEmpty())
                            <div class="alert alert-warning" role="alert">
                                Your cart is empty.
                            </div>
                            @else
                            <table class="table-p">

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                    <label class="form-check-label" for="selectAll">Select all</label>
                                </div>



                                <tbody>

                                    @php
                                    $totalPrice = 0;
                                    @endphp

                                    @foreach($carts as $cart)

                                    <!--====== Row ======-->
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="id" value="{{ $cart->id }}">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="table-p__box">
                                                <div class="table-p__img-wrap">

                                                    <img class="u-img-fluid" src="{{ asset('images/') }}" alt="">
                                                </div>
                                                <div class="table-p__info">

                                                    <span class="table-p__name">

                                                        <a href="product-detail.html">{{ $cart->product->name }}</a></span>

                                                    <span class="table-p__category">

                                                        <a href="shop-side-version-2.html">Electronics</a></span>
                                                    <ul class="table-p__variant-list">
                                                        <li>

                                                            <span>Size: 22</span>
                                                        </li>
                                                        <li>

                                                            <span>Color: Red</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="table-p__price" style="color: #d70018; font-size: 17px;">{{ $cart->product->price }}$</span>
                                        </td>

                                        <td>
                                            <span class="table-p__price" style="color: #707070; font-size: 14px; text-decoration: line-through;">{{ $cart->product->market_price }}$</span>
                                        </td>

                                        <td>
                                            <div class="table-p__input-counter-wrap">

                                                <!--====== Input Counter ======-->
                                                <div class="input-counter">

                                                    <a href="/cart/{{ $cart->product->id }}" class="input-counter__minus fas fa-minus"></a>

                                                    <input class="input-counter__text input-counter--text-primary-style" type="text" value="{{ $cart->quantity }}" data-min="1" data-max="1000">

                                                    <a href="cart/product/{{ $cart->product->id }}" class="input-counter__plus fas fa-plus"></a>
                                                </div>
                                                <!--====== End - Input Counter ======-->
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-p__del-wrap">

                                                <form action="/cart/{{ $cart->id }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button style="border: 0; background: none; cursor: pointer;" class="far fa-trash-alt table-p__delete-link" type="submit"></button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    <!--====== End - Row ======-->

                                    @php
                                    $totalPrice = $totalPrice + $cart->price;
                                    @endphp

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="col-lg-12">
                        <div class="route-box">
                            <div class="route-box__g1">

                                <a class="route-box__link" href="shop-side-version-2.html"><i class="fas fa-long-arrow-alt-left"></i>

                                    <span>CONTINUE SHOPPING</span></a>
                            </div>
                            <div class="route-box__g2">

                                <a class="route-box__link" href="cart.html"><i class="fas fa-trash"></i>

                                    <span>CLEAR CART</span></a>

                                <a class="route-box__link" href="cart.html"><i class="fas fa-sync"></i>

                                    <span>UPDATE CART</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 2 ======-->


    <!--====== Section 3 ======-->
    <div class="u-s-p-b-60">

        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 u-s-m-b-30">
                        <form class="f-cart">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 u-s-m-b-30">

                                </div>
                                <div class="col-lg-4 col-md-6 u-s-m-b-30">

                                </div>
                                <div class="col-lg-4 col-md-6 u-s-m-b-30">
                                    <div class="f-cart__pad-box">
                                        <div class="u-s-m-b-30">
                                            <table class="f-cart__table">
                                                <tbody>
                                                    <tr>
                                                        <td>SHIPPING</td>
                                                        <td>$4.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TAX</td>
                                                        <td>$0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>SUBTOTAL</td>
                                                        <td>sdf66251$</td>
                                                    </tr>
                                                    <tr>
                                                        <td>GRAND TOTAL</td>
                                                        <td>${{$totalPrice}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>

                                            <button class="btn btn--e-brand-b-2" type="submit"> PROCEED TO CHECKOUT</button>
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
    @endif
    <!--====== End - Section 3 ======-->
</div>
@endsection