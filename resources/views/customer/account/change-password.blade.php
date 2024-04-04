@extends('layouts.customer.account')

@section('content_acc')
<div class="col-lg-9 col-md-12">
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white">
        <div class="dash__pad-2">
            <h1 class="dash__h1 u-s-m-b-14 text-center">Change Password</h1>

            <div class="row">
                <div class="col-lg-12">
                    <form class="dash-edit-p" method="post">
                        @csrf
                        @method('patch')
                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="name"> CURRENT PASSWORD </label>

                                <input class="input-text input-text--primary-style" type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
                                @error('password')
                                <span style="color: red">{{ $message }}</span>
                                @enderror

                                <span style="color: red">{{ session('error') }}</span>

                            </div>

                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="name"> NEW PASSWORD </label>

                                <input class="input-text input-text--primary-style" type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
                                @error('new_password')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <input class="input-text input-text--primary-style" type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Re-enter new password" required>
                                @error('new_password_confirmation')
                                <span style="color: red">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <button class="btn btn--e-brand-b-2" style="width: 100%;" type="submit">SAVE</button>

                    </form>

                    <div class="gl-inline">
                        <div class="u-s-m-t-30">
                            <h2 class="dash__h2 u-s-m-b-8">
                                <a href="/member/account/user-info" style="color: #ff4500;">
                                    <svg fill="#ff4500" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 476.213 476.213" xml:space="preserve">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <polygon points="476.213,223.107 57.427,223.107 151.82,128.713 130.607,107.5 0,238.106 130.607,368.714 151.82,347.5 57.427,253.107 476.213,253.107 "></polygon>
                                        </g>
                                    </svg>
                                </a>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection