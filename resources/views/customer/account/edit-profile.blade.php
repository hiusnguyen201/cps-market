@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.customer.account')
@section('content_acc')
    <div class="dash__box dash__box--shadow dash__box--radius dash__box--bg-white">
        <div class="dash__pad-2">
            <h1 class="dash__h1 u-s-m-b-14">Edit Profile</h1>
            <span class="dash__text u-s-m-b-30">Looks like you haven't update your profile</span>

            <div class="row">
                <div class="col-lg-12">
                    <form class="dash-edit-p" method="post">
                        @csrf
                        @method('patch')
                        <div class="gl-inline">
                            <div class="u-s-m-b-30">
                                <label class="gl-label" for="reg-fname">NAME *</label>

                                <input class="input-text input-text--primary-style" type="text" id="reg-fname"
                                    placeholder="Name..." name="name" value="{{ old('name') ?? Auth::user()->name }}"
                                    fdprocessedid="3nhn3">

                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="u-s-m-b-30">

                                <label class="gl-label" for="reg-lname">EMAIL *</label>

                                <input class="input-text input-text--primary-style" type="email" id="reg-lname"
                                    placeholder="Email..." name="email" value="{{ old('email') ?? Auth::user()->email }}"
                                    fdprocessedid="sr7ra8">
                                @error('email')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="gl-inline">
                            <div class="u-s-m-b-30">
                                <label class="gl-label" for="reg-lname">PHONE *</label>
                                <input class="input-text input-text--primary-style" type="phone" id="reg-lname"
                                    placeholder="Phone..." name="phone" value="{{ old('phone') ?? Auth::user()->phone }}"
                                    fdprocessedid="sr7ra8">
                                @error('phone')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="u-s-m-b-30">
                                <label class="gl-label" for="gender">GENDER</label>
                                <select class="select-box select-box--primary-style u-w-100" id="gender" name="gender">
                                    <option>Select</option>
                                    @if (config('constants.genders') && count(config('constants.genders')))
                                        @foreach (config('constants.genders') as $gender)
                                            <option
                                                {{ (old('gender') ?? Auth::user()->gender) == $gender['value'] ? 'selected' : '' }}
                                                value="{{ $gender['value'] }}">
                                                {{ $gender['title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('gender')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="gl-inline">
                            <div class="u-s-m-b-30">
                                <label class="gl-label" for="reg-lname">ADDRESS</label>
                                <input class="input-text input-text--primary-style" type="text" id="reg-lname"
                                    placeholder="Address..." name="address"
                                    value="{{ old('address') ?? Auth::user()->address }}" fdprocessedid="sr7ra8">
                                @error('address')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ Auth::id() }}">
                        <button class="btn btn--e-brand-b-2" type="submit" style="width:100%"
                            fdprocessedid="rd0deq">SAVE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
