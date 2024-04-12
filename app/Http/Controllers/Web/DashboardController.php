<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\UserService;
use App\Services\ProductService;

class DashboardController extends Controller
{
    private OrderService $orderService;
    private UserService $userService;
    private ProductService $productService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->userService = new UserService();
        $this->productService = new ProductService();
    }

    public function home()
    {
        $newOrders = $this->orderService->countNewOrders();
        $newCustomers = $this->userService->countNewCustomers();
        $totalExpense = $this->productService->calculateTotalExpense();
        $totalIncome = $this->orderService->calculateTotalIncome();

        return view("admin.dashboard.home", [
            'breadcumbs' => ['titles' => ['Dashboard']],
            'title' => 'Dashboard',
            'newOrders' => $newOrders,
            'newCustomers' => $newCustomers,
            'totalExpense' => $totalExpense,
            'totalIncome' => $totalIncome
        ]);
    }
}