@extends('layouts.customer.index')

@section('content')
    @if (session('success'))
        <input hidden type="text" name="message-success" value="{{ session('success') }}">
    @endif
    @if (session('error'))
        <input hidden type="text" name="message-error" value="{{ session('error') }}">
    @endif

    <div class="u-s-p-y-60">
        <div class="section__content">
            <div class="container">
                <div class="row row--center">
                    <div class="col-lg-6 col-md-8">
                        <div class="l-f-o">
                            <div class="l-f-o__pad-box">
                                <div class="section__text-wrap u-s-m-b-30">
                                    <h1 class="section__heading u-c-secondary">CREATE AN ACCOUNT</h1>
                                </div>

                                <form class="l-f-o__form" method="POST">
                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="name">NAME *</label>

                                        <input class="input-text input-text--primary-style" type="text" id="name"
                                            placeholder="Enter name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="phone">PHONE *</label>

                                        <input class="input-text input-text--primary-style" type="tel" id="phone"
                                            placeholder="Enter phone" name="phone" value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="email">E-MAIL *</label>

                                        <input class="input-text input-text--primary-style" type="email" id="email"
                                            placeholder="Enter E-mail" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="password">PASSWORD *</label>

                                        <input class="input-text input-text--primary-style" type="password" id="password"
                                            placeholder="Enter password" name="password" required>
                                        @error('password')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="password_confirmation">CONFIRM PASSWORD *</label>

                                        <input class="input-text input-text--primary-style" type="password"
                                            id="password_confirmation" placeholder="Re-enter password"
                                            name="password_confirmation" required>
                                        @error('password_confirmation')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-15">

                                        <button class="btn btn--e-brand-b-2" style="width: 100%"
                                            type="submit">CREATE</button>
                                    </div>

                                    <p class="text-center">already have an account? &nbsp; <a class=""
                                            style="color: #FF4500" href="/auth/login">Login now</a></p>
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
