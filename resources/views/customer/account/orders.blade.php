@extends('layouts.customer.account')

@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@section('content_acc')
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
        <div class="dash__pad-2">
            <h1 class="dash__h1 u-s-m-b-14">My Orders</h1>

            <span class="dash__text u-s-m-b-30">Here you can see all products that have been delivered.</span>
            <form class="m-order u-s-m-b-30">
                <div class="m-order__select-wrapper">

                    <label class="u-s-m-r-8" for="my-order-sort">Show:</label><select
                        class="select-box select-box--primary-style" id="my-order-sort">
                        <option value="5" {{ request()->time_sort == 5 ? 'selected' : '' }}>Last 5 days</option>
                        <option value="15" {{ request()->time_sort == 15 ? 'selected' : '' }}>Last 15 days</option>
                        <option value="30" {{ request()->time_sort == 30 ? 'selected' : '' }}>Last 30 days</option>
                        <option value="180" {{ request()->time_sort == 180 ? 'selected' : '' }}>Last 6 months</option>
                        <option value="all" {{ request()->time_sort == 'all' ? 'selected' : '' }}>All Orders</option>
                    </select>
                </div>
            </form>
            <div class="m-order__list">
                @if ($orders && count($orders))
                    @foreach ($orders as $order)
                        <div class="m-order__get">
                            <div class="manage-o__header u-s-m-b-30">
                                <div class="dash-l-r">
                                    <div>
                                        <div class="manage-o__text-2 u-c-secondary">Order #{{ $order->code }}</div>
                                        <div class="manage-o__text u-c-silver">Placed on
                                            {{ date(config('constants.date_format'), strtotime($order->created_at)) }}</div>
                                    </div>
                                    <div>
                                        <div class="dash__link dash__link--brand">
                                            <a href="/member/orders/{{ $order->id }}">MANAGE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="manage-o__description">
                                <div class="description__container">
                                    <div class="description__img-wrap">
                                        @foreach ($order->orders_products[0]->product->images as $image)
                                            @if ($image->pin == 1)
                                                <img class="u-img-fluid" style="height: 100%; object-fit: contain;"
                                                    src="{{ asset($image->thumbnail) }}"
                                                    alt="{{ $order->orders_products[0]->product->name }}">
                                            @endif
                                        @endforeach

                                    </div>

                                    <div class="description-title">
                                        @foreach ($order->orders_products as $product)
                                            {{ $product->product->name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                                <div class="description__info-wrap">
                                    @if ($order->status == config('constants.order_status.pending.value'))
                                        <div>
                                            <span class="manage-o__badge badge--processing">Pending</span>
                                        </div>
                                    @endif

                                    @if ($order->status == config('constants.order_status.confirmed.value'))
                                        <div>

                                            <span class="manage-o__badge badge--processing">Confirmed</span>
                                        </div>
                                    @endif

                                    @if ($order->status == config('constants.order_status.shipping.value'))
                                        <div>

                                            <span class="manage-o__badge badge--shipped">Shipping</span>
                                        </div>
                                    @endif

                                    @if ($order->status == config('constants.order_status.completed.value'))
                                        <div>

                                            <span class="manage-o__badge badge--delivered">Completed</span>
                                        </div>
                                    @endif

                                    @if ($order->status == config('constants.order_status.canceled.value'))
                                        <div>

                                            <span class="manage-o__badge badge--canceled">Canceled</span>
                                        </div>
                                    @endif

                                    <div>
                                        <span class="manage-o__text-2 u-c-silver">Quantity:

                                            <span
                                                class="manage-o__text-2 u-c-secondary">{{ $order->quantity }}</span></span>
                                    </div>
                                    <div>

                                        <span class="manage-o__text-2 u-c-silver">Total:

                                            <span class="manage-o__text-2 u-c-secondary">@convertCurrency($order->total)</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="u-s-p-y-60">
                {{ $orders->onEachSide(2)->appends(Request::all())->links() }}
            </div>
        </div>
    </div>
@endsection
