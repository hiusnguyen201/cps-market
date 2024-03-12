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

                                <a href="/">Home</a>
                            </li>
                            <li class="is-marked">

                                <a href="/auth/login">Sign in</a>
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
                            <h1 class="section__heading u-c-secondary">Update info account</h1>
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

                                <form class="l-f-o__form" method="POST">
                                    @csrf

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="name">NAME *</label>

                                        <input class="input-text input-text--primary-style" type="text" id="name" placeholder="Enter name" name="name" value="{{ old('name') ?? $name }}" required>
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

                                        <input class="input-text input-text--primary-style" type="email" id="email" placeholder="Enter E-mail" name="email" value="{{ old('email') ?? $email }}" required>
                                        @error('email')
                                        <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                    @endif

                                    <div class="gl-inline">
                                        <div class="u-s-m-b-30">

                                            <button class="btn btn--e-transparent-brand-b-2" type="submit">Confirm</button>
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