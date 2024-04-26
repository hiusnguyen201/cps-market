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
            <div class="col-lg-3 col-12 mb-3">
                <a href="{{ route('admin.orders.create') }}" class="btn btn-success w-100 py-2">Create</a>
            </div>
            <div class="col-lg-3 col-12 mb-3">
                <button class="btn btn-danger w-100 py-2" data-toggle="modal" data-target="#modal-deleteAll">Delete
                    All</button>
            </div>
        </div>

        <form action="" method="GET">
            <div class="row">
                <div class="col-lg-2 col-4 mb-3">
                    <select name="limit" id="" class="form-control">
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
                    <select name="status" id="" class="form-control">
                        <option selected value="">All status</option>
                        @if (config('constants.order_status') && count(config('constants.order_status')))
                            @foreach (config('constants.order_status') as $status)
                                <option {{ request()->status == $status['value'] ? 'selected' : '' }}
                                    value="{{ $status['value'] }}">
                                    {{ $status['title'] }}
                                </option>
                            @endforeach
                        @else
                            <option selected value="10">10</option>
                        @endif
                    </select>
                </div>

                <div class="col-lg-4 col-12 mb-3 ml-auto">
                    <div class="form-group d-flex mb-0">
                        <input class="form-control" name="keyword" id="" placeholder="Search by code"
                            value="{{ request()->keyword }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <table id="dataTable" name='orders' class="display mb-3" style="width:100%">
            <thead>
                <tr>
                    <th width='1%'></th>
                    <th>Code</th>
                    <th width="1%">
                        <input type="checkbox" class="form-check-input" id="selectAll">
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($orders && count($orders))
                    @foreach ($orders as $order)
                        @php
                            $orderStatus = null;
                            if (config('constants.order_status') && count(config('constants.order_status'))) {
                                foreach (config('constants.order_status') as $status) {
                                    if ($order->status == $status['value']) {
                                        $orderStatus = $status;
                                    }
                                }
                            }
                        @endphp
                        <tr data-row='{{ $order->id }}' data-child-name="Date|Customer|Quantity|Price|Status"
                            data-child-value="{{ date(config('constants.date_format'), strtotime($order->created_at)) }}|<a
                                        href='/admin/customers/details/{{ $order->customer->id }}'>{{ $order->customer->name }}</a>|{{ $order->quantity }}|@convertCurrency($order->total)|<span class='{{ $orderStatus['css'] }}'>{{ $orderStatus['title'] }}</span>">
                            <td></td>
                            <td><a href="/admin/orders/details/{{ $order->id }}">{{ $order->code }}</a></td>
                            <td>
                                <input type="checkbox" class="form-check-input" style="margin-top: 10px" name="id"
                                    value="{{ $order->id }}">
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
                        <th>Code</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th width='1%'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders && count($orders))
                        @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle">
                                    <input type="checkbox" class="form-check-input-lg" name="id"
                                        value="{{ $order->id }}">
                                </td>
                                <td class="align-middle"><a
                                        href="{{ '/admin/orders/details/' . $order->id }}">{{ $order->code }}</a>
                                </td>
                                <td class="align-middle">
                                    {{ date(config('constants.date_format'), strtotime($order->created_at)) }}</td>
                                <td class="align-middle"><a
                                        href="/admin/customers/details/{{ $order->customer->id }}">{{ $order->customer->name }}</a>
                                </td>
                                <td class="align-middle">{{ $order->quantity }}</td>
                                <td class="align-middle">@convertCurrency($order->total)</td>
                                <td class="align-middle">
                                    @if (config('constants.order_status') && count(config('constants.order_status')))
                                        @foreach (config('constants.order_status') as $status)
                                            @if ($order->status == $status['value'])
                                                <span class="{{ $status['css'] }}">{{ $status['title'] }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-warning" href="{{ route('admin.orders.edit', [$order->id]) }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger mt-2" data-toggle="modal"
                                        data-target="#modal-delete-{{ $order->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-delete-{{ $order->id }}" aria-modal="true" role="dialog">
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
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <form action="" method="POST">
                                                <input type="hidden" name="id" value="{{ $order->id }}">
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
        @if (count($orders))
            <div class="d-flex ml-auto">
                {{ $orders->appends(Request::all())->links() }}
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
