@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card card-body">
        <form action="" method="POST">
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="name" class="mt-1">Name&nbsp;<span class="required-text">*</span></label>
                </div>
                <div class="col-lg-7 col-12">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                        value="{{ old('name') ?? $user->name }}">
                    @error('name')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="email" class="mt-1">Email&nbsp;<span class="required-text">*</span></label>
                </div>
                <div class="col-lg-7 col-12">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email..."
                        value="{{ old('email') ?? $user->email }}">
                    @error('email')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="phone" class="mt-1">Phone&nbsp;<span class="required-text">*</span></label>
                </div>
                <div class="col-lg-7 col-12">
                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter phone..."
                        value="{{ old('phone') ?? $user->phone }}">
                    @error('phone')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="gender" class="mt-1">Gender</label>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="d-flex align-items-center justify-content-start g-2">
                        @if (config('constants.genders') && count(config('constants.genders')))
                            @foreach (config('constants.genders') as $gender)
                                <div class="mr-2">
                                    <input
                                        {{ (old('gender') ?? $user->gender != '') && (old('gender') ?? $user->gender) == $gender['value'] ? 'checked' : '' }}
                                        type="radio" name="gender" value="{{ $gender['value'] }}">

                                    <label class="mb-0">{{ $gender['title'] }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @error('gender')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="gender" class="mb-0">Status</label>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="d-flex align-items-center justify-content-start g-2">
                        @if (config('constants.user_status') && count(config('constants.user_status')))
                            <select name="status" class="form-control">
                                @foreach (config('constants.user_status') as $status)
                                    <option {{ $status['value'] == $user->status ? 'selected' : '' }}
                                        value="{{ $status['value'] }}">{{ $status['title'] }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    @error('status')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="address" class="mb-0">Address</span></label>
                </div>
                <div class="col-lg-7 col-12">
                    <input type="address" name="address" class="form-control" id="address" placeholder="Address..."
                        value="{{ old('address') ?? $user->address }}">
                    @error('address')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row actions-block">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="col-lg-6 col-12 mb-3 back-btn"><a class="btn btn-danger w-100 py-2"
                        href="/admin/customers">Back</a>
                </div>
                <div class="col-lg-6 col-12 mb-3 keepon-btn"><button type="submit"
                        class="btn btn-success py-2 w-100">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
