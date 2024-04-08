<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function home(Request $request)
    {
        $orders = Order::where(function ($query) use ($request) {
            $query->orWhere('code', 'like', '%' . $request->kw . '%');
        })->orderBy('created_at', 'desc');

        $orders = $orders->paginate($request->limit ?? 10);

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
        $customers = User::whereHas('role', function ($query) {
            $query->where("name", "=", "customer");
        })->get();

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