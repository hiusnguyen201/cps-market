@extends('layouts.customer.account')

@if (session('success'))
<input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
<input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@section('content_acc')
<div class="col-lg-9 col-md-12">
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
        <div class="dash__pad-2">
            <h1 class="dash__h1 u-s-m-b-14">My Orders</h1>

            <span class="dash__text u-s-m-b-30">Here you can see all products that have been delivered.</span>
            <form class="m-order u-s-m-b-30">
                <div class="m-order__select-wrapper">

                    <label class="u-s-m-r-8" for="my-order-sort">Show:</label><select class="select-box select-box--primary-style" id="my-order-sort">
                        <option selected>Last 5 orders</option>
                        <option>Last 15 days</option>
                        <option>Last 30 days</option>
                        <option>Last 6 months</option>
                        <option>All Orders</option>
                    </select>
                </div>
            </form>
            <div class="m-order__list">
                @foreach ($orders as $order)
                <div class="m-order__get">
                    <div class="manage-o__header u-s-m-b-30">
                        <div class="dash-l-r">
                            <div>
                                <div class="manage-o__text-2 u-c-secondary">Order #{{ $order->code }}</div>
                                <div class="manage-o__text u-c-silver">Placed on {{ $order->created_at}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="manage-o__description">
                        <div class="description__container">
                            <div class="description__img-wrap">
                                @foreach ($order->products[0]->product->images as $image)
                                @if ($image->pin == 1)
                                <a href="/member/order/{{ $order->id }}">
                                    <img class="u-img-fluid" style="height: 100%; object-fit: contain;" src="{{ asset($image->thumbnail) }}" alt="{{ $order->products[0]->product->name }}">
                                </a>
                                @endif
                                @endforeach

                            </div>

                            <div class="description-title">
                                <a href="/member/order/{{ $order->id }}" style="color: black;">
                                    @foreach ($order->products as $product)
                                    {{ $product->product->name }}
                                    @if (!$loop->last)
                                    ,
                                    @endif
                                    @endforeach
                                </a>
                            </div>

                        </div>
                        <div class="description__info-wrap">
                            @if ($order->status == 0)
                            <div>

                                <span class="manage-o__badge badge--processing">Pending</span>
                            </div>
                            @endif

                            @if ($order->status == 1)
                            <div>

                                <span class="manage-o__badge badge--processing">Confirmed</span>
                            </div>
                            @endif

                            @if ($order->status == 2)
                            <div>

                                <span class="manage-o__badge badge--shipped">Shipping</span>
                            </div>
                            @endif

                            @if ($order->status == 3)
                            <div>

                                <span class="manage-o__badge badge--delivered">Completed</span>
                            </div>
                            @endif

                            @if ($order->status == 4)
                            <div>

                                <span class="manage-o__badge badge--canceled">Canceled</span>
                            </div>
                            @endif

                            <div>

                                <span class="manage-o__text-2 u-c-silver">Quantity:

                                    <span class="manage-o__text-2 u-c-secondary">{{ $order->quantity }}</span></span>
                            </div>
                            <div>

                                <span class="manage-o__text-2 u-c-silver">Total:

                                    <span class="manage-o__text-2 u-c-secondary">@convertCurrency($order->total)</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection