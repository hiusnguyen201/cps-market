<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public function createCart($product_id, $customer)
    {
        try {
            $product = Product::find($product_id);

            $cart = Cart::where('user_id', $customer->id)->where('product_id', $product->id)->first();

            if ($product->quantity <= 0 || ($cart && $cart->quantity > $product->quantity)) {
                throw new \InvalidArgumentException('Not enough quantity available');
            }

            $cart = null;
            if (!$cart) {
                $cart = Cart::create([
                    'product_id' => $product->id,
                    'user_id' => $customer->id,
                    'quantity' => 1,
                ]);
            } else {
                $cart = $cart->update([
                    'quantity' => $cart->quantity + 1,
                    'updated_at' => now(),
                ]);
            }

            return $cart;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception('Add product to cart failed');
        }
    }

    public function updateQuantityCart($cart_id, $quantity)
    {
        try {
            $cart = Cart::find($cart_id);

            if ($quantity > $cart->product->quantity) {
                throw new \InvalidArgumentException('Not enough quantity available');
            }

            $cart = $cart->update([
                "quantity" => $quantity,
                "updated_at" => now()
            ]);

            return $cart;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception("Update quantity failed");
        }
    }

    public function deleteCart($cart_id, $customer)
    {
        try {
            $cart = Cart::where(["user_id" => $customer->id, "id" => $cart_id]);

            if (!$cart) {
                throw new \InvalidArgumentException("Cart not found");
            }

            $cart->delete();

            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception('Remove product from cart failed');
        }
    }
}