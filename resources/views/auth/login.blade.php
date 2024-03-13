@extends('layouts.customer.index')

@section('content')
<!--====== App Content ======-->
<div class="app-content">

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
                                    <h1 class="section__heading u-c-secondary">SIGN IN</h1>
                                </div>
                                <span class="gl-text u-s-m-b-30">If you have an account with us, please log in.</span>
                                @if (session('success'))
                                    <span style="color: green"> {{ session('success') }}</span>
                                @endif

                                <form class="l-f-o__form" method="POST">
                                    @csrf
                                    
                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="email">E-MAIL *</label>

                                        <input class="input-text input-text--primary-style" type="email" id="email" placeholder="Enter E-mail" name="email" value="{{ old('email') }}" required>
                                        @if (session('error'))
                                            <span style="color: red"> {{ session('error') }}</span>
                                        @endif
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="password">PASSWORD *</label>

                                        <input class="input-text input-text--primary-style" type="password" id="password" placeholder="Enter Password" name="password" required>

                                    </div>


                                    <div class="gl-inline">
                             
                                        <div class="u-s-m-b-30">

                                            <a class="gl-link d-block text-right" href="/auth/forget-password">Forget Password?</a>
                                        </div>
                                    </div>
                                    <div class="gl-inline">
                                        <div class="u-s-m-b-30">

                                            <button class="btn btn--e-transparent-brand-b-2" style="width: 100%" type="submit">LOGIN</button>
                                        </div>
                                    </div>

                                    
                                    
                                    <div class="gl-s-api">
                                        <div class="u-s-m-b-15">

                                            <a class="gl-s-api__btn gl-s-api__btn--fb" type="button" href="/auth/facebook/redirect"><i class="fab fa-facebook-f"></i>

                                                <span>Sign in with Facebook</span></a>
                                        </div>
                                        <div class="u-s-m-b-15">

                                            <button class="gl-s-api__btn gl-s-api__btn--gplus" type="button" href="/auth/google/redirect"><i class="fab fa-google"></i>

                                                <span>Sign in with Google</span></button>
                                        </div>
                                    </div>

                                </form>
                                
                                <p class="text-center">Do not have account? &nbsp;<a class="" style="color: #FF4500" href="/auth/register">Register now</a></p>
                                
                                
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