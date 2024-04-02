<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Product;
use Cart;

class CartController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $cart = Cart::instance('cart');

        return view("customer/cart", [
            'title' => "Cart",
            'cartItems' => $cart->content(),
            "categories" => $categories
        ]);
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) return redirect()->back()->with("error", "Product is not found");
        $cart = Cart::instance('cart');

        $exist_cart = $cart->search(function ($cartItem) use ($product) {
            return $cartItem->id === $product->id;
        });

        if ($exist_cart->count() > 0) {
            foreach ($exist_cart as $index => $item) {
                $cart->update(
                    $index,
                    ++$item->qty
                );
                break;
            }
        } else {
            $cart->add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
            ])->associate('App\Models\Product');
        }

        return redirect()->back()->with("success", "Add product to cart successfully");
    }

    public function handleUpdate(Request $request) {
        Cart::instance('cart')->update($request->rowId, $request->qty);
        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        Cart::instance('cart')->remove($request->rowId);
        return redirect()->back();
    }

    public function checkoutPage(Request $request)
    {
        $categories = Category::all();
        return view("customer.checkout", [
            "title" => "Cart",
            "categories" => $categories
        ]);
    }
}