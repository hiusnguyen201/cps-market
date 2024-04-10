<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\OrderService;
use App\Services\UserService;

use App\Models\Order;

class OrderController extends Controller
{
    private OrderService $orderService;
    private UserService $userService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->userService = new UserService();
    }

    public function home(Request $request)
    {
        $orders = $this->orderService->findAllAndPaginate($request);
        return view('admin.orders.home', [
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Orders']],
            'title' => 'Manage Orders',
            "orders" => $orders
        ]);
    }
    public function details(Order $order)
    {
        return view('admin.orders.details', [
            'order' => $order,
            'breadcumbs' => [
                'titles' => ['Orders', 'Details'],
                'title_links' => ["/admin/orders"]
            ],
            'title' => 'Details Order',
        ]);
    }
    public function create()
    {
        $customers = $this->userService->findAllWithRole("customer");
        return view('admin.orders.create', [
            'breadcumbs' => [
                'titles' => ['Orders', 'Create'],
                'title_links' => ["/admin/orders"]
            ],
            'title' => 'Create Order',
            'customers' => $customers
        ]);
    }
    public function handleCreate()
    {

    }
    public function edit()
    {

    }
    public function handleUpdate()
    {

    }
    public function handleDelete()
    {

    }
}