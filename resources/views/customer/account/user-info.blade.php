@extends('layouts.customer.account')

@section('content_acc')
<div class="col-lg-9 col-md-12">
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white">
        <div class="dash__pad-2">
        <h1 class="dash__h1 u-s-m-b-14 text-center">User Info</h1>

            <div class="row">
                <div class="col-lg-12">
                    <form class="dash-edit-p" method="post">
                        @csrf
                        @method('patch')
                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="name"> NAME </label>

                                <input class="input-text input-text--primary-style" type="text" id="name" name="name" placeholder="John Doe" value="{{ $user->name }}">
                            </div>

                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="phone"> EMAIL </label>

                                <input class="input-text input-text--primary-style" type="text" value="{{ $user->email }}" disabled>
                            </div>

                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="gender">GENDER</label>
                                <select class="select-box select-box--primary-style u-w-100" id="gender" name="gender">
                                    <option>Select</option>
                                    <option value="0" {{ $user->gender == 0 ? 'selected' : '' }}>Male</option>
                                    <option value="1" {{ $user->gender == 1 ? 'selected' : '' }}>Female</option>
                                    <option value="2" {{ $user->gender == 2 ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="phone"> PHONE </label>

                                <input class="input-text input-text--primary-style" type="text" value="{{ $user->phone }}" disabled>
                            </div>

                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="address"> ADDRESS </label>

                                <input class="input-text input-text--primary-style" type="text" id="address" name="address" value="{{ $user->address }}">
                            </div>

                        </div>

                        <div class="gl-inline">
                            <div class="u-s-m-b-30">
                                <h2 class="dash__h2 u-s-m-b-8"><a href="/member/change-password" style="color: #ff4500;">Change password</a></h2>
                                <span style="color: green">{{ session('success') }}</span>
                            </div>
                        </div>

                        <button class="btn btn--e-brand-b-2" style="width: 100%;" type="submit">SAVE</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection