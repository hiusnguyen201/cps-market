@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <form id="product" enctype="multipart/form-data" method="POST">
        <div class="card card-body">
            <h3 class="font-weight-bold title-create mb-3">Basic information</h3>
            <div class="card-body">
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Name</span><span class="required-text ml-1">*</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <input id="product" type="text" name="name" class="form-control"
                                placeholder="Enter product name..." value="{{ $product->name }}">
                        </div>
                    </div>
                </div>
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Product images</span></div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="multiple-input_block">
                            @if (count($product->images))
                                @foreach ($product->images as $image)
                                    @if (!$image->pin)
                                        <div class="input-file_uploaded">
                                            <img class="input-file_image" src="{{ asset($image->thumbnail) }}"
                                                alt="">
                                            <i class="far fa-file-image"></i>
                                            <span class="input-file_text">Add File</span>
                                            <input id="product" class="input-file_form" hidden type="file"
                                                name="product_images[]" multiple>
                                            <div class="remove-btn_block">
                                                <i class="fas fa-trash"></i>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                @if (count($product->images) >= 8)
                                    <div hidden class="input-file_block">
                                        <img hidden class="input-file_image">
                                        <i class="far fa-file-image"></i>
                                        <span class="input-file_text">Add File</span>
                                        <input id="product" hidden class="input-file_form" type="file"
                                            name="product_images[]" multiple>
                                        <div class="remove-btn_block">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if (count($product->images) < 8)
                                <div class="input-file_block">
                                    <img hidden class="input-file_image">
                                    <i class="far fa-file-image"></i>
                                    <span class="input-file_text">Add File</span>
                                    <input id="product" hidden class="input-file_form" type="file"
                                        name="product_images[]" multiple>
                                    <div class="remove-btn_block">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2"><span>Promotion Image</span><span
                                class="required-text ml-1">*</span></span></div>
                    <div class="col-lg-7 col-12 input-product_form">
                        @php
                            $imagePin = null;
                            for ($i = 0; $i < count($product->images); $i++) {
                                if ($product->images[$i]->pin) {
                                    $imagePin = $product->images[$i];
                                    break;
                                }
                            }
                        @endphp

                        @if ($imagePin)
                            <div class="input-file_uploaded">
                                <img class="input-file_image" src="{{ asset($imagePin->thumbnail) }}" alt="">
                                <i class="far fa-file-image"></i>
                                <span class="input-file_text">Add File</span>
                                <input id="product" hidden class="input-file_form" type="file" name="promotion_image">
                                <div class="remove-btn_block">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </div>
                        @else
                            <div class="input-file_block">
                                <img hidden class="input-file_image" src="" alt="">
                                <i class="far fa-file-image"></i>
                                <span class="input-file_text">Add File</span>
                                <input id="product" hidden class="input-file_form" type="file" name="promotion_image">
                                <div class="remove-btn_block">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </div>
                        @endif
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
                                        <option {{ $category->id == $product->category_id ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</option>
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
                            <textarea id="product" style="resize: none" name="description" class="form-control" cols="30"
                                rows="8">{{ $product->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-body {{ $product->category_id ? '' : 'inactive-content' }}">
            <h3 class="font-weight-bold title-create mb-3">Specification</h3>
            @if (!$product->category_id)
                <span class="inactive-text">Available only after you select a product category</span>
            @endif
            <div id="specification" class="card-body {{ $product->category_id ? '' : 'hide' }}">
                <div class="row align-items-start mb-3 input-block">
                    <div class='col-lg-6 col-12 row mb-3'>
                        <div class="col-lg-4 col-12"><span>Brand</span><span class="required-text ml-1">*</span></div>
                        <div class="col-lg-7 col-12 input-product_form">
                            <div class="input-group">
                                <select id="product" name="brand" class="form-control">
                                    <option value="">Please select</option>
                                    @if ($product->category && count($product->category->brands))
                                        @foreach ($product->category->brands as $brand)
                                            <option {{ $product->brand_id == $brand->id ? 'selected' : '' }}
                                                value="{{ $brand->id }}">
                                                {{ $brand->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    @if (count($attributes))
                        @foreach ($attributes as $attribute)
                            <div class='col-lg-6 col-12 row mb-3'>
                                <div class="col-lg-4 col-12"><span>{{ $attribute->key }}</span></div>
                                <div class="col-lg-7 col-12 input-product_form">
                                    <input id='product' hidden name='attribute_ids[]' value='{{ $attribute->id }}'>
                                    @php
                                        $product_attribute = $product->products_attributes
                                            ->filter(function ($product_attribute) use ($attribute) {
                                                return $product_attribute->attribute_id == $attribute->id;
                                            })
                                            ->first();
                                    @endphp
                                    <input id='product' class='form-control' name='attribute_values[]'
                                        placeholder='Please enter...'
                                        value="{{ $product_attribute ? $product_attribute->value : '' }}">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="card card-body {{ $product->category_id ? '' : 'inactive-content' }}">
            <h3 class="font-weight-bold title-create mb-3">Sales Information</h3>
            @if (!$product->category_id)
                <span class="inactive-text">Available only after you select a product category</span>
            @endif
            <div id="sales" class="card-body {{ $product->category_id ? '' : 'hide' }}">
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Market Price</span><span
                            class="required-text ml-1">*</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input id="product" type="number" name="market_price" class="form-control"
                                value="{{ $product->market_price }}">
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
                            <input id="product" type="number" name="price" class="form-control"
                                value="{{ $product->price }}">
                        </div>
                    </div>
                </div>
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Sale price</span></div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">₫</div>
                            </div>
                            <input id="product" type="number" name="sale_price" class="form-control"
                                value="{{ $product->sale_price }}">
                        </div>

                    </div>
                </div>
                <div class="row align-items-start mb-3 input-block">
                    <div class="col-lg-3 col-12"><span class="mt-2">Quantity</span><span
                            class="required-text ml-1">*</span>
                    </div>
                    <div class="col-lg-7 col-12 input-product_form">
                        <div class="input-group">
                            <input id="product" type="number" name="quantity" class="form-control"
                                value="{{ $product->quantity }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row actions-block pb-3">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{ $product->id }}">

            <div class="col-lg-6 col-12 mb-3 back-btn"><a class="btn btn-danger w-100 py-2"
                    href="/admin/products">Back</a>
            </div>
            <div class="col-lg-6 col-12 mb-3 keepon-btn"><button type="submit"
                    class="btn btn-success w-100 py-2">Save</button>
            </div>
        </div>
    </form>
@endsection
