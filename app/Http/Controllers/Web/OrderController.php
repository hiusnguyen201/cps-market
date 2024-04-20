<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\OrderRequest;

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
        if (!count($orders) && +$request->page > 1) {
            return redirect()->route('admin.orders.home', ['page' => +$request->page - 1]);
        }

        return view('admin.orders.home', [
            'breadcumbs' => ['titles' => ['Orders']],
            'title' => 'Manage Orders',
            "orders" => $orders,
        ]);
    }
    public function details(Order $order)
    {
        return view('admin.orders.details', [
            'order' => $order,
            'breadcumbs' => [
                'titles' => ['Orders', 'Details'],
                'title_links' => [route("admin.orders.home")]
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
                'title_links' => [route("admin.orders.home")]
            ],
            'title' => 'Create Order',
            'customers' => $customers
        ]);
    }
    public function handleCreate(OrderRequest $request)
    {
        try {
            $customer = $this->userService->findOneById($request->customer_id);
            $this->orderService->createOrderInAdmin($request, $customer);
            session()->flash("success", "Create order successfully");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
        }

        return redirect("/admin/orders/create");
    }
    public function edit(Order $order)
    {
        $customers = $this->userService->findAllWithRole("customer");
        return view('admin.orders.edit', [
            'order' => $order,
            'breadcumbs' => [
                'titles' => ['Orders', 'Edit'],
                'title_links' => [route("admin.orders.home")]
            ],
            'title' => 'Edit Order',
            "customers" => $customers
        ]);
    }

    public function handleUpdate(OrderRequest $request, Order $order)
    {
        try {
            $customer = $this->userService->findOneById($request->customer_id);
            $this->orderService->updateOrderInAdmin($request, $customer, $order);
            session()->flash("success", "Edit order successfully");
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash("error", $e->getMessage());
        }

        return redirect("/admin/orders/edit/" . $order->id);
    }

    public function handleDelete(Request $request)
    {
        try {
            $ids = is_array($request->id) ? $request->id : [$request->id];
            $this->orderService->deleteOrders($ids);
            session()->flash('success', 'Delete order successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/admin/orders");
    }
}
