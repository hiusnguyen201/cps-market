@extends('layouts.admin.index')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-12 mb-3">
            <div class="card card-body h-100">
                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Code:</label>
                    <div class="col-sm-8">
                        {{ $order->code }}
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label for="inputCategory" class="col-sm-4 col-form-label">Customer:</label>
                    <div class="col-sm-8">
                        @if (!$order->customer->deleted_at)
                            <a
                                href="{{ route('admin.customers.details', [$order->customer->id]) }}">{{ $order->customer->name }}</a>
                        @else
                            {{ $order->customer->name }}
                        @endif
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Created At:</label>
                    <div class="col-sm-8">
                        {{ date(config('constants.date_format'), strtotime($order->created_at)) }}
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Updated At:</label>
                    <div class="col-sm-8">
                        {{ date(config('constants.date_format'), strtotime($order->updated_at)) }}
                    </div>
                </div>


                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Payment Status:</label>
                    <div class="col-sm-8">
                        @if (config('constants.payment_status') && count(config('constants.payment_status')))
                            @foreach (config('constants.payment_status') as $status)
                                @if ($order->payment_status == $status['value'])
                                    <span class="{{ $status['css'] }}">{{ $status['title'] }}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Order Status:</label>
                    <div class="col-sm-8">
                        @if (config('constants.order_status') && count(config('constants.order_status')))
                            @foreach (config('constants.order_status') as $status)
                                @if ($order->status == $status['value'])
                                    <span class="{{ $status['css'] }}">{{ $status['title'] }}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-12 mb-3">
            <div class="card card-body h-100">
                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Payment Method:</label>
                    <div class="col-sm-8">
                        @if (config('constants.payment_method') && count(config('constants.payment_method')))
                            @foreach (config('constants.payment_method') as $method)
                                @if ($method['value'] == $order->payment_method)
                                    {{ $method['title'] }}
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label for="inputCategory" class="col-sm-4 col-form-label">Quantity:</label>
                    <div class="col-sm-8">
                        {{ $order->quantity }}
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Sub Total:</label>
                    <div class="col-sm-8">
                        @convertCurrency($order->sub_total)
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Shipping Fee:</label>
                    <div class="col-sm-8">
                        @convertCurrency($order->shipping_fee)
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label class="col-sm-4 col-form-label">Total:</label>
                    <div class="col-sm-8">
                        @convertCurrency($order->total)
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col-sm-6 col-12 mb-3">
            <div class="card card-body h-100">
                <div class="table-responsive">
                    <table class="table talbe-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Item
                                </th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($order->orders_products && count($order->orders_products))
                                @foreach ($order->orders_products as $order_product)
                                    <tr>
                                        <td class="align-middle">
                                            <div
                                                class="row align-items-center justify-content-center justify-content-md-start">
                                                <div class="col-lg-3 col-12 d-flex">
                                                    @foreach ($order_product->product->images as $image)
                                                        @if ($image->pin)
                                                            @if (!$order_product->product->deleted_at)
                                                                <a class="ml-auto mr-auto"
                                                                    href="/admin/products/details/{{ $order_product->product->id }}">
                                                                    <img src="{{ asset($image->thumbnail) }}"
                                                                        class="float-left table-img" alt="">
                                                                </a>
                                                            @else
                                                                <img src="{{ asset($image->thumbnail) }}"
                                                                    class="float-left table-img" alt="">
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <div class="col-lg-9 col-12">
                                                    @if (!$order_product->product->deleted_at)
                                                        <a class="product-name" style="color: #007bff"
                                                            href="/admin/products/details/{{ $order_product->product->id }}">{{ $order_product->product->name }}</a>
                                                    @else
                                                        {{ $order_product->product->name }}
                                                    @endif

                                                    <span style="color: red">@convertCurrency($order_product->product->sale_price ?? $order_product->product->price)</span>
                                                    @if ($order_product->product->sale_price)
                                                        <span
                                                            style="color:#333; font-size:14px;text-decoration: line-through">@convertCurrency($order_product->product->price)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td width='10%' class="align-middle">
                                            {{ $order_product->quantity }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-12 mb-3">
            <div class="card card-body h-100">
                <label class="col-form-label">Shipping Address:</label>
                <div class="table-responsive">
                    <table class="table talbe-bordered">
                        <tbody>
                            <tr>
                                <td>Customer Name:</td>
                                <td>{{ $order->shipping_address->customer_name }}</td>
                            </tr>
                            <tr>
                                <td>Customer Email:</td>
                                <td>{{ $order->shipping_address->customer_email }}</td>
                            </tr>
                            <tr>
                                <td>Customer Phone:</td>
                                <td>{{ $order->shipping_address->customer_phone }}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>
                                    <input hidden type="text" id="wardName" disabled
                                        data="{{ $order->shipping_address->ward }}">
                                    <input hidden type="text" id="districtName" disabled
                                        data="{{ $order->shipping_address->district }}">
                                    <input hidden id="provinceName" disabled
                                        data='{{ $order->shipping_address->province }}' type="text">
                                    <span id="addressShipping">{{ $order->shipping_address->address }}</span>
                                </td>
                            </tr>
                            @if ($order->shipping_address->note)
                                <tr>
                                    <td>Note:</td>
                                    <td>{{ $order->shipping_address->note }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <a href="/admin/orders" class="btn btn-danger py-2 w-100 mb-3">Back</a>
@endsection
