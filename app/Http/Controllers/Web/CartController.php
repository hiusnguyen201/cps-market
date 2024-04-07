<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class CartController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $products = Product::all();

        $countProductInCart = 0;
        $totalPrice = 0;
        $carts = Auth::user()->carts;
        foreach ($carts as $cart) {
            $countProductInCart += $cart->quantity;
            $totalPrice += (($cart->product->sale_price ? $cart->product->sale_price : $cart->product->price) * $cart->quantity);
        }

        return view("customer/carts/index", [
            'title' => "Cart",
            'carts' => $carts,
            'products' => $products,
            "categories" => $categories,
            "countProductInCart" => $countProductInCart,
            "totalPrice" => $totalPrice
        ]);
    }

    public function handleCreate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array',
            "product_id.*" => "integer|min:1|exists:products,id'"
        ]);

        try {
            $user = Auth::user();
            $product = Product::find($request->product_id);
            $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();


            if ($product->quantity <= 0 || ($cart && $cart->quantity > $product->quantity)) {
                return redirect()->back()->with('error', 'Not enough quantity available');
            }

            if (!$cart) {
                Cart::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => 1,
                ]);
            } else {
                $cart->update([
                    'quantity' => $cart->quantity + 1,
                ]);
            }

            if ($request->action == 'buy') {
                return redirect("/cart")->with('success', 'Add product to cart successfully');
            } else {
                return redirect()->back()->with('success', 'Add product to cart successfully');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return redirect()->back()->with('error', 'Add product to cart failed');
        }
    }

    public function handleUpdate(Request $request)
    {
        try {
            $cart = Cart::find($request->cart_id);

            if (!$cart) {
                return redirect()->back()->with('error', 'Cart not found!');
            }

            if ($request->quantity > $cart->product->quantity) {
                return redirect()->back()->with('error', 'Not enough quantity available');
            }

            $cart->update([
                "quantity" => $request->quantity,
                "updated_at" => now()
            ]);

            session()->flash("success", "Update quantity successfully");
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Update quantity unsuccessfully!');
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $cart = Cart::where(["user_id" => Auth::id(), "id" => $request->cart_id]);

            if (!$cart) {
                return redirect()->back()->with("error", "Cart not found");
            }

            $cart->delete();

            session()->flash('success', 'Remove product from cart successfully!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Remove product from cart unsuccessfully!');
        }

        return redirect()->back();
    }

    public function checkoutPage()
    {
        $user = Auth::user();
        $carts = $user->carts;
        if (!$carts || !count($carts)) {
            return redirect("/cart");
        }

        $totalPrice = 0;
        $countProductInCart = 0;
        foreach ($carts as $cart) {
            $countProductInCart += $cart->quantity;
            $totalPrice += (($cart->product->sale_price ?? $cart->product->price) * $cart->quantity);
        }

        $categories = Category::all();

        return view("customer/carts/checkout", [
            'title' => "Checkout",
            "categories" => $categories,
            "carts" => $carts,
            "countProductInCart" => $countProductInCart,
            "totalPrice" => $totalPrice,
            "user" => $user
        ]);
    }

    public function reponsePaymentPage(Request $request)
    {
        $order = Order::where("code", $request->orderId)->first();
        if (!$order)
            return redirect()->back()->with("Order not found");

        if ($order->payment_method != config("constants.payment_method.cod")['value'] && $order->status != config("constants.order_status.pending")) {
            switch ($request->resultCode) {
                case "0":
                    $order->update([
                        "payment_status" => config("constants.payment_status.paid"),
                        "updated_at" => now()
                    ]);
                    break;
                default:
                    $order->update([
                        "payment_status" => config("constants.payment_status.canceled"),
                        "status" => config("constants.order_status.canceled"),
                        "updated_at" => now()
                    ]);
                    break;
            }
        }

        $statusOrderPayment = $order->status == config("constants.order_status.canceled") ? false : true;

        $categories = Category::all();
        return view("customer/carts/success", [
            "order" => $order,
            'title' => "Cart",
            "categories" => $categories,
            "statusOrderPayment" => $statusOrderPayment
        ]);
    }

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}