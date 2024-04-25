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
                                    <h1 class="section__heading u-c-secondary">FORGOT PASSWORD</h1>
                                </div>

                                <span class="gl-text u-s-m-b-30">Enter your email below and we will send you a link to
                                    reset your password.</span>

                                <form class="l-f-o__form" method="POST">
                                    @csrf
                                    <div class="u-s-m-b-30">
                                        <label class="gl-label" for="email">E-MAIL *</label>
                                        <input class="input-text input-text--primary-style" type="email" id="email"
                                            placeholder="Enter E-mail" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">
                                        <button class="btn btn--e-brand-b-2" style="width: 100%"
                                            type="submit">Submit</button>
                                    </div>

                                    <div class="u-s-m-b-30">
                                        <a style="color: #FF4500" href="/auth/login"><i
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
    </div>
@endsection
