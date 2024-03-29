@extends('layouts.customer.index')

@section('content')
<!--====== App Content ======-->
<div class="app-content">
    <!--====== Section 1 ======-->

    <!--====== End - Section 1 ======-->


    <!--====== Section 2 ======-->
    <div class="u-s-p-b-60">



        <!--====== Section Content ======-->
        <div class="section__content mt-2">
            <div class="container">
                <div class="row row--center">
                    <div class="col-lg-6 col-md-8 u-s-m-b-30">
                        <div class="l-f-o">
                            <div class="l-f-o__pad-box">

                                <h1 class="gl-h1 text-uppercase">VERIFY OTP</h1>

                                <form class="l-f-o__form" method="POST">
                                    @csrf

                                    @if (session('success'))
                                    <span style="color: rgb(25, 198, 25)"> {{ session('success') }}</span>
                             

                                    @endif

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="otp">OTP *</label>

                                        <input class="input-text input-text--primary-style" type="text" id="otp" placeholder="Enter OTP" name="otp" required>
                                        @if (session('error'))
                                            <span style="color: red"> {{ session('error') }}</span>
                                        @endif
                                        @error('otp')
                                            <span style="color: red"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="gl-inline">
                                        <div class="u-s-m-b-30">

                                            <a class="text-right"  style="color: #FF4500" href="/auth/otp/resend">Resend OTP</a>
                                        </div>
                                    </div>
                                    <div class="u-s-m-b-30">

                                        <button class="btn btn--e-transparent-brand-b-2" style="width: 100%" type="submit">LOGIN</button>
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