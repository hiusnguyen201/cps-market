@extends('layouts.index')
@section('content')
    <div class="card">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <h1>Create new user</h1>
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
                            Something wrong!
                        </div>
                    @endif
                        
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-warning">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                            value="{{ old('name') }}">
                        @error('name')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Enter email..." value="{{ old('email') }}">
                        @error('email')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" name="phone" class="form-control" id="phone"
                            placeholder="Enter phone..." value="{{ old('phone') }}">
                        @error('phone')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" id="address"
                            placeholder="Enter address..." value="{{ old('address') }}">

                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>

                        <div class="d-flex align-items-center justify-content-start">

                            @foreach ($genders as $gender)
                                <input {{ old('gender') == $gender['value'] ? 'checked' : '' }} type="radio" name="gender"
                                    id="{{ $gender['name'] }}" value="{{ $gender['value'] }}">
                                <label class="mr-2" for="{{ $gender['name'] }}">{{ $gender['name'] }}</label>
                            @endforeach

                        </div>
                        @error('gender')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">- - - Select a role - - - </option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
