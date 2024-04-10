@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

    <div class="u-s-p-y-60">
        <div class="section__content">
            <div class="container">
                <div class="checkout-f">
                    <div class="row" style="justify-content: center">
                        <div class="col-lg-8">
                            @if ($statusOrderPayment)
                                <div class="alert alert-success">
                                    <span>PLACE ORDER SUCCESS</span>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    <span>PLACE ORDER FAILED</span>
                                    <p>Please check your order & payment information again</p>
                                </div>
                            @endif

                            <div class="o-summary">
                                <h2 class="checkout-f__h2" style="margin: 0">ORDER INFORMATION</h2>
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__box">
                                        <table class="o-summary__table">
                                            <tbody>
                                                <tr>
                                                    <td>Order Code</td>
                                                    <td><span>{{ $order->code }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Quantity</td>
                                                    <td><span>{{ $order->quantity }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Total</td>
                                                    <td><span>@convertCurrency($order->sub_total)</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Method</td>
                                                    <td>
                                                        <span>
                                                            @if (config('constants.payment_method') && count(config('constants.payment_method')))
                                                                @foreach (config('constants.payment_method') as $payment_method)
                                                                    @if ($order->payment_method == $payment_method['value'])
                                                                        <span>{{ $payment_method['name'] }}</span>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Grand Total</td>
                                                    <td><span>@convertCurrency($order->total)</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="o-summary">
                                <h2 class="checkout-f__h2" style="margin: 0">CUSTOMER INFORMATION</h2>
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__box">
                                        <table class="o-summary__table">
                                            <tbody>
                                                <tr>
                                                    <td>Name</td>
                                                    <td><span>{{ $order->customer->name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td><span>{{ $order->customer->phone }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td><span>{{ $order->customer->email }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td>
                                                        <input hidden type="text" id="wardName" disabled
                                                            data="{{ $order->shipping_address->ward }}">
                                                        <input hidden type="text" id="districtName" disabled
                                                            data="{{ $order->shipping_address->district }}">
                                                        <input hidden id="provinceName" disabled
                                                            data='{{ $order->shipping_address->province }}' type="text">
                                                        <span
                                                            id="addressShipping">{{ $order->shipping_address->address }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="o-summary">
                                <div class="o-summary__section u-s-m-b-30">
                                    <div class="o-summary__item-wrap gl-scroll">
                                        @if ($order->products)
                                            @foreach ($order->products as $order_product)
                                                <div class="o-card">
                                                    <div class="o-card__flex">
                                                        <div class="o-card__img-wrap">
                                                            @foreach ($order_product->product->images as $image)
                                                                @if ($image->pin == 1)
                                                                    <a
                                                                        href="/{{ $order_product->product->category->slug }}/{{ $order_product->product->brand->slug }}/{{ $order_product->product->slug }}.html"><img
                                                                            class="u-img-fluid"
                                                                            style="height: 100%; object-fit: contain;"
                                                                            src="{{ asset($image->thumbnail) }}"
                                                                            alt="{{ $order_product->product->name }}"></a>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="o-card__info-wrap">
                                                            <span class="o-card__name">
                                                                <a
                                                                    href="/Smartphone0/Brand0/Product-13.html">{{ $order_product->product->name }}</a></span>
                                                            <span class="product-bs__price">@convertCurrency($order_product->product->sale_price ?? $order_product->product->price)
                                                                @if ($order_product->product->sale_price)
                                                                    <span
                                                                        class="product-bs__discount">@convertCurrency($order_product->product->price)</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <span style="font-size: 14px; color:#333333;font-weight: 600;">Quantity:
                                                        <span
                                                            style="color: #ff4500">&nbsp;{{ $order_product->quantity }}</span></span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('cart.index') }}" class="btn btn--e-transparent-brand-b-2"
                                style="width: 100%; display:block;text-align:center;line-height:1;"
                                fdprocessedid="gw2uog">GO BACK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
