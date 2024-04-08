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
                        <button type="button" class="btn btn-primary ml-3" id="addCartBtn">+</button>
                    </label>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="" class="form-label mb-3">
                        <span>Delivery Details:</span>
                        <button type="button" class="btn btn-primary ml-3" id="addCartBtn">+</button>
                    </label>
                </div>
            </div>

            <div class="d-grid">
                @csrf
                <button type="submit" class="btn btn-success w-100 py-2">Create</button>
            </div>
        </form>
    </div>
@endsection
