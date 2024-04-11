@extends('layouts.customer.index')
@section('content')
<style>
    .dash__f-list>li {
        padding-bottom: 7px;
    }

    .dash__f-list>li>a {
        font-size: 15px;
        padding-left: 10px !important;
        padding: 7px;
    }

    .dash-active {
        border: 1px solid #ff4500;
        border-radius: 10px;
        color: #ff4500 !important;
        background-color: #fee;
    }
</style>

<div class="u-s-p-y-60">
    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="container">
            <div class="breadcrumb">
                <div class="breadcrumb__wrap">
                    <ul class="breadcrumb__list">
                        <li class="has-separator">

                            <a href="/">Home</a>
                        </li>
                        <li class="is-marked">

                            <a href="/member">My Account</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--====== Section 2 ======-->
<div class="u-s-p-b-60">
    <!--====== Section Content ======-->
    <div class="section__content">
        <div class="dash">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12 u-s-m-b-30">
                        <!--====== Dashboard Features ======-->
                        <div class="dash__box dash__box--bg-white dash__box--shadow u-s-m-b-30">
                            <div class="dash__pad-1">

                                <span class="dash__text u-s-m-b-16">{{ Auth::user()->name }}</span>
                                <ul class="dash__f-list">
                                    <li>
                                        <a class="{{ Request::is('member') ? 'dash-active' : '' }}"
                                            href="/member">Manage My Account</a>
                                    </li>
                                    <li>
                                        <a class="{{ str_contains(Request::getRequestUri(), '/member/orders') ? 'dash-active' : '' }}"
                                            href="/member/orders">My
                                            Orders</a>
                                    </li>
                                    <li>
                                        <a class="{{ Request::is('member/profile') || Request::is('member/edit-profile') || Request::is('member/change-password') ? 'dash-active' : '' }}"
                                            href="/member/profile">My Profile</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="dash__box dash__box--bg-white dash__box--shadow dash__box--w">
                            <div class="dash__pad-1">
                                <ul class="dash__w-list">
                                    <li>
                                        <div class="dash__w-wrap">

                                            <span class="dash__w-icon dash__w-icon-style-1"><i
                                                    class="fas fa-cart-arrow-down"></i></span>

                                            <span class="dash__w-text">{{ $countPlacedOrders }}</span>

                                            <span class="dash__w-name">Orders Placed</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dash__w-wrap">

                                            <span class="dash__w-icon dash__w-icon-style-2"><i
                                                    class="fas fa-times"></i></span>

                                            <span class="dash__w-text">{{ $countCancelOrders }}</span>

                                            <span class="dash__w-name">Cancel Orders</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dash__w-wrap">

                                            <span class="dash__w-icon dash__w-icon-style-3"><i
                                                    class="far fa-heart"></i></span>

                                            <span class="dash__w-text">{{ $countWishlist }}</span>

                                            <span class="dash__w-name">Wishlist</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--====== End - Dashboard Features ======-->
                    </div>
                    <div class="col-lg-9 col-md-12 u-s-m-b-30">
                        @yield('content_acc')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section Content ======-->
</div>
<!--====== End - Section 2 ======-->
@endsection
