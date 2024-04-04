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

<div class="app-content">

    <!--====== Section 2 ======-->
    <div class="u-s-p-b-60">

        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="dash">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-12">

                            <!--====== Dashboard Features ======-->
                            <div class="dash__box dash__box--bg-white dash__box--shadow u-s-m-b-30">
                                <div class="dash__pad-1">

                                    <span class="dash__text u-s-m-b-16">{{ $user->name }}</span>
                                    <ul class="dash__f-list">

                                        <li>

                                            <a class="{{ Request::is('member') ? 'dash-active' : '' }}" href="/member">Home</a>
                                        </li>

                                        <li>

                                            <a href="dash-my-order.html">My Orders</a>
                                        </li>

                                        <li>

                                            <a class="{{ Request::is('member/account/user-info') ? 'dash-active' : '' }}" href="/member/account/user-info">User Info</a>
                                        </li>

                                        <li>

                                            <a href="dash-track-order.html">Track Order</a>
                                        </li>

                                        <li>

                                            <a href="dash-payment-option.html">My Payment Options</a>
                                        </li>
                                        <li>

                                            <a href="dash-cancellation.html">My Returns & Cancellations</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>

                            <!--====== End - Dashboard Features ======-->
                        </div>
                        @yield('content_acc')
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 2 ======-->
</div>

@endsection