<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Shipping_Address;
use App\Models\Cart;

class OrderService
{
    public function findOrderByCustomerIdAndOrderId($customerId, $orderId)
    {
        $order = Order::where(["code" => $orderId, "customer_id" => $customerId])->first();
        return $order ? $order : null;
    }

    public function createOrder($request, $orderId, $customer)
    {
        DB::beginTransaction();
        try {
            // Tính tổng price và quantity
            $totalPrice = 0;
            $countProductInCart = 0;
            foreach ($customer->carts as $cart) {
                $countProductInCart += $cart->quantity;
                $totalPrice += (($cart->product->sale_price ?? $cart->product->price) * $cart->quantity);
            }

            // Tạo order
            $order = Order::create([
                'code' => $orderId,
                'quantity' => $countProductInCart,
                'sub_total' => $totalPrice,
                'shipping_fee' => config("constants.shipping_fee"),
                'total' => $totalPrice + config("constants.shipping_fee"),
                'payment_method' => $request->payment_method,
                'payment_status' => config("constants.payment_status.pending"),
                'status' => config("constants.order_status.pending"),
                'customer_id' => $customer->id
            ]);

            foreach ($customer->carts as $cart) {
                Order_Product::create([
                    "product_id" => $cart->product->id,
                    "order_id" => $order->id,
                    "quantity" => $cart->quantity,
                    "price" => $cart->product->price,
                    "sale_price" => $cart->product->sale_price,
                ]);

                $cart->product->update([
                    "quantity" => $cart->product->quantity - $cart->quantity
                ]);
            }

            Shipping_Address::create([
                "customer_name" => $request->customer_name,
                "customer_email" => $request->customer_email,
                "customer_phone" => $request->customer_phone,
                "province" => $request->province,
                "district" => $request->district,
                "ward" => $request->ward,
                "address" => $request->address,
                "note" => $request->note,
                "order_id" => $order->id
            ]);

            Cart::where('user_id', $customer->id)->delete();

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            error_log($e->getMessage());
            throw new \Exception("Create order failed");
        }
    }

    public function updatePaymentStatus($order, $resultCode)
    {
        DB::beginTransaction();
        try {
            switch ($resultCode) {
                case "0":
                    $order->update([
                        "payment_status" => config("constants.payment_status.paid"),
                        "updated_at" => now(),
                        "paid_date" => now(),
                    ]);
                    break;
                default:
                    $order->update([
                        "payment_status" => config("constants.payment_status.canceled"),
                        "status" => config("constants.order_status.canceled"),
                        "updated_at" => now()
                    ]);

                    foreach ($order->products as $order_product) {
                        $order_product->product->update([
                            "quantity" => $order_product->product->quantity + $order_product->quantity
                        ]);
                    }
                    break;
            }

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            error_log($e->getMessage());
            throw new \Exception("Update payment status failed");
        }
    }

    public function findAllAndPaginate($request)
    {
        $orders = Order::where(function ($query) use ($request) {
            $query->orWhere('code', 'like', '%' . $request->kw . '%');
        });

        $orders = $orders->orderBy('created_at', 'desc')->paginate($request->limit ?? 10);

        return $orders && count($orders) ? $orders : [];
    }
}