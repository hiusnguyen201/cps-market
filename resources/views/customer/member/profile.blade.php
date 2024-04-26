@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.customer.account')
@section('content_acc')
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white u-s-m-b-30">
        <div class="dash__pad-2">
            <h1 class="dash__h1 u-s-m-b-14">My Profile</h1>

            <span class="dash__text u-s-m-b-30">Look all your info, you could customize your profile.</span>
            <div class="row">
                <div class="col-lg-4 u-s-m-b-30">
                    <h2 class="dash__h2 u-s-m-b-8">Name</h2>

                    <span class="dash__text">{{ Auth::user()->name }}</span>
                </div>
                <div class="col-lg-4 u-s-m-b-30">
                    <h2 class="dash__h2 u-s-m-b-8">E-mail</h2>

                    <span class="dash__text">{{ Auth::user()->email }}</span>
                    <div class="dash__link dash__link--secondary">
                    </div>
                </div>
                <div class="col-lg-4 u-s-m-b-30">
                    <h2 class="dash__h2 u-s-m-b-8">Phone</h2>

                    <span class="dash__text">{{ Auth::user()->phone }}</span>
                    <div class="dash__link dash__link--secondary">
                    </div>
                </div>
                <div class="col-lg-4 u-s-m-b-30">
                    <h2 class="dash__h2 u-s-m-b-8">Gender</h2>
                    <span class="dash__text">
                        @if (config('constants.genders') && count(config('constants.genders')))
                            @foreach (config('constants.genders') as $gender)
                                @if (Auth::user()->gender == $gender['value'])
                                    {{ $gender['title'] }}
                                @endif
                            @endforeach
                        @endif
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="u-s-m-b-16">
                        <a class="dash__custom-link btn--e-transparent-brand-b-2" href="/member/edit-profile">Edit
                            Profile</a>
                    </div>
                    <div>
                        <a class="dash__custom-link btn--e-brand-b-2" href="/member/change-password">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
