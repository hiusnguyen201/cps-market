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
                                    <div class="section__text-wrap">
                                        <h1 class="section__heading u-c-secondary">FORGOT PASSWORD?</h1>
                                    </div>

                                    <span class="gl-text u-s-m-b-30">Enter your email below and we will send you a link to
                                        reset your password.</span>

                                    <form class="l-f-o__form" method="POST">
                                        @csrf
                                        @if (session('success'))
                                            <span style="color: green">{{ session('success') }}</span>
                                        @endif
                                        @if (session('error'))
                                            <span style="color: red"> {{ session('error') }}</span>
                                        @endif

                                        <div class="u-s-m-b-30">

                                            <label class="gl-label" for="email">E-MAIL *</label>

                                            <input class="input-text input-text--primary-style" type="email"
                                                id="email" placeholder="Enter E-mail" name="email"
                                                value="{{ old('email') }}" required>
                                            @error('email')
                                                <span style="color: red">{{ $message }}</span>
                                            @enderror


                                        </div>

                                        <div class="gl-inline">
                                            <div class="u-s-m-b-30">

                                                <button class="btn btn--e-transparent-brand-b-2" style="width: 100%"
                                                    type="submit">Submit</button>
                                            </div>
                                        </div>
                                        <div class="u-s-m-b-30">
                                            <a style="color: #FF4500" href="/auth/register"><i
                                                    class="fas fa-long-arrow-alt-left "></i>&nbsp;&nbsp;Back
                                                to
                                                Login</a>
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
