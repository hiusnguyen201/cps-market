@extends('layouts.admin.index')
@section('content')
    <div class="card">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <h1>Edit user</h1>
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                            value="{{ old('name') ?? $user->name }}">
                        @error('name')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Enter email..." value="{{ old('email') ?? $user->email }}">
                        @error('email')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" name="phone" class="form-control" id="phone"
                            placeholder="Enter phone..." value="{{ old('phone') ?? $user->phone }}">
                        @error('phone')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address"><span>Addresss</span><span
                                class="ml-1 text-black-50">(optional)</span></label>
                        <input type="text" name="address" class="form-control" id="address"
                            placeholder="Enter address..." value="{{ old('address') ?? $user->address }}">
                        @error('address')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender"><span>Gender</span><span class="ml-1 text-black-50">(optional)</span></label>
                        <div class="d-flex align-items-center justify-content-start">
                            @foreach ($genders as $key => $value)
                                <input {{ (old('gender') ?? $user->gender) == $value ? 'checked' : '' }} type="radio"
                                    name="gender" value="{{ $value }}">

                                <label class="mr-2">{{ $key }}</label>
                            @endforeach
                        </div>
                        @error('gender')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                        <input type="hidden" name="id" value="{{ $user->id }}">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">- - - Select a role - - - </option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ (old('role') ?? $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">update</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
