@extends('layouts.index')
@section('content')
    <div class="card">

        <div class="card card-primary mb-0">
            <div class="card-header">
                <h3 class="card-title">
                    <h1>Edit user</h1>
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
                            Something wrong!
                            <li>{{ $errors }}</li>
                        </div>
                    @endif

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
                        <label for="name">Brand Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                            value="{{ old('name') ?? $brand->name }}">
                        @error('name')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">- - - Select a category - - - </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ (old('category') ?? $category->id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach

                        </select>
                        @error('role')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
