@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <form action="" method="POST">
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group row align-items-start">
                    <div class="col-3">
                        <label for="name" class="mt-1">Name&nbsp;<span class="required-text">*</span></label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                            value="{{ old('name') ?? $user->name }}">
                        @error('name')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row align-items-start">
                    <div class="col-3">
                        <label for="email" class="mt-1">Email&nbsp;<span class="required-text">*</span></label>
                    </div>
                    <div class="col-8">
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Enter email..." value="{{ old('email') ?? $user->email }}">
                        @error('email')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row align-items-start">
                    <div class="col-3">
                        <label for="phone" class="mt-1">Phone&nbsp;<span class="required-text">*</span></label>
                    </div>
                    <div class="col-8">
                        <input type="tel" name="phone" class="form-control" id="phone"
                            placeholder="Enter phone..." value="{{ old('phone') ?? $user->phone }}">
                        @error('phone')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row align-items-start">
                    <div class="col-3">
                        <label for="address" class="mt-1">Address</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="address" class="form-control" id="address"
                            placeholder="Enter address..." value="{{ old('address') ?? $user->address }}">
                        @error('address')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row align-items-start">
                    <div class="col-3">
                        <label for="gender" class="mt-1">Gender</label>
                    </div>
                    <div class="col-8">
                        <div class="d-flex align-items-center justify-content-start g-2">
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
                <div class="form-group row align-items-start">
                    <div class="col-3">
                        <label for="role" class="mt-1">Role&nbsp;<span class="required-text">*</span></label>
                    </div>
                    <div class="col-8">
                        <select name="role" id="role" class="form-control">
                            <option value="">- - - Select a role - - - </option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role') ?? $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach

                        </select>
                        @error('role')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" class="btn btn-success w-100 py-2">Submit</button>
            @csrf
        </div>
    </form>
@endsection
