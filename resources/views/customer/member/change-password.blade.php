@extends('layouts.customer.account')

@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@section('content_acc')
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white">
        <div class="dash__pad-2">
            <h1 class="dash__h1 u-s-m-b-14">Change Password</h1>
            <span class="dash__text u-s-m-b-30">Looks like you wanna change your password</span>
            <div class="row">
                <div class="col-lg-12">
                    <form class="dash-edit-p" method="post">
                        @csrf
                        @method('patch')
                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="name">CURRENT PASSWORD</label>

                                <input class="input-text input-text--primary-style" type="password" id="current_password"
                                    name="current_password" placeholder="Enter current password" required>
                                @error('password')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror

                                <span style="color: red">{{ session('error') }}</span>

                            </div>

                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="name">NEW PASSWORD</label>

                                <input class="input-text input-text--primary-style" type="password" id="new_password"
                                    name="new_password" placeholder="Enter new password" required>
                                @error('new_password')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <input class="input-text input-text--primary-style" type="password"
                                    id="new_password_confirmation" name="new_password_confirmation"
                                    placeholder="Re-enter new password" required>
                                @error('new_password_confirmation')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <button class="btn btn--e-brand-b-2" style="width: 100%;" type="submit">SAVE</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
