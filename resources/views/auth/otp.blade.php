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
                                <form class="l-f-o__form" method="POST">
                                    <div class="section__text-wrap u-s-m-b-30">
                                        <h1 class="section__heading u-c-secondary">VERIFY OTP</h1>
                                    </div>
                                    <div class="u-s-m-b-30">
                                        <label class="gl-label" for="otp">OTP *</label>
                                        <input class="input-text input-text--primary-style" type="text" id="otp"
                                            placeholder="Enter OTP" name="otp" required>

                                        @error('otp')
                                            <span style="color: red"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="gl-inline">
                                        <div class="u-s-m-b-30">
                                            <a class="text-right" style="color: #FF4500" href="/auth/otp/resend">Resend
                                                OTP</a>
                                        </div>
                                    </div>
                                    <div class="u-s-m-b-15">
                                        <button class="btn btn--e-brand-b-2" style="width: 100%"
                                            type="submit">SUBMIT</button>
                                    </div>
                                    <div class="u-s-m-b-15">
                                        <a href="/auth/logout" style="display: block; text-align:center"
                                            class="btn btn--e-transparent-brand-b-2">Back</a>
                                    </div>
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
