@extends('layouts.customer.account')

@if (session('success'))
<input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
<input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@section('content_acc')
<div class="col-lg-9 col-md-12">
    <h1 class="dash__h1 u-s-m-b-30">Order Details</h1>
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
        <div class="dash__pad-2">
            <div class="dash-l-r">
                <div>
                    <div class="manage-o__text-2 u-c-secondary">Order #{{ $order->id }}</div>
                    <div class="manage-o__text u-c-silver">Placed on {{ $order->created_at }}</div>
                </div>
                <div>
                    <div class="manage-o__text-2 u-c-silver">Total:

                        <span class="manage-o__text-2 u-c-secondary">@convertCurrency($order->total)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
        <div class="dash__pad-2">
            <div class="manage-o">
                <div class="manage-o__header u-s-m-b-30">
                    <div class="manage-o__icon"><i class="fas fa-box u-s-m-r-5"></i>

                        <span class="manage-o__text">Package 1</span>
                    </div>
                </div>
                <div class="dash-l-r">

                    <div class="manage-o__text u-c-secondary">@if ($order->status == 3){{ $order->updated_at }}@endif</div>

                    <div class="manage-o__icon"><i class="fas fa-truck u-s-m-r-5"></i>

                        <span class="manage-o__text">Standard</span>
                    </div>
                </div>
                <div class="manage-o__timeline">
                    <div class="timeline-row">
                        @if ( $order->status != 4 )
                        <div class="col-lg-3 u-s-m-b-30">
                            <div class="timeline-step">
                                <div class="timeline-l-i timeline-l-i--finish">

                                    <span class="timeline-circle"></span>
                                </div>

                                <span class="timeline-text">Pending</span>
                            </div>
                        </div>
                        <div class="col-lg-3 u-s-m-b-30">
                            <div class="timeline-step">
                                <div class="timeline-l-i {{ $order->status >= 1 ? 'timeline-l-i--finish' : '' }}">

                                    <span class="timeline-circle"></span>
                                </div>

                                <span class="timeline-text">Confirmed</span>
                            </div>
                        </div>
                        <div class="col-lg-3 u-s-m-b-30">
                            <div class="timeline-step">
                                <div class="timeline-l-i {{ $order->status >= 2 ? 'timeline-l-i--finish' : '' }}">

                                    <span class="timeline-circle"></span>
                                </div>

                                <span class="timeline-text">Shipping</span>
                            </div>
                        </div>
                        <div class="col-lg-3 u-s-m-b-30">
                            <div class="timeline-step {{ $order->status = 3 ? 'timeline-l-i--finish' : '' }}">
                                <div class="timeline-l-i">

                                    <span class="timeline-circle"></span>
                                </div>

                                <span class="timeline-text">Completed</span>
                            </div>
                        </div>
                        @else
                        <div class="col-lg-12 u-s-m-b-30">
                            <div class="timeline-step">
                                <div class="timeline-l-i timeline-l-i--finish">

                                    <span class="timeline-circle"></span>
                                </div>

                                <span class="timeline-text">Canceled</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @foreach ($order_Products as $order_Product)
                <div class="manage-o__description">
                    <div class="description__container">
                        <div class="description__img-wrap">
                            @foreach ($order_Product->product->images as $image)
                            @if ($image->pin == 1)
                            <a href="/{{ $order_Product->product->category->slug }}/{{ $order_Product->product->brand->slug }}/{{ $order_Product->product->slug }}.html">
                                <img class="u-img-fluid" style="height: 100%; object-fit: contain;" src="{{ asset($image->thumbnail) }}" alt="{{ $order_Product->product->name }}">
                            </a>
                            @endif
                            @endforeach
                        </div>

                        <div class="description-title"><a href="/{{ $order_Product->product->category->slug }}/{{ $order_Product->product->brand->slug }}/{{ $order_Product->product->slug }}.html">{{ $order_Product->product->name }}</a></div>
                    </div>
                    <div class="description__info-wrap">
                        <div>

                            <span class="manage-o__text-2 u-c-silver">Quantity:

                                <span class="manage-o__text-2 u-c-secondary">{{ $order_Product->quantity }}</span></span>
                        </div>
                        <div>

                            <span class="manage-o__text-2 u-c-silver">Total:

                                <span class="manage-o__text-2 u-c-secondary">@convertCurrency($order_Product->sale_price)</span></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="dash__box dash__box--bg-white dash__box--shadow u-s-m-b-30">
                <div class="dash__pad-3">
                    <h2 class="dash__h2 u-s-m-b-8">Shipping Address</h2>
                    <h2 class="dash__h2 u-s-m-b-8">{{ $order->shipping_address->order->customer->name}}</h2>

                    <span class="dash__text-2">4247 Ashford Drive Virginia - VA-20006 - USA</span>

                    <span class="dash__text-2">{{ $order->shipping_address->order->customer->phone}}</span>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="dash__box dash__box--bg-white dash__box--shadow u-h-100">
                <div class="dash__pad-3">
                    <h2 class="dash__h2 u-s-m-b-8">Total Summary</h2>
                    <div class="dash-l-r u-s-m-b-8">
                        <div class="manage-o__text-2 u-c-secondary">Subtotal</div>

                        <div class="manage-o__text-2 u-c-secondary">@convertCurrency($order_Product->order->sub_total)</div>
                    </div>
                    <div class="dash-l-r u-s-m-b-8">
                        <div class="manage-o__text-2 u-c-secondary">Shipping Fee</div>
                        <div class="manage-o__text-2 u-c-secondary">{{ $order_Product->order->shipping_fee == 0 ? 'FREE' : convertCurrency($order_Product->order->shipping_fee) }}</div>
                    </div>
                    <div class="dash-l-r u-s-m-b-8">
                        <div class="manage-o__text-2 u-c-secondary">Total</div>
                        <div class="manage-o__text-2 u-c-secondary">@convertCurrency($order_Product->order->total)</div>
                    </div>

                    @if ($order_Product->order->payment_method == 0)
                    <span class="dash__text-2">Paid by Cash on Delivery</span>
                    @endif

                    @if ($order_Product->order->payment_method == 1)
                    <span class="dash__text-2">Paid by Online Payment</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection