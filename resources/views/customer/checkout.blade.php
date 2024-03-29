@extends('layouts.customer.index')

@section('content')
<div class="app-content">
    
            <!--====== Section 1 ======-->
            
            <!--====== End - Section 1 ======-->


            <!--====== Section 2 ======-->
            
                <!--====== Section Content ======-->
                
                <!--====== End - Section Content ======-->
          
            <!--====== End - Section 2 ======-->


            <!--====== Section 3 ======-->
            <div class="u-s-p-b-60">

                <!--====== Section Content ======-->
                <div class="section__content">
                    <div class="container">
                        <div class="checkout-f">
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <h1 class="checkout-f__h1">ORDER SUMMARY</h1>

                                    <!--====== Order Summary ======-->
                                    <div class="o-summary">
                                        <div class="o-summary__section u-s-m-b-30">
                                            <div class="o-summary__item-wrap gl-scroll">
                                                <div class="o-card">
                                                    <div class="o-card__flex">
                                                        <div class="o-card__img-wrap">

                                                            <img class="u-img-fluid" src="images/product/electronic/product3.jpg" alt=""></div>
                                                        <div class="o-card__info-wrap">

                                                            <span class="o-card__name">

                                                                <a href="product-detail.html">Yellow Wireless Headphone</a></span>

                                                            <span class="o-card__quantity">Quantity x 1</span>

                                                            <span class="o-card__price">$150.00</span></div>
                                                    </div>

                                                    <a class="o-card__del far fa-trash-alt"></a>
                                                </div>
                                                <div class="o-card">
                                                    <div class="o-card__flex">
                                                        <div class="o-card__img-wrap">

                                                            <img class="u-img-fluid" src="images/product/electronic/product18.jpg" alt=""></div>
                                                        <div class="o-card__info-wrap">

                                                            <span class="o-card__name">

                                                                <a href="product-detail.html">Nikon DSLR Camera 4k</a></span>

                                                            <span class="o-card__quantity">Quantity x 1</span>

                                                            <span class="o-card__price">$150.00</span></div>
                                                    </div>

                                                    <a class="o-card__del far fa-trash-alt"></a>
                                                </div>
                                                <div class="o-card">
                                                    <div class="o-card__flex">
                                                        <div class="o-card__img-wrap">

                                                            <img class="u-img-fluid" src="images/product/women/product8.jpg" alt=""></div>
                                                        <div class="o-card__info-wrap">

                                                            <span class="o-card__name">

                                                                <a href="product-detail.html">New Dress D Nice Elegant</a></span>

                                                            <span class="o-card__quantity">Quantity x 1</span>

                                                            <span class="o-card__price">$150.00</span></div>
                                                    </div>

                                                    <a class="o-card__del far fa-trash-alt"></a>
                                                </div>
                                                <div class="o-card">
                                                    <div class="o-card__flex">
                                                        <div class="o-card__img-wrap">

                                                            <img class="u-img-fluid" src="images/product/men/product8.jpg" alt=""></div>
                                                        <div class="o-card__info-wrap">

                                                            <span class="o-card__name">

                                                                <a href="product-detail.html">New Fashion D Nice Elegant</a></span>

                                                            <span class="o-card__quantity">Quantity x 1</span>

                                                            <span class="o-card__price">$150.00</span></div>
                                                    </div>

                                                    <a class="o-card__del far fa-trash-alt"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="o-summary__section u-s-m-b-30">
                                            <div class="o-summary__box">
                                                <h1 class="checkout-f__h1">SHIPPING & BILLING</h1>
                                                <div class="ship-b">

                                                    <span class="ship-b__text">Ship to:</span>
                                                    <div class="ship-b__box u-s-m-b-10">
                                                        <p class="ship-b__p">4247 Ashford Drive Virginia VA-20006 USA (+0) 900901904</p>

                                                        <a class="ship-b__edit btn--e-transparent-platinum-b-2" data-modal="modal" data-modal-id="#edit-ship-address">Edit</a>
                                                    </div>
                                                    <div class="ship-b__box">

                                                        <span class="ship-b__text">Bill to default billing address</span>

                                                        <a class="ship-b__edit btn--e-transparent-platinum-b-2" data-modal="modal" data-modal-id="#edit-ship-address">Edit</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="o-summary__section u-s-m-b-30">
                                            <div class="o-summary__box">
                                                <table class="o-summary__table">
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
                                                            <td>$379.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>GRAND TOTAL</td>
                                                            <td>$379.00</td>
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

                                                                <label class="radio-box__label" for="cash-on-delivery">Cash on Delivery</label></div>
                                                        </div>
                                                        <!--====== End - Radio Box ======-->

                                                        <span class="gl-text u-s-m-t-6">Pay Upon Cash on delivery. (This service is only available for some countries)</span>
                                                    </div>
                                                    <div class="u-s-m-b-10">

                                                        <!--====== Radio Box ======-->
                                                        <div class="radio-box">

                                                            <input type="radio" id="direct-bank-transfer" name="payment">
                                                            <div class="radio-box__state radio-box__state--primary">

                                                                <label class="radio-box__label" for="direct-bank-transfer">Direct Bank Transfer</label></div>
                                                        </div>
                                                        <!--====== End - Radio Box ======-->

                                                        <span class="gl-text u-s-m-t-6">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</span>
                                                    </div>
                                                    <div class="u-s-m-b-10">

                                                        <!--====== Radio Box ======-->
                                                        <div class="radio-box">

                                                            <input type="radio" id="pay-with-check" name="payment">
                                                            <div class="radio-box__state radio-box__state--primary">

                                                                <label class="radio-box__label" for="pay-with-check">Pay With Check</label></div>
                                                        </div>
                                                        <!--====== End - Radio Box ======-->

                                                        <span class="gl-text u-s-m-t-6">Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</span>
                                                    </div>
                                                    <div class="u-s-m-b-10">

                                                        <!--====== Radio Box ======-->
                                                        <div class="radio-box">

                                                            <input type="radio" id="pay-with-card" name="payment">
                                                            <div class="radio-box__state radio-box__state--primary">

                                                                <label class="radio-box__label" for="pay-with-card">Pay With Credit / Debit Card</label></div>
                                                        </div>
                                                        <!--====== End - Radio Box ======-->

                                                        <span class="gl-text u-s-m-t-6">International Credit Cards must be eligible for use within the United States.</span>
                                                    </div>
                                                    <div class="u-s-m-b-10">

                                                        <!--====== Radio Box ======-->
                                                        <div class="radio-box">

                                                            <input type="radio" id="pay-pal" name="payment">
                                                            <div class="radio-box__state radio-box__state--primary">

                                                                <label class="radio-box__label" for="pay-pal">Pay Pal</label></div>
                                                        </div>
                                                        <!--====== End - Radio Box ======-->

                                                        <span class="gl-text u-s-m-t-6">When you click "Place Order" below we'll take you to Paypal's site to set up your billing information.</span>
                                                    </div>
                                                    <div class="u-s-m-b-15">

                                                        <!--====== Check Box ======-->
                                                        <div class="check-box">

                                                            <input type="checkbox" id="term-and-condition">
                                                            <div class="check-box__state check-box__state--primary">

                                                                <label class="check-box__label" for="term-and-condition">I consent to the</label></div>
                                                        </div>
                                                        <!--====== End - Check Box ======-->

                                                        <a class="gl-link">Terms of Service.</a>
                                                    </div>
                                                    <div>

                                                        <button class="btn btn--e-brand-b-2" type="submit">PLACE ORDER</button></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--====== End - Order Summary ======-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--====== End - Section Content ======-->
            </div>
            <!--====== End - Section 3 ======-->
        </div>

@endsection