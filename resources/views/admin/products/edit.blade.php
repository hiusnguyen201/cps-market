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

@extends('layouts.admin.index')
@section('content')
    <div class="card card-primary mb-0">
        <form action="" method="POST">
            <div class="card-body">
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
                    <select name="category[]" multiple="multiple" style="width:100%"
                        data-placeholder="- - - Select a category - - -">
                        @foreach ($categories as $category)
                            <option
                                {{ in_array($category['id'], old('category') ?? $brand_category_ids) ? 'selected' : '' }}
                                value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error('category')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <input type="hidden" name="id" value="{{ $brand->id }}">

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            @csrf
        </form>
    </div>
@endsection
