@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <form action="" method="POST">
        <div class="card card-body">
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="name" class="mb-0">Name&nbsp;<span class="required-text">*</span></label>
                </div>
                <div class="col-lg-8 col-12">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                        value="{{ old('name') ?? $user->name }}">
                    @error('name')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="email" class="mb-0">Email&nbsp;<span class="required-text">*</span></label>
                </div>
                <div class="col-lg-8 col-12">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email..."
                        value="{{ old('email') ?? $user->email }}">
                    @error('email')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="phone" class="mb-0">Phone&nbsp;<span class="required-text">*</span></label>
                </div>
                <div class="col-lg-8 col-12">
                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter phone..."
                        value="{{ old('phone') ?? $user->phone }}">
                    @error('phone')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="gender" class="mb-0">Gender</label>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="row align-items-center g-2">
                        @foreach ($genders as $key => $value)
                            <div class="mr-2">
                                <input {{ (old('gender') ?? $user->gender) == $value ? 'checked' : '' }} type="radio"
                                    name="gender" value="{{ $value }}">

                                <label class="mb-0">{{ $key }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('gender')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-grid">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <button type="submit" class="btn btn-success w-100 py-2">Save</button>
            </div>
        </div>
    </form>
@endsection
