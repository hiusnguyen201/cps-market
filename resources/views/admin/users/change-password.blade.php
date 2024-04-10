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
                <label for="password" class="mb-0">Current Password&nbsp;<span class="required-text">*</span></label>
            </div>
            <div class="col-lg-8 col-12">
                <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Current Password" required>
                @error('password')
                <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row align-items-center">
            <div class="col-lg-3 col-12">
                <label for="password" class="mb-0">New Password&nbsp;<span class="required-text">*</span></label>
            </div>
            <div class="col-lg-8 col-12">
                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password" required>
                @error('new_password')
                <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row align-items-center">
            <div class="col-lg-3 col-12">
                <label for="password" class="mb-0">Re-enter New Password&nbsp;<span class="required-text">*</span></label>
            </div>
            <div class="col-lg-8 col-12">
                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" placeholder="Re-enter New Password" required>
                @error('new_password_confirmation')
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