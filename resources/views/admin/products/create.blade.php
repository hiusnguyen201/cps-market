@if (session('success'))
    <div hidden class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div hidden class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@extends('layouts.admin.index')
@section('content')
    <form id="product" action="" enctype="multipart/form-data" method="POST">
        <div class="card card-primary px-3 py-3">
            <span class="font-weight-bold title-create mb-2">Basic information</span>



            <div class="card-body">
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Name</span><span class="required-text ml-1">*</span></div>
                    <div class="col-7">
                        <input type="text" name="name" class="form-control" placeholder="Enter product name..."
                            value="{{ old('name') }}">

                        @error('name')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Product images</span></div>
                    <div class="col-7">
                        <div class="image_block">
                            <input type="file" name="product_images[]" multiple>
                        </div>

                        @error('product_images')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2"><span>Promotion Image</span><span
                                class="required-text ml-1">*</span></span></div>
                    <div class="col-7">
                        <div class="image_block">
                            <input type="file" name="promotion_image">
                        </div>

                        @error('promotion_image')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Category</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <select id="product" name="category" class="form-control create_product">
                            <option value="">Please set category</option>
                            @if (count($categories))
                                @foreach ($categories as $category)
                                    <option {{ $category->id == old('category') ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>

                        @error('category')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Description</span></div>
                    <div class="col-7">
                        <textarea style="resize: none" name="description" class="form-control" cols="30" rows="8">{{ old('description') }}</textarea>

                        @error('description')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary px-3 py-3 {{ old('category') ? '' : 'inactive-content' }}">
            <span class="font-weight-bold title-create mb-2">Specification</span>
            @if (!old('category'))
                <span class="inactive-text">Available only after you select a product category</span>
            @endif
            <div id="specification" class="card-body {{ old('category') ? '' : 'hide' }}">
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Brand</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <select id="product" name="brand" class="form-control">
                            <option value="">Please select</option>
                            @if (old('category'))
                                @foreach ($category->brands as $brand)
                                    <option {{ old('brand') ? 'selected' : '' }} value="{{ $brand->id }}">
                                        {{ $brand->name }}</option>
                                @endforeach
                            @endif
                        </select>

                        @error('brand')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary px-3 py-3 {{ old('category') ? '' : 'inactive-content' }}">
            <span class="font-weight-bold title-create mb-2">Sales Information</span>
            @if (!old('category'))
                <span class="inactive-text">Available only after you select a product category</span>
            @endif
            <div id="sales" class="card-body {{ old('category') ? '' : 'hide' }}">
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Market Price</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input type="number" name="market_price" class="form-control"
                                value="{{ old('market_price') }}">
                        </div>

                        @error('market_price')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Price</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
                        </div>

                        @error('price')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Quantity</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}">

                        @error('quantity')
                            <span class="required-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid mb-3">
            @csrf
            <button type="submit" class="btn btn-primary w-100 py-3">Submit</button>
        </div>
    </form>
@endsection
