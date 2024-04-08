@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif

@extends('layouts.admin.index')
@section('content')
    <div class="card card-body">
        <form action="" method="POST">
            <div class="row mb-3">
                <div class="col-sm-6 col-12">
                    <label for="" class="form-label">Customer:</label>
                    <select name="customer_id" class="form-control">
                        <option selected disabled value="">Select customer</option>
                        @if ($customers && count($customers))
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->email }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="" class="form-label mb-3">
                        <span>Products:</span>
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal"
                            data-target="#modal-searchProduct">+</button>
                    </label>
                    <div class="table-responsive">
                        <table id="cartOrder" class="w-100">
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="" class="form-label mb-3">
                        <span>Delivery Details:</span>
                    </label>
                </div>
            </div>

            <div class="d-grid">
                @csrf
                <button type="submit" class="btn btn-success w-100 py-2">Create</button>
            </div>
        </form>
    </div>

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
                    <button id="searchProduct-btn" class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </div>
    </div>
@endsection
