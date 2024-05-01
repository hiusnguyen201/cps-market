@extends('layouts.admin.index')
@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">{{ $product->name }}</h3>
                    @php
                        $imagePin = $product->images
                            ->filter(function ($item) {
                                return $item->pin == 1;
                            })
                            ->first();
                    @endphp
                    <div class="col-12" style="height: 450px">
                        <img style="height: 100%;" src="{{ asset($imagePin->thumbnail) }}" class="product-image"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="col-12 mt-4" style="overflow: hidden">
                        <div class="swiper-member">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide product-image-thumb active"><img
                                        src="{{ asset($imagePin->thumbnail) }}" alt="{{ $product->name }}">
                                </div>
                                @if ($product->images && count($product->images))
                                    @foreach ($product->images as $image)
                                        @if (!$image->pin)
                                            <div style="cursor: pointer" class="swiper-slide product-image-thumb"><img
                                                    src="{{ asset($image->thumbnail) }}" alt="{{ $product->name }}">
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">{{ $product->name }}</h3>
                    <p><span style="user-select: none">#</span>{{ $product->code }}</p>
                    <hr>
                    <h4>Brand</h4>
                    <a href="/admin/brands/{{ $product->brand_id }}">{{ $product->brand->name }}</a>
                    <h4 class="mt-3">Category</h4>
                    <a href="/admin/categories/{{ $product->category_id }}">{{ $product->category->name }}</a>
                    <h4 class="mt-3">Market Price</h4>
                    <div style="font-size:24px">
                        <span>@convertCurrency($product->market_price)</span>
                    </div>
                    <h4 class="mt-3">Price</h4>
                    <div style="font-size:24px">
                        <span style="color: #ff4500" class="mr-2">@convertCurrency($product->sale_price ?? $product->price)</span>
                        @if ($product->sale_price)
                            <span style="text-decoration: line-through; font-size:18px">@convertCurrency($product->price)</span>
                        @endif
                    </div>
                    <h4 class="mt-3">Quantity</h4>
                    <div>
                        <span>{{ $product->quantity }}</span>
                    </div>
                    <h4 class="mt-3">Sold</h4>
                    <div>
                        <span>{{ $product->sold }}</span>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <nav class="w-100">
                    <div class="nav nav-tabs" id="product-tab" role="tablist">
                        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc"
                            role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                        <a class="nav-item nav-link" id="product-specifications-tab" data-toggle="tab"
                            href="#product-specifications" role="tab" aria-controls="product-specifications"
                            aria-selected="false">Specifications</a>
                    </div>
                </nav>
                <div class="tab-content p-3 w-100" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                        aria-labelledby="product-desc-tab"> {{ $product->description }}
                    </div>
                    <div class="tab-pane fade" id="product-specifications" role="tabpanel"
                        aria-labelledby="product-specifications-tab">
                        <div class="table-reponsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    @if ($product->products_attributes && count($product->products_attributes))
                                        @foreach ($product->products_attributes as $product_attribute)
                                            <tr>
                                                <td width="40%">{{ $product_attribute->attribute->key }}</td>
                                                <td>{{ $product_attribute->value }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <a href="/admin/products" class="btn btn-danger py-2 w-100">
                Back
            </a>
        </div>
    </div>
    <div class="card-body">
    </div>
@endsection
