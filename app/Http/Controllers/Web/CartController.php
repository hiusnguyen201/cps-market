<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\OrderService;
use App\Services\CartService;
use App\Services\CategoryService;

class CartController extends Controller
{
    private OrderService $orderService;
    private CartService $cartService;
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->categoryService = new CategoryService();
    }

    public function home()
    {
        $categories = $this->categoryService->findAll();
        $carts = Auth::user()->carts;

        $countProductInCart = 0;
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $countProductInCart += $cart->quantity;
            $totalPrice += (($cart->product->sale_price ? $cart->product->sale_price : $cart->product->price) * $cart->quantity);
        }

        return view("customer/carts/index", [
            'title' => "Cart",
            'carts' => $carts,
            "categories" => $categories,
            "countProductInCart" => $countProductInCart,
            "totalPrice" => $totalPrice
        ]);
    }

    public function handleCreate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|min:1|exists:products,id',
        ]);

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
        $request->validate([
            'cart_id' => 'required|integer|min:1|exists:carts,id',
        ]);

        try {
            $this->cartService->updateQuantityCart($request->cart_id, $request->quantity);
            session()->flash("success", "Update quantity successfully");
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $this->cartService->deleteCart($request->cart_id, Auth::user());
            session()->flash('success', 'Remove product from cart successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function checkoutPage()
    {
        $user = Auth::user();
        $carts = $user->carts;
        if (!$carts || !count($carts)) {
            return redirect()->route("cart.index");
        }

        $totalPrice = 0;
        $countProductInCart = 0;
        foreach ($carts as $cart) {
            $countProductInCart += $cart->quantity;
            $totalPrice += (($cart->product->sale_price ?? $cart->product->price) * $cart->quantity);
        }

        $categories = $categories = $this->categoryService->findAll();

        return view("customer/carts/checkout", [
            'title' => "Checkout",
            "categories" => $categories,
            "carts" => $carts,
            "countProductInCart" => $countProductInCart,
            "totalPrice" => $totalPrice,
            "user" => $user
        ]);
    }

    public function success(Request $request)
    {
        $order = $this->orderService->findOrderByCustomerIdAndOrderId(Auth::id(), $request->orderId);
        if (!$order) {
            return redirect()->back()->with("error", "Order not found");
        }

        // Check code payment
        if ($order->payment_method != config("constants.payment_method.cod")['value'] && $order->status != config("constants.order_status.canceled")) {
            try {
                $this->orderService->updatePaymentStatus($order, $request->resultCode);
            } catch (\Exception $e) {
                session()->flash("error", $e->getMessage());
            }
        }

        $statusOrderPayment = $order->status == config("constants.order_status.canceled") ? false : true;

        $categories = $this->categoryService->findAll();

        return view("customer/carts/success", [
            "order" => $order,
            'title' => "Cart",
            "categories" => $categories,
            "statusOrderPayment" => $statusOrderPayment
        ]);
    }
}