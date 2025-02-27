@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card py-3 px-3">
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" id="name"
                    placeholder="Enter specification name..." value="{{ old('name') }}">
                @error('name')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" id="attributeFields">
                <label for="name"><span class="mr-3">Attributes:</span><button type="button" class="btn btn-primary"
                        id="addAttribute">+</button>
                </label>

                @error('attributes')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <input type="hidden" name="category_id" value="{{ $category->id }}">

            <div class="row">
                <div class="col-lg-6 col-12">
                    <button type="submit" class="btn btn-success w-100 py-2 mb-3">Add</button>
                </div>
                <div class="col-lg-6 col-12">
                    <a class="btn btn-danger py-2 w-100 mb-3" href="/admin/categories/details/{{ $category->id }}">Back</a>
                </div>
            </div>
            @csrf
        </form>
    </div>
@endsection
