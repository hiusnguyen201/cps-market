@extends('layouts.admin.index')
@section('content')
    <div class="card">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <h1>Edit category</h1>
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
                <div class="card-body">

                    <input type="hidden" name="id" value="{{ $category->id }}">
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
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                            value="{{ old('name') ?? $category->name }}">
                        @error('name')
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
