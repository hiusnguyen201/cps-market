<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function home()
    {
        if ($user = Auth::user()) {
            $carts = Cart::where('user_id', $user->id)->get();

            return view("customer/cart", [
                'title' => "Cart | Cps Market ",
                'carts' => $carts,
            ]);
        } else {
            return redirect('auth/login');
        }
    }

    public function handleCreate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if (!$cart && $product) {
            Cart::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);

            return redirect()->back()->with('success', 'ADD');
        } else {

            if ($cart->quantity < $product->quantity) {
                $cart->update([
                    'quantity' => $cart->quantity + 1,
                    'price' => ($cart->quantity + 1) * $product->price,
                ]);

                return redirect()->back()->with('success', 'ADD qty');
            } else {
                return redirect()->back()->with('error', 'Not enough quantity available');
            }
        }
    }

    public function handleUpdate(Request $request)
    {
        try {
            $cartData = json_decode($request->cart_data, true);

            if (!empty($cartData)) {
                foreach ($cartData as $item) {
                    $cart = Cart::findOrFail($item['cart_id']);
                    $product = Product::findOrFail($cart->product_id);

                    if ($cart && $product) {
                        if ($item['quantity'] > $cart->quantity) { //tang sl
                            if ($cart->quantity >= $product->quantity) { //kt so luong kho hang
                                return redirect()->back()->with('error', 'Not enough QTY');
                            } else {
                                $cart->update([
                                    'quantity' => $item['quantity'],
                                    'price' => $item['quantity'] * $product->price,
                                ]);
                            }
                        } else { // giam sl
                            if ($item['quantity'] == 0) {
                                $cart->delete();
                            } else {
                                $cart->update([
                                    'quantity' => $item['quantity'],
                                    'price' => $item['quantity'] * $product->price,
                                ]);
                            }
                        }
                    }
                }

                return redirect()->back()->with('success', 'Updated');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return redirect()->back()->with('error', 'Update cart was not successful!');
        }
    }

    public function handleDelete(Request $request)
    {
        try {
            $user = Auth::user();
            $cartIds = $request->id;

            if (!is_array($cartIds)) {
                $cartIds = [$cartIds];
            }

            foreach ($cartIds as $index => $cartIds) {
                $cart = Cart::find($cartIds);

                if (is_null($cart)) {
                    session()->flash('error', 'Delete cart was not successful! in position ' . $index);
                    return redirect()->back();
                } elseif ($user->id == $cart->user_id) {
                    $cart->delete();
                    session()->flash('success', 'Delete cart was successful!');
                }
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Delete cart was not successful!');
        }

        return redirect()->back();
    }
}
