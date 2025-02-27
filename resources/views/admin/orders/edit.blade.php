@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <form action="" method="POST">
        <div class="row">
            <div class="col-sm-8 col-12">
                <div class="card card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6 col-12 mb-3">
                            <label for="" class="form-label">Customer:</label>
                            <select disabled class="form-control select2" name="customer_id" style="width: 100%;">
                                <option selected value="{{ $order->customer->id }}">{{ $order->customer->email }}</option>
                            </select>
                            @error('customer_id')
                                <span class="d-block" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6 col-12 mb-3">
                            <label for="" class="form-label">Order Status:</label>
                            <select name="order_status" class="form-control">
                                @if (config('constants.order_status') && count(config('constants.order_status')))
                                    @foreach (config('constants.order_status') as $status)
                                        <option
                                            {{ (old('order_status') ? old('order_status') == $status['value'] : $status['value'] == $order->status) ? 'selected' : '' }}
                                            value="{{ $status['value'] }}">{{ $status['title'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('order_status')
                                <span class="d-block" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <label for="" class="form-label mb-0">
                                Products:
                            </label>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td width='52%' class="py-0" style="border: none">
                                                @error('product_id')
                                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td width='30%' class="py-0" style="border: none">
                                                @error('quantity')
                                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td class="py-0" style="border: none"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table id="cartOrder" class="table table-bordered">
                                    <tbody>
                                        @if ($order->orders_products && count($order->orders_products))
                                            @foreach ($order->orders_products as $order_product)
                                                <tr data-product='{{ $order_product->product->id }}'>
                                                    <td class='align-middle'>
                                                        <div class='row'>
                                                            <div
                                                                class='ml-lg-2 mx-auto d-flex justify-content-lg-start justify-content-center'>
                                                                @if ($order_product->product->images && count($order_product->product->images))
                                                                    @foreach ($order_product->product->images as $image)
                                                                        @if ($image->pin)
                                                                            <img class='float-left table-img'
                                                                                src="{{ asset($image->thumbnail) }}"
                                                                                alt="{{ $order_product->product->name }}">
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div style="flex: 1"
                                                                class='ml-lg-1 ml-0 row text-sm-left text-center'>
                                                                <div class='col-12'>
                                                                    @if (!$order_product->product->deleted_at)
                                                                        <a class="product-name"
                                                                            href="{{ route('admin.products.details', [$order_product->product->id]) }}">{{ $order_product->product->name }}</a>
                                                                    @else
                                                                        {{ $order_product->product->name }}
                                                                    @endif
                                                                    <input type="hidden" name="product_id[]"
                                                                        value="{{ $order_product->product->id }}">
                                                                </div>
                                                                <div class='col-12'>
                                                                    <span>Current:
                                                                        <span style='color:red'>
                                                                            @convertCurrency($order_product->product->sale_price ?? $order_product->product->price)</span>
                                                                        @if ($order_product->product->sale_price)
                                                                            <span
                                                                                style='color:#333; text-decoration:line-through;font-size:14px;'>
                                                                                @convertCurrency($order_product->product->price)
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                    <span class="d-block">
                                                                        Order price: <span
                                                                            style='color:red'>@convertCurrency($order_product->price)</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width='30%' class='align-middle'>
                                                        <input type="number" class="form-control" min="1"
                                                            name="quantity[]" value="{{ $order_product->quantity }}"
                                                            placeholder="Quantity...">
                                                        <input type="hidden" class="form-control" name="priceProduct"
                                                            value="{{ $order_product->price }}">
                                                    </td>
                                                    <td class='align-middle'>
                                                        <button type="button" class="btn btn-danger removeSelectProduct">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Shipping Address:</label>
                        <div class="row">
                            <div class="col-sm-6 col-12 mb-3">
                                <select class="form-control"
                                    old-data="{{ old('province') ?? $order->shipping_address->province }}"
                                    name="province"></select>
                                @error('province')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 col-12 mb-3">
                                <select class="form-control"
                                    old-data="{{ old('district') ?? $order->shipping_address->district }}"
                                    name="district"></select>
                                @error('district')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 col-12 mb-3">
                                <select class="form-control"
                                    old-data="{{ old('ward') ?? $order->shipping_address->ward }}"
                                    name="ward"></select>
                                @error('ward')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 col-12 mb-3">
                                <input class="form-control" name="address" placeholder="Address..."
                                    value="{{ old('address') ?? $order->shipping_address->address }}"></input>
                                @error('address')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-12 mb-3">
                                <input class="form-control" name="note" placeholder="Note..."
                                    value="{{ old('note') ?? $order->shipping_address->note }}"></input>
                                @error('note')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-12 mb-3">
                            <label for="" class="form-label mb-0">Payment Method:</label>
                            @if (config('constants.payment_method') && count(config('constants.payment_method')))
                                @foreach (config('constants.payment_method') as $index => $method)
                                    <div class="mt-2">
                                        <input
                                            {{ (old('payment_method') ?? $order->payment_method) != '' && (old('payment_method') ?? $order->payment_method) == $method['value'] ? 'checked' : '' }}
                                            id="{{ $index }}" type="radio" name="payment_method"
                                            value="{{ $method['value'] }}">
                                        <label style="font-weight: 400;" class="mb-0"
                                            for="{{ $index }}">{{ $method['title'] }}</label>
                                    </div>
                                @endforeach
                            @endif
                            @error('payment_method')
                                <span class="d-block" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6 col-12 mb-3">
                            <label for="" class="form-label">Payment Status:</label>
                            <select class="form-control" name="payment_status">
                                @if (config('constants.payment_status') && count(config('constants.payment_status')))
                                    @foreach (config('constants.payment_status') as $status)
                                        <option
                                            {{ (old('payment_status') ?? $order->payment_status) == $status['value'] ? 'selected' : '' }}
                                            value="{{ $status['value'] }}">{{ $status['title'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('payment_status')
                                <span class="d-block" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="card" id="orderSummaryCard">
                    <div class="card-header">
                        Order Summary
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                Subtotal
                            </div>
                            <div class="col-6 text-right">
                                <input type="hidden" id="subtotalPriceInput" value="{{ $order->sub_total }}">
                                <span>@convertCurrency($order->sub_total)</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                Shipping Fee
                            </div>
                            <div class="col-6 text-right shippingFeeInput">
                                <input type="hidden" id="shippingFeeInput"
                                    value="{{ config('constants.shipping_fee') }}">
                                <span>@convertShippingFee($order->shipping_fee)</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                Total
                            </div>
                            <div class="col-6 text-right totalPriceInput">
                                <input type="hidden" id="totalPriceInput" value="{{ $order->total }}">
                                <span>@convertCurrency($order->total)</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row actions-block">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" value="{{ $order->id }}">

                            <div class="col-lg-6 col-12 mb-3 back-btn"><a class="btn btn-danger w-100 py-2"
                                    href="/admin/orders">Back</a>
                            </div>
                            <div class="col-lg-6 col-12 mb-3 keepon-btn"><button type="submit"
                                    class="btn btn-success w-100 py-2">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
