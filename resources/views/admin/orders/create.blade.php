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
                            <label for="" class="form-label"><span>Customer:</span></label>
                            <select class="form-control select2" name="customer_id" style="width: 100%;">
                                <option selected disabled value="">Select customer</option>
                                @if ($customers && count($customers))
                                    @foreach ($customers as $customer)
                                        <option {{ old('customer_id') == $customer->id ? 'selected' : '' }}
                                            value="{{ $customer->id }}">{{ $customer->email }}</option>
                                    @endforeach
                                @endif
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
                                            {{ (old('order_status') ? old('order_status') == $status['value'] : $status['value'] == config('constants.order_status.pending')['value']) ? 'selected' : '' }}
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
                            <button type="button" class="btn btn-primary ml-3" data-toggle="modal"
                                data-target="#modal-searchProduct">Add Product</button>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Shipping Address:</label>
                        <div class="row">
                            <div class="col-sm-6 col-12 mb-3">
                                <select class="form-control" old-data="{{ old('province') }}" name="province"></select>
                                @error('province')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 col-12 mb-3">
                                <select class="form-control" old-data="{{ old('district') }}" name="district"></select>
                                @error('district')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 col-12 mb-3">
                                <select class="form-control" old-data="{{ old('ward') }}" name="ward"></select>
                                @error('ward')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 col-12 mb-3">
                                <input class="form-control" name="address" placeholder="Address..."
                                    value="{{ old('address') }}"></input>
                                @error('address')
                                    <span class="d-block" style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-12 mb-3">
                                <input class="form-control" name="note" placeholder="Note..."
                                    value="{{ old('note') }}"></input>
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
                                            {{ old('payment_method') != '' && old('payment_method') == $method['value'] ? 'checked' : '' }}
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
                            <select name="payment_status" class="form-control">
                                @if (config('constants.payment_status') && count(config('constants.payment_status')))
                                    @foreach (config('constants.payment_status') as $status)
                                        <option
                                            {{ (old('payment_status') ? old('payment_status') == $status['value'] : $status['value'] == config('constants.payment_status.pending')['value']) ? 'selected' : '' }}
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
                                <input type="hidden" id="subtotalPriceInput" value="0">
                                <span>0&nbsp;₫</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                Shipping Fee
                            </div>
                            <div class="col-6 text-right shippingFeeInput">
                                <input type="hidden" id="shippingFeeInput"
                                    value="{{ config('constants.shipping_fee') }}">
                                @convertShippingFee(config('constants.shipping_fee'))
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                Total
                            </div>
                            <div class="col-6 text-right totalPriceInput">
                                <input type="hidden" id="totalPriceInput" value="0">
                                <span>0&nbsp;₫</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 py-2">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="modal fade" id="modal-searchProduct" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" name="code" placeholder="Code...">
                    <span class="error-message" style="color: red"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="searchProduct-btn" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
    </div>
@endsection
