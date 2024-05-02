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


    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
        @if ($wishlist && count($wishlist))
            <div class="dash__box dash__box--shadow dash__box--bg-white dash__box--radius u-s-m-b-30">
                <h2 class="dash__h2 u-s-p-xy-20">YOUR WISHLIST</h2>
                <section>
                    <div class="container">
                        <div class="swiper-member u-s-p-y-8" style="overflow: hidden">
                            <div class="swiper-wrapper">
                                @foreach ($wishlist as $index => $item)
                                    @if ($index == 4)
                                    @break
                                @endif
                                @if (!$item->product->deleted_at)
                                    <div class="swiper-slide">
                                        @if ($item->product->sale_price && $item->product->price - $item->product->sale_price > 0)
                                            <span class="product-bs__discount-label">
                                                <span class="product-bs__discount-percent">SALE
                                                    {{ round((($item->product->price - $item->product->sale_price) * 100) / $item->product->price, 0) }}%</span>
                                            </span>
                                        @endif
                                        <div class="product-bs">
                                            <a href='/{{ $item->product->slug }}.html'>

                                                <div class="product-bs__container" style="min-height: auto">
                                                    <div class="product-bs__wrap">
                                                        <div class="aspect aspect--bg-grey aspect--square u-d-block">
                                                            @foreach ($item->product->images as $image)
                                                                @if ($image->pin == 1)
                                                                    <img src="{{ asset($image->thumbnail) }}"
                                                                        class="aspect__img" alt="">
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <span
                                                        class="product-bs__category">{{ $item->product->category->name }}</span>
                                                    <span
                                                        class="product-bs__name u-s-m-b-10">{{ $item->product->name }}</span>
                                                    <div hidden class="product-bs__rating gl-rating-style">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <span class="product-bs__review">(23)</span>
                                                    </div>

                                                    <span class="product-bs__price">@convertCurrency($item->product->sale_price ?? $item->product->price)
                                                        @if ($item->product->sale_price)
                                                            <span class="product-bs__discount">@convertCurrency($item->product->price)</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
            </section>
            <a href="/wishlist" class="dash__h2 u-s-p-xy-20"
                style="text-align: center; width:100%; display:block; color: #ff4500"><i
                    class="fas fa-chevron-circle-down"></i> Show
                more</a>
        </div>
    @endif
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
