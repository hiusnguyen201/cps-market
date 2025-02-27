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
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name..."
                        value="{{ old('name') ?? $brand->name }}">
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
                    <select id="brand" name="category[]" class="select2" multiple="multiple" style="width:100%"
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
            </div>

            <div class="row actions-block">
                @csrf
                <input type="hidden" name="id" value="{{ $brand->id }}">
                @method('PATCH')

                <div class="col-lg-6 col-12 mb-3 back-btn"><a class="btn btn-danger w-100 py-2"
                        href="/admin/brands">Back</a>
                </div>
                <div class="col-lg-6 col-12 mb-3 keepon-btn"><button type="submit"
                        class="btn btn-success py-2 w-100">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
