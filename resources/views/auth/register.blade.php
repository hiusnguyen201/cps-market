@extends('layouts.customer.index')

@section('content')
<!--====== App Content ======-->
<div class="app-content">
    <!--====== Section 1 ======-->
    <div class="u-s-p-y-60">
        <!--====== Section Content ======-->
        <div class="section__content">
            <div class="container">
                <div class="breadcrumb">
                    <div class="breadcrumb__wrap">
                        <ul class="breadcrumb__list">
                            <li class="has-separator">

                                <a href="index.html">Home</a>
                            </li>
                            <li class="is-marked">

                                <a href="/auth/register">Sign up</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== End - Section 1 ======-->


    <!--====== Section 2 ======-->
    <div class="u-s-p-b-60">

        <!--====== Section Intro ======-->
        <div class="section__intro u-s-m-b-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section__text-wrap">
                            <h1 class="section__heading u-c-secondary">CREATE AN ACCOUNT</h1>
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

                                <h1 class="gl-h1">PERSONAL INFORMATION</h1>

                                <form class="l-f-o__form" method="POST">
                                    @csrf
                                    <div class="gl-s-api">
                                        <div class="u-s-m-b-15">

                                            <a class="gl-s-api__btn gl-s-api__btn--fb" type="button" href="/auth/facebook/redirect"><i class="fab fa-facebook-f"></i>

                                                <span>Sign up with Facebook</span></a>
                                        </div>
                                        <div class="u-s-m-b-15">

                                            <button class="gl-s-api__btn gl-s-api__btn--gplus" type="button" href="/auth/google/redirect"><i class="fab fa-google"></i>

                                                <span>Sign up with Google</span></button>
                                        </div>
                                    </div>



                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="name">NAME *</label>

                                        <input class="input-text input-text--primary-style" type="text" id="name" placeholder="Enter name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                        <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="phone">PHONE *</label>

                                        <input class="input-text input-text--primary-style" type="tel" id="phone" placeholder="Enter phone" name="phone" value="{{ old('phone') }}" required>
                                        @error('phone')
                                        <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="email">E-MAIL *</label>

                                        <input class="input-text input-text--primary-style" type="email" id="email" placeholder="Enter E-mail" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                        <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="password">PASSWORD *</label>

                                        <input class="input-text input-text--primary-style" type="password" id="password" placeholder="Enter password" name="password" required>
                                        @error('password')
                                        <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="password_confirmation">CONFIRM PASSWORD *</label>

                                        <input class="input-text input-text--primary-style" type="password" id="password_confirmation" placeholder="Re-enter password" name="password_confirmation" required>
                                        @error('password_confirmation')
                                        <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-15">

                                        <button class="btn btn--e-transparent-brand-b-2" type="submit">CREATE</button>
                                    </div>

                                    <a class="gl-link" href="/">Return to Store</a>
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