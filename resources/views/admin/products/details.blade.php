@extends('layouts.admin.index')
@section('content')
    <section class="content">
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                        <div class="col-12">
                            @if (count($product->images))
                                @foreach ($product->images as $image)
                                    @if ($image->pin)
                                        <img src="{{ asset('storage/' . $image->thumbnail) }}" class="product-image"
                                            alt="{{ $product->name }}">
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12 product-image-thumbs">
                            @if (count($product->images))
                                @foreach ($product->images as $image)
                                    <div class="product-image-thumb {{ $image->pin ? 'active' : '' }}"><img
                                            src="{{ asset('storage/' . $image->thumbnail) }}" class="product-image"
                                            alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 col-form-label">Name:</label>
                            <div class="col-sm-8">
                                {{ $product->name }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="inputCategory" class="col-sm-4 col-form-label">Brand:</label>
                            <div class="col-sm-8">
                                <a href="/admin/brands/details/{{ $product->brand->id }}">{{ $product->brand->name }}</a>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="inputCategory" class="col-sm-4 col-form-label">Category:</label>
                            <div class="col-sm-8">
                                <a
                                    href="/admin/categories/details/{{ $product->category->id }}">{{ $product->category->name }}</a>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 col-form-label">Price:</label>
                            <div class="col-sm-8">
                                {{ $product->price }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 col-form-label">Sale Price:</label>
                            <div class="col-sm-8">
                                {{ $product->sale_price }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 col-form-label">Quantity:</label>
                            <div class="col-sm-8">
                                {{ $product->quantity }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 col-form-label">Sold:</label>
                            <div class="col-sm-8">
                                {{ $product->sold }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 col-form-label">Description:</label>
                            <div class="col-sm-8">
                                {{ $product->description }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 col-form-label">Created At:</label>
                            <div class="col-sm-8">
                                {{ date(config('constants.date_format'), strtotime($product->created_at)) }}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 col-form-label">Updated At:</label>
                            <div class="col-sm-8">
                                {{ date(config('constants.date_format'), strtotime($product->updated_at)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
