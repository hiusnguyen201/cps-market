@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <form id="product" action="" enctype="multipart/form-data" method="POST">
        <div class="card card-body">
            <h3 class="font-weight-bold title-create mb-3">Basic information</h3>
            <div class="card-body">
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Name</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <input id="product" type="text" name="name" class="form-control"
                                placeholder="Enter product name..." value="">
                        </div>
                    </div>
                </div>
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Product images</span></div>
                    <div class="col-lg-7 col-12 input-product_form">
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
                    </div>
                </div>

                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2"><span>Promotion Image</span><span
                                class="required-text ml-1">*</span></span></div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-file_block">
                            <img hidden class="input-file_image" src="" alt="">
                            <i class="far fa-file-image"></i>
                            <span class="input-file_text">Add File</span>
                            <input id="product" hidden class="input-file_form" type="file" name="promotion_image">
                            <div class="remove-btn_block">
                                <i class="fas fa-trash"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Category</span><span
                            class="required-text ml-1">*</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
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
                    </div>
                </div>
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Description</span></div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <textarea id="product" style="resize: none" name="description" class="form-control" cols="30" rows="8"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-body inactive-content">
            <h3 class="font-weight-bold title-create mb-3">Specification</h3>
            <span class="inactive-text">Available only after you select a product category</span>
            <div id="specification" class="card-body hide">
                <div class="row align-items-start mb-3 input-block">

                </div>
            </div>
        </div>

        <div class="card card-body inactive-content">
            <h3 class="font-weight-bold title-create mb-3">Sales Information</h3>
            <span class="inactive-text">Available only after you select a product category</span>
            <div id="sales" class="card-body hide">
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Market Price</span><span
                            class="required-text ml-1">*</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input id="product" type="number" name="market_price" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Price</span><span
                            class="required-text ml-1">*</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input id="product" type="number" name="price" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Sale Price</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input id="product" type="number" name="sale_price" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Quantity</span><span
                            class="required-text ml-1">*</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <input id="product" type="number" name="quantity" class="form-control" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid pb-3">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-success w-100 py-3">Create</button>
        </div>
    </form>
@endsection
