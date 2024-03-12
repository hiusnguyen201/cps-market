@extends('layouts.customer.index')

@section('content')
<!--====== App Content ======-->
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
                            <h1 class="section__heading u-c-secondary">VERIFY OTP</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Intro ======-->


        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="row row--center">
                    <div class="col-lg-6 col-md-8 u-s-m-b-30">
                        <div class="l-f-o">
                            <div class="l-f-o__pad-box">

                                <h1 class="gl-h1 text-uppercase">VERIFY OTP</h1>

                                <form class="l-f-o__form" method="POST">
                                    @csrf

                                    @if (session('success'))
                                    <div class="alert alert-success m-1">
                                        {{ session('success') }}
                                    </div>
                                    @endif

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="otp">OTP *</label>

                                        <input class="input-text input-text--primary-style" type="text" id="otp" placeholder="Enter OTP" name="otp" required>
                                        @if (session('error'))
                                        <div class="alert alert-danger m-1">
                                            {{ session('error') }}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="gl-inline">
                                        <div class="u-s-m-b-30">

                                            <button class="btn btn--e-transparent-brand-b-2" type="submit">LOGIN</button>
                                        </div>
                                        <div class="u-s-m-b-30">

                                            <a class="btn btn--e-transparent-brand-b-2" href="/auth/otp/resend">Resend OTP</a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== End - Section Content ======-->
    </div>
    <!--====== End - Section 2 ======-->
</div>
<!--====== End - App Content ======-->
@endsection