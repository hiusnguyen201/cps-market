<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">

@if (session('success'))
    <input hidden type="text" name="message-success" value="{{ session('success') }}">
@endif
@if (session('error'))
    <input hidden type="text" name="message-error" value="{{ session('error') }}">
@endif
@extends('layouts.admin.index')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <a href="/admin/orders">
                    <div class="inner pt-4 pb-3 px-2">
                        <h3 style="font-size: 1.4rem">{{ $newOrders }}</h3>
                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <a href="/admin/products">
                    <div class="inner pt-4 pb-3 px-2">
                        <h3 style="font-size: 1.4rem">@convertCurrency($totalIncome)</h3>
                        <p>Total Income</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <a href="/admin/products">
                    <div class="inner pt-4 pb-3 px-2">
                        <h3 style="font-size: 1.4rem">@convertCurrency($totalExpense)</h3>
                        <p>Total Expense</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <a href="/admin/customers">
                    <div class="inner pt-4 pb-3 px-2">
                        <h3 style="font-size: 1.4rem">{{ $newCustomers }}</h3>
                        <p>New Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <section class="col-lg-7 connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Sales
                    </h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                            <canvas id="revenue-chart-canvas" data="{{ $dataRevenueInYear }}" height="300"
                                style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Sale -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-3">
                        <i class="fas fa-cubes mr-1"></i>
                        Top Selling Products
                    </h3>
                    <div class="card-tools mt-2">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#topselling-yearly" data-toggle="tab">Yearly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#topselling-monthly" data-toggle="tab">Monthly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#topselling-weekly" data-toggle="tab">Weekly</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="chart tab-pane active" id="topselling-yearly"
                            style="position: relative; min-height: 300px;">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Sold</th>
                                            <th>Profit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bestSalesYearly && count($bestSalesYearly))
                                            @foreach ($bestSalesYearly as $product)
                                                <tr style="font-size: 14px">
                                                    <td class="align-middle">
                                                        <div class="row align-items-center">
                                                            <a href="/admin/products/details/{{ $product->id }}"
                                                                class="mx-1">
                                                                @foreach ($product->images as $image)
                                                                    @if ($image->pin)
                                                                        <img style="width:40px; height:50px"
                                                                            src="{{ asset($image->thumbnail) }}"
                                                                            class="float-left table-img" alt="">
                                                                    @endif
                                                                @endforeach
                                                            </a>
                                                            <a href="/admin/products/details/{{ $product->id }}"
                                                                class="mx-1">{{ $product->name }}</a>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a
                                                            href="/admin/categories/details/{{ $product->category_id }}">{{ $product->category->name }}</a>
                                                    </td>
                                                    <td class="align-middle">@convertCurrency($product->sale_price ?? $product->price)</td>
                                                    <td class="align-middle">{{ $product->sold }}</td>
                                                    <td class="align-middle">
                                                        @php
                                                            $profit = 0;
                                                            foreach ($product->orders_products as $order_product) {
                                                                $profit +=
                                                                    $order_product->quantity *
                                                                    ($order_product->price -
                                                                        $order_product->market_price);
                                                            }
                                                        @endphp
                                                        @convertCurrency($profit)
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="topselling-monthly"
                            style="position: relative; min-height: 300px;">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Sold</th>
                                            <th>Profit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bestSalesMonthly && count($bestSalesMonthly))
                                            @foreach ($bestSalesMonthly as $product)
                                                <tr style="font-size: 14px">
                                                    <td class="align-middle">
                                                        <div class="row align-items-center">
                                                            <a href="/admin/products/details/{{ $product->id }}"
                                                                class="mx-1">
                                                                @foreach ($product->images as $image)
                                                                    @if ($image->pin)
                                                                        <img style="width:40px; height:50px"
                                                                            src="{{ asset($image->thumbnail) }}"
                                                                            class="float-left table-img" alt="">
                                                                    @endif
                                                                @endforeach
                                                            </a>
                                                            <a href="/admin/products/details/{{ $product->id }}"
                                                                class="mx-1">{{ $product->name }}</a>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a
                                                            href="/admin/categories/details/{{ $product->category_id }}">{{ $product->category->name }}</a>
                                                    </td>
                                                    <td class="align-middle">@convertCurrency($product->sale_price ?? $product->price)</td>
                                                    <td class="align-middle">{{ $product->sold }}</td>
                                                    <td class="align-middle">
                                                        @php
                                                            $profit = 0;
                                                            foreach ($product->orders_products as $order_product) {
                                                                $profit +=
                                                                    $order_product->quantity *
                                                                    ($order_product->price -
                                                                        $order_product->market_price);
                                                            }
                                                        @endphp
                                                        @convertCurrency($profit)
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="topselling-weekly"
                            style="position: relative; min-height: 300px;">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Sold</th>
                                            <th>Profit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bestSalesWeekly && count($bestSalesWeekly))
                                            @foreach ($bestSalesWeekly as $product)
                                                <tr style="font-size: 14px">
                                                    <td class="align-middle">
                                                        <div class="row align-items-center">
                                                            <a href="/admin/products/details/{{ $product->id }}"
                                                                class="mx-1">
                                                                @foreach ($product->images as $image)
                                                                    @if ($image->pin)
                                                                        <img style="width:40px; height:50px"
                                                                            src="{{ asset($image->thumbnail) }}"
                                                                            class="float-left table-img" alt="">
                                                                    @endif
                                                                @endforeach
                                                            </a>
                                                            <a href="/admin/products/details/{{ $product->id }}"
                                                                class="mx-1">{{ $product->name }}</a>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a
                                                            href="/admin/categories/details/{{ $product->category_id }}">{{ $product->category->name }}</a>
                                                    </td>
                                                    <td class="align-middle">@convertCurrency($product->sale_price ?? $product->price)</td>
                                                    <td class="align-middle">{{ $product->sold }}</td>
                                                    <td class="align-middle">
                                                        @php
                                                            $profit = 0;
                                                            foreach ($product->orders_products as $order_product) {
                                                                $profit +=
                                                                    $order_product->quantity *
                                                                    ($order_product->price -
                                                                        $order_product->market_price);
                                                            }
                                                        @endphp
                                                        @convertCurrency($profit)
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <!-- TO DO List -->
            <div hidden class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        To Do List
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <ul id="todo-list" class="todo-list ui-sortable" data-widget="todo-list"
                        style="overflow: auto; height:274px">
                        <li>
                            <!-- drag handle -->
                            <span class="handle ui-sortable-handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                            <!-- checkbox -->
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="" name="todo2" id="todoCheck1">
                                <label for="todoCheck1"></label>
                            </div>
                            <!-- todo text -->
                            <span class="text">Design a nice theme</span>
                            <!-- Emphasis label -->
                            <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="done">
                            <span class="handle ui-sortable-handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">
                                <label for="todoCheck2"></label>
                            </div>
                            <span class="text">Make the theme responsive</span>
                            <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                            <div class="tools">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                            <span class="handle ui-sortable-handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="" name="todo3" id="todoCheck3">
                                <label for="todoCheck3"></label>
                            </div>
                            <span class="text">Let theme shine like a star</span>
                            <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                            <div class="tools">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                            <span class="handle ui-sortable-handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="" name="todo4" id="todoCheck4">
                                <label for="todoCheck4"></label>
                            </div>
                            <span class="text">Let theme shine like a star</span>
                            <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                            <div class="tools">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                            <span class="handle ui-sortable-handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="" name="todo5" id="todoCheck5">
                                <label for="todoCheck5"></label>
                            </div>
                            <span class="text">Check your messages and notifications</span>
                            <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                            <div class="tools">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                            <span class="handle ui-sortable-handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="" name="todo6" id="todoCheck6">
                                <label for="todoCheck6"></label>
                            </div>
                            <span class="text">Let theme shine like a star</span>
                            <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                            <div class="tools">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash-o"></i>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <button id="add-todo-btn" type="button" class="btn btn-primary float-right"><i
                            class="fas fa-plus"></i> Add
                        item</button>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Visitors
                    </h3>
                    <!-- card tools -->
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                            title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <div id="world-map" style="height: 250px; width: 100%;"></div>
                </div>
            </div>
            <!-- /.card -->

            <!-- solid sales graph -->
            <div class="card bg-gradient-info">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-th mr-1"></i>
                        Sales Graph
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas class="chart" id="line-chart" data="{{ $totalOrdersCompleted }}"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card -->

            <!-- Calendar -->
            <div class="card bg-gradient-success">
                <div class="card-header border-0">

                    <h3 class="card-title">
                        <i class="far fa-calendar-alt"></i>
                        Calendar
                    </h3>
                    <!-- tools card -->
                    <div class="card-tools">
                        <!-- button with a dropdown -->
                        {{-- <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                                data-offset="-52">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a href="#" class="dropdown-item">Add new event</a>
                                <a href="#" class="dropdown-item">Clear events</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">View calendar</a>
                            </div>
                        </div> --}}
                        <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body pt-0">
                    <!--The calendar -->
                    <div id="calendar" style="width: 100%"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
@endsection

<!-- ChartJS -->
<script defer src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script defer src="{{ asset('adminlte/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script defer src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script defer src="{{ asset('adminlte/plugins/jqvmap/maps/continents/jquery.vmap.asia.js') }}"></script>
<!-- jQuery Knob Chart -->
<script defer src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script defer src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
<script defer src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script defer src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
</script>
<!-- Summernote -->
<script defer src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script defer src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script defer src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>
