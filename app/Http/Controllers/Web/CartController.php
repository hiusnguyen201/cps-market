<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\OrderService;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\UserService;

class CartController extends Controller
{
    private OrderService $orderService;
    private CartService $cartService;
    private CategoryService $categoryService;
    private UserService $userService;
    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->categoryService = new CategoryService();
        $this->userService = new UserService();
    }

    public function home()
    {
        $categories = $this->categoryService->findAll();

        if (Auth::user()) {
            [$countProductsInCart, $totalPrice] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        }

        return view("customer/carts/index", [
            'title' => "Cart",
            'carts' => Auth::user() ? Auth::user()->carts : [],
            "categories" => $categories,
            "countProductsInCart" => $countProductsInCart ?? 0,
            "totalPrice" => $totalPrice ?? 0
        ]);
    }

    public function handleCreate(Request $request)
    {
        try {
            $this->cartService->createCart($request->product_id, Auth::user());

            session()->flash("success", 'Add product to cart successfully');
            if ($request->action == 'buy') {
                return redirect()->route("cart.index");
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }


        return redirect()->back();
    }

    public function handleUpdate(Request $request)
    {
        try {
            $this->cartService->updateQuantityCart($request->cart_id, $request->quantity);
            session()->flash("success", "Update quantity successfully");
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/cart");
    }

    public function handleDelete(Request $request)
    {
        try {
            $this->cartService->deleteCart($request->cart_id, Auth::user());
            session()->flash('success', 'Remove product from cart successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/cart");
    }

    public function checkoutPage()
    {
        if (!Auth::user()->carts || !count(Auth::user()->carts)) {
            return redirect()->route("cart.index");
        }

        [$countProductsInCart, $totalPrice] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());

        $categories = $categories = $this->categoryService->findAll();

        return view("customer/carts/checkout", [
            'title' => "Checkout",
            "categories" => $categories,
            "countProductsInCart" => $countProductsInCart ?? 0,
            "totalPrice" => $totalPrice,
        ]);
    }

    public function success(Request $request)
    {
        $order = $this->orderService->findOrderByCustomerIdAndOrderId(Auth::id(), $request->orderId);
        if (!$order) {
            return redirect()->back()->with("error", "Order not found");
        }

        // Check code payment
        if ($order->payment_method != config("constants.payment_method.cod")['value'] && $order->status != config("constants.order_status.canceled")['value']) {
            try {
                $this->orderService->updatePaymentStatus($order, $request->resultCode);
            } catch (\Exception $e) {
                session()->flash("error", $e->getMessage());
            }
        }

        $statusOrderPayment = $order->status == config("constants.order_status.canceled")['value'] ? false : true;

        $categories = $this->categoryService->findAll();

        return view("customer/carts/success", [
            "order" => $order,
            'title' => "Cart",
            "categories" => $categories,
            "statusOrderPayment" => $statusOrderPayment
        ]);
    }
}
