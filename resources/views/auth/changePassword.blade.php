@extends('layouts.customer.index')

@section('content')
    <div class="u-s-p-y-60">
        <div class="section__content">
            <div class="container">
                <div class="row row--center">
                    <div class="col-lg-6 col-md-8">
                        <div class="l-f-o">
                            <div class="l-f-o__pad-box">
                                <div class="section__text-wrap u-s-m-b-30">
                                    <h1 class="section__heading u-c-secondary">RESET PASSWORD</h1>
                                </div>

                                <form class="l-f-o__form" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="password">Enter new password *</label>

                                        <input class="input-text input-text--primary-style" type="password" id="password"
                                            placeholder="Enter password" name="password" required>
                                        @error('password')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">

                                        <label class="gl-label" for="password">Confirm Password *</label>

                                        <input class="input-text input-text--primary-style" type="password"
                                            id="password_confirmation" placeholder="Re-enter password"
                                            name="password_confirmation" required>
                                        @error('password_confirmation')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="u-s-m-b-30">
                                        <button class="btn btn--e-transparent-brand-b-2" style="width: 100%"
                                            type="submit">Reset Password</button>
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
