@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card card-body">
        <form action="" method="POST">
            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="name" class="mb-0">Name&nbsp;<span class="required-text">*</span></label>
                </div>
                <div class="col-lg-7 col-12">
                    <input type="text" name="name" class="form-control" id="name"
                        placeholder="Enter brand name..." value="{{ old('name') }}">
                    @error('name')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row align-items-center">
                <div class="col-lg-3 col-12">
                    <label for="category" class="mb-0">Category</label>
                </div>
                <div class="col-lg-7 col-12">
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
            </div>

            <div class="d-grid">
                @csrf
                <button type="submit" class="btn btn-success w-100 py-2">Create</button>
            </div>
        </form>
    </div>
@endsection
