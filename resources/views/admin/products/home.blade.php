@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card py-3 px-3">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <a href="/admin/products/create" class="btn btn-success w-100 py-2">Create</a>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <button class="btn btn-danger w-100 py-2" data-toggle="modal" data-target="#modal-deleteAll">Delete
                    All</button>
            </div>
        </div>

        <form action="" method="GET">
            <div class="row">
                <div class="col-lg-2 col-4 mb-3">
                    <select name="limit" class="form-control">
                        @if (config('constants.limit_page') && count(config('constants.limit_page')))
                            @foreach (config('constants.limit_page') as $limit)
                                <option {{ request()->limit == $limit ? 'selected' : '' }} value="{{ $limit }}">
                                    {{ $limit }}
                                </option>
                            @endforeach
                        @else
                            <option selected value="10">10</option>
                        @endif
                    </select>
                </div>

                <div class="col-lg-3 col-8 mb-3">
                    <select name="category" class="form-control">
                        <option value="">All Category</option>
                        @if (count($categories))
                            @foreach ($categories as $category)
                                <option {{ request()->category == $category->id ? 'selected' : '' }}
                                    value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-lg-4 col-12 mb-3 ml-auto">
                    <div class="form-group d-flex mb-0">
                        <input class="form-control" name="keyword" id="" placeholder="Search by keyword"
                            value="{{ request()->keyword }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <table id="dataTable" name='products' class="display mb-3" style="width:100%">
            <thead>
                <tr>
                    <th width='1%'></th>
                    <th>Name</th>
                    <th width="1%">
                        <input type="checkbox" class="form-check-input" id="selectAll">
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($products && count($products))
                    @foreach ($products as $product)
                        @php
                            $imgSrc = null;
                            foreach ($product->images as $image) {
                                if ($image->pin) {
                                    $imgSrc = asset($image->thumbnail);
                                }
                            }
                        @endphp
                        <tr data-row='{{ $product->id }}' data-child-name="Image|Code|Category|Price|Quantity|Sold"
                            data-child-value="<img src='{{ $imgSrc }}' class='table-img d-block' alt='{{ $product->name }}'>|{{ $product->code }}|<a
                                        href='/admin/categories/details/{{ $product->category->id }}'>{{ $product->category->name }}</a>|@convertCurrency($product->sale_price ?? $product->price)|{{ $product->quantity > 0 ? $product->quantity : 'Out of stock' }}|{{ $product->sold }}">
                            <td></td>
                            <td><a style="color: #007bff" class="product-name"
                                    href="/admin/products/details/{{ $product->id }}">{{ $product->name }}</a></td>
                            <td>
                                <input type="checkbox" class="form-check-input" style="margin-top: 10px" name="id"
                                    value="{{ $product->id }}">
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="table-responsive mb-3">
            <table id="normalTable" class="home-table table table-hover">
                <thead>
                    <tr>
                        <th width='1%'>
                            <input type="checkbox" class="form-check-input-lg" id="selectAll-lg">
                        </th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sold</th>
                        <th width='1%'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products && count($products))
                        @foreach ($products as $product)
                            <tr>
                                <td class="align-middle">
                                    <input type="checkbox" class="form-check-input-lg" name="id"
                                        value="{{ $product->id }}">
                                </td>
                                <td class="align-middle">
                                    <div class="row align-items-center" style="flex-wrap: nowrap">
                                        <a href="/admin/products/details/{{ $product->id }}" class="mx-1">
                                            @foreach ($product->images as $image)
                                                @if ($image->pin)
                                                    <img src="{{ asset($image->thumbnail) }}" class="float-left table-img"
                                                        alt="{{ $product->name }}">
                                                @endif
                                            @endforeach
                                        </a>
                                        <div class="ml-2" style="max-width: 400px">
                                            <a style="color: #007bff" href="/admin/products/details/{{ $product->id }}"
                                                class="product-name">{{ $product->name }}</a>
                                        </div>
                                    </div>
                                    <span class="d-block">Code: {{ $product->code }}</span>
                                </td>
                                <td class="align-middle">
                                    @if (!$product->category->deleted_at)
                                        <a
                                            href="/admin/categories/details/{{ $product->category->id }}">{{ $product->category->name }}</a>
                                    @else
                                        {{ $product->category->name }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @convertCurrency($product->sale_price ?? $product->price)
                                </td>
                                <td class="align-middle">
                                    {{ $product->quantity > 0 ? $product->quantity : 'Out of stock' }}
                                </td>
                                <td class="align-middle">
                                    {{ $product->sold }}
                                </td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-warning" href="/admin/products/edit/{{ $product->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger mt-2" data-toggle="modal"
                                        data-target="#modal-delete-{{ $product->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-delete-{{ $product->id }}" aria-modal="true"
                                role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Warning!</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you really want delete?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <form action="" method="POST">
                                                <input type="hidden" name="id" value="{{ $product->id }}">
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                                <input type="hidden" name="_method" value="delete">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Paginate -->
        @if (count($products))
            <div class="d-flex ml-auto">
                {{ $products->appends(Request::all())->links() }}
            </div>
        @endif
    </div>

    <!-- Modal delete -->
    <div class="modal fade" id="modal-deleteAll" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Warning!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you really want delete?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <form class="form-delete-all" action="" method="POST">
                        <button class="btn btn-primary btn-deleteAll" type="submit">Submit</button>
                        <input type="hidden" name="_method" value="delete">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
