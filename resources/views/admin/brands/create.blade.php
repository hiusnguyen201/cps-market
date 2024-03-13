@extends('layouts.admin.index')
@section('content')
    <div class="card card-primary">
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
                    <label for="name">Brand Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter brand name..."
                        value="{{ old('name') }}">
                    @error('name')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">Category</label>

                    <select id="brand" name="category[]" multiple="multiple" style="width:100%"
                        data-placeholder="- - - Select a category - - -">
                        @foreach ($categories as $category)
                            <option {{ in_array($category['id'], old('category') ?? []) ? 'selected' : '' }}
                                value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error('category')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-grid">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-2">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
