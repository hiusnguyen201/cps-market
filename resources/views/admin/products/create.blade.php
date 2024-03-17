@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
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
                        <div class="input-group">
                            <input id="product" type="text" name="name" class="form-control"
                                placeholder="Enter product name..." value="">
                        </div>
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Product images</span></div>
                    <div class="col-7">
                        <div class="multiple-input_block">
                            <div class="input-file_block">
                                <img hidden class="input-file_image" src="" alt="">
                                <i class="far fa-file-image"></i>
                                <span class="input-file_text">Add File</span>
                                <input id="product" class="input-file_form" hidden type="file" name="product_images[]"
                                    multiple>
                                <div class="remove-btn_block">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </div>
                        </div>
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2"><span>Promotion Image</span><span
                                class="required-text ml-1">*</span></span></div>
                    <div class="col-7">
                        <div class="input-file_block">
                            <img hidden class="input-file_image" src="" alt="">
                            <i class="far fa-file-image"></i>
                            <span class="input-file_text">Add File</span>
                            <input id="product" hidden class="input-file_form" type="file" name="promotion_image">
                            <div class="remove-btn_block">
                                <i class="fas fa-trash"></i>
                            </div>
                        </div>
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Category</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <div class="input-group">
                            <select id="product" name="category" class="form-control create_product">
                                <option value="">Please set category</option>
                                @if (count($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Description</span></div>
                    <div class="col-7">
                        <div class="input-group">
                            <textarea id="product" style="resize: none" name="description" class="form-control" cols="30" rows="8"></textarea>
                        </div>
                        <span class="error-message"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary px-3 py-3 inactive-content">
            <span class="font-weight-bold title-create mb-2">Specification</span>
            <span class="inactive-text">Available only after you select a product category</span>
            <div id="specification" class="card-body hide">
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Brand</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <div class="input-group">
                            <select id="product" name="brand" class="form-control">
                                <option value="">Please select</option>
                                @if (count($category->brands))
                                    @foreach ($category->brands as $brand)
                                        <option value="{{ $brand->id }}">
                                            {{ $brand->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <span class="error-message"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary px-3 py-3 inactive-content">
            <span class="font-weight-bold title-create mb-2">Sales Information</span>
            <span class="inactive-text">Available only after you select a product category</span>
            <div id="sales" class="card-body hide">
                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Market Price</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input id="product" type="number" name="market_price" class="form-control">
                        </div>
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Price</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input id="product" type="number" name="price" class="form-control">
                        </div>
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="row align-items-start input-block">
                    <div class="col-3"><span class="mt-2">Quantity</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-7">
                        <div class="input-group">
                            <input id="product" type="number" name="quantity" class="form-control" value="0">
                        </div>
                        <span class="error-message"></span>
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
