@extends('layouts.admin.index')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="tab-content row mb-3">
                <div class="col-sm-5 col-12 table-bordered py-3">
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 mb-0">Name:</label>
                        <div class="col-sm-7">{{ $user->name }}</div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 mb-0">Email:</label>
                        <div class="col-sm-7 align-middle">
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 mb-0">Phone:</label>
                        <div class="col-sm-7">
                            {{ $user->phone }}
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 mb-0">Gender:</label>
                        <div class="col-sm-7">
                            @if (config('constants.genders') && count(config('constants.genders')))
                                @foreach (config('constants.genders') as $gender)
                                    @if ($gender['value'] == $user->status)
                                        {{ $gender['title'] }}
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 mb-0">Status:</label>
                        <div class="col-sm-7">
                            @if (config('constants.user_status') && count(config('constants.user_status')))
                                @foreach (config('constants.user_status') as $status)
                                    @if ($user->status == $status['value'])
                                        <span class="{{ $status['css'] }}">{{ $status['title'] }}</span>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 mb-0">Created At:</label>
                        <div class="col-sm-7">
                            {{ date(config('constants.date_format'), strtotime($user->created_at)) }}
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 mb-0">Updated At:</label>
                        <div class="col-sm-7">
                            {{ date(config('constants.date_format'), strtotime($user->updated_at)) }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 col-12 table-bordered py-3">
                    <label>Orders:</label>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($user->orders && count($user->orders))
                                    @foreach ($user->orders as $order)
                                        <tr>
                                            <td><a href="/admin/orders/details/{{ $order->id }}">{{ $order->code }}</a>
                                            </td>
                                            <td>
                                                {{ date(config('constants.date_format'), strtotime($order->updated_at)) }}
                                            </td>
                                            <td>
                                                @if (config('constants.order_status') && count(config('constants.order_status')))
                                                    @foreach (config('constants.order_status') as $status)
                                                        @if ($order->status == $status['value'])
                                                            <span
                                                                class="{{ $status['css'] }}">{{ $status['title'] }}</span>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <a href="/admin/customers" class="btn btn-danger py-2 w-100">Back</a>
        </div>
    </div>
@endsection
