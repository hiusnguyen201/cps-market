@extends('layouts.customer.account')

@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

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
                                    <label class="gl-label" for="name">NAME</label>
                                    <input class="input-text input-text--primary-style" type="text" id="name"
                                        name="name" placeholder="John Doe" value="{{ $user->name }}">
                                </div>

                            </div>

                            <div class="gl-inline">
                                <div class="u-s-m-b-30">
                                    <label class="gl-label" for="phone">EMAIL</label>
                                    <input class="input-text input-text--primary-style" type="email"
                                        value="{{ $user->email }}">
                                </div>

                            </div>

                            <div class="gl-inline">
                                <div class="u-s-m-b-30">

                                    <label class="gl-label" for="gender">GENDER</label>
                                    <select class="select-box select-box--primary-style u-w-100" id="gender"
                                        name="gender">
                                        <option>Select</option>
                                        @if (config('constants.genders'))
                                            @foreach (config('constants.genders') as $gender => $value)
                                                <option value="{{$value}}" {{ $user->gender == $value ? 'selected' : '' }}>
                                                    {{ $gender }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="gl-inline">
                                <div class="u-s-m-b-30">

                                    <label class="gl-label" for="phone">PHONE</label>

                                    <input class="input-text input-text--primary-style" type="text"
                                        value="{{ $user->phone }}">
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
