@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.customer.account')

@section('content_acc')
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
        <div class="dash__pad-2">
            <h1 class="dash__h1 u-s-m-b-14">Manage My Account</h1>

            <span class="dash__text u-s-m-b-30">From your My Account Dashboard you have the ability to view a snapshot of
                your recent account activity and update your account information. Select a link below to view or edit
                information.</span>
            <div class="row">
                <div class="col-lg-4 u-s-m-b-30">
                    <div class="dash__box dash__box--bg-grey dash__box--shadow-2 u-h-100">
                        <div class="dash__pad-3">
                            <h2 class="dash__h2 u-s-m-b-8">PERSONAL PROFILE</h2>
                            <div class="dash__link dash__link--secondary u-s-m-b-8">

                                <a href="/member/edit-profile">Edit</a>
                            </div>

                            <span class="dash__text">{{ Auth::user()->name }}</span>

                            <span class="dash__text">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 u-s-m-b-30">
                    <div class="dash__box dash__box--bg-grey dash__box--shadow-2 u-h-100">
                        <div class="dash__pad-3">
                            <h2 class="dash__h2 u-s-m-b-8">ADDRESS BOOK</h2>
                            <div class="dash__link dash__link--secondary u-s-m-b-8">

                                <a href="/member/edit-profile">Edit</a>
                            </div>

                            <span class="dash__text">{{ Auth::user()->address }}</span>

                            <span class="dash__text">{{ Auth::user()->phone }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="dash__box dash__box--shadow dash__box--bg-white dash__box--radius">
        <h2 class="dash__h2 u-s-p-xy-20">RECENT ORDERS</h2>
        <div class="dash__table-wrap gl-scroll">
            <table class="dash__table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Placed On</th>
                        <th>Items</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($recentOrders && count($recentOrders))
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td>{{ $order->code }}</td>
                                <td>{{ date(config('constants.date_format'), strtotime($order->created_at)) }}</td>
                                <td>
                                    <div class="dash__table-img-wrap">
                                        @foreach ($order->orders_products[0]->product->images as $image)
                                            @if ($image->pin == 1)
                                                <a href="/member/orders/{{ $order->id }}">
                                                    <img class="u-img-fluid" style="height: 100%; object-fit: contain;"
                                                        src="{{ asset($image->thumbnail) }}"
                                                        alt="{{ $order->orders_products[0]->product->name }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="dash__table-total">

                                        <span>@convertCurrency($order->total)</span>
                                        <div class="dash__link dash__link--brand">

                                            <a href="/member/orders/{{ $order->id }}">MANAGE</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
