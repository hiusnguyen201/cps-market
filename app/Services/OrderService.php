<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

use App\Services\ProductService;

use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Shipping_Address;
use App\Models\Cart;

class OrderService
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function findAllAndPaginate($request)
    {
        $orders = Order::where(function ($query) use ($request) {
            $query->orWhere('code', 'like', '%' . $request->keyword . '%');
        });

        $orders = $orders->orderBy('created_at', 'desc')->paginate($request->limit ?? 10);

        return $orders && count($orders) ? $orders : [];
    }

    public function findOrderByCustomerIdAndOrderId($customerId, $orderId)
    {
        $order = Order::where(["code" => $orderId, "customer_id" => $customerId])->first();
        return $order ? $order : null;
    }

    public function createOrderInCustomer($request, $orderId, $customer)
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
                'payment_status' => config("constants.payment_status.pending")['value'],
                'paid_date' => now(),
                'status' => config("constants.order_status.pending")['value'],
                'customer_id' => $customer->id
            ]);

            foreach ($customer->carts as $cart) {
                Order_Product::create([
                    "product_id" => $cart->product->id,
                    "order_id" => $order->id,
                    "quantity" => $cart->quantity,
                    "price" => $cart->product->sale_price ?? $cart->product->price,
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
                        "payment_status" => config("constants.payment_status.paid")['value'],
                        "updated_at" => now(),
                        "paid_date" => now(),
                    ]);
                    break;
                default:
                    $order->update([
                        "payment_status" => config("constants.payment_status.canceled")['value'],
                        "status" => config("constants.order_status.canceled")['value'],
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
    public function createOrderInAdmin($request, $customer)
    {
        DB::beginTransaction();
        try {
            // Tính tổng price và quantity
            $totalPrice = 0;
            $countProductInCart = 0;
            $products = [];

            foreach ($request->product_id as $index => $product_id) {
                $result = $this->productService->findOneById($product_id);
                array_push($products, $result);
                $countProductInCart += +$request->quantity[$index];
                $totalPrice += (($result->sale_price ?? $result->price) * +$request->quantity[$index]);
            }

            // Tạo order
            $order = Order::create([
                'code' => time() . "",
                'quantity' => $countProductInCart,
                'sub_total' => $totalPrice,
                'shipping_fee' => config("constants.shipping_fee"),
                'total' => $totalPrice + config("constants.shipping_fee"),
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'status' => $request->order_status,
                'customer_id' => $customer->id
            ]);

            foreach ($products as $index => $product) {
                Order_Product::create([
                    "product_id" => $product->id,
                    "order_id" => $order->id,
                    "quantity" => +$request->quantity[$index],
                    "price" => $product->sale_price ?? $product->price,
                ]);

                $product->update([
                    "quantity" => $product->quantity - +$request->quantity[$index]
                ]);
            }

            Shipping_Address::create([
                "customer_name" => $customer->name,
                "customer_email" => $customer->email,
                "customer_phone" => $customer->phone,
                "province" => $request->province,
                "district" => $request->district,
                "ward" => $request->ward,
                "address" => $request->address,
                "note" => $request->note,
                "order_id" => $order->id
            ]);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            error_log($e->getMessage());
            throw new \Exception("Create order failed");
        }
    }

    public function updateOrderInAdmin($request, $customer, $order)
    {
        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $countProductInCart = 0;
            $products = [];

            foreach ($request->product_id as $index => $product_id) {
                $result = $this->productService->findOneById($product_id);
                array_push($products, $result);
                $countProductInCart += +$request->quantity[$index];
                $totalPrice += (($result->sale_price ?? $result->price) * +$request->quantity[$index]);
            }

            $order->update([
                'quantity' => $countProductInCart,
                'sub_total' => $totalPrice,
                'shipping_fee' => config("constants.shipping_fee"),
                'total' => $totalPrice + config("constants.shipping_fee"),
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'status' => $request->order_status,
                'customer_id' => $customer->id
            ]);

            Shipping_Address::where("order_id", $order->id)->update([
                "customer_name" => $customer->name,
                "customer_email" => $customer->email,
                "customer_phone" => $customer->phone,
                "province" => $request->province,
                "district" => $request->district,
                "ward" => $request->ward,
                "address" => $request->address,
                "note" => $request->note,
            ]);

            $orders_products = Order_Product::where("order_id", $order->id)->get();
            foreach ($orders_products as $order_product) {
                $order_product->product->update([
                    "quantity" => $order_product->product->quantity + $order_product->quantity
                ]);

                $order_product->delete();
            }

            foreach ($products as $index => $product) {
                Order_Product::create([
                    "product_id" => $product->id,
                    "order_id" => $order->id,
                    "quantity" => +$request->quantity[$index],
                    "price" => $product->sale_price ?? $product->price,
                ]);

                $product->update([
                    "quantity" => $product->quantity - +$request->quantity[$index]
                ]);
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            error_log($e->getMessage());
            throw new \Exception("Create order failed");
        }
    }

    public function deleteOrders($ids)
    {
        $position = null;
        try {
            foreach ($ids as $index => $id) {
                $order = Order::find($id);
                if (!$order) {
                    throw new \InvalidArgumentException("Order is not found in position " . $position + 1);
                }

                $status = $order->delete();
                if (!$status) {
                    $position = $index;
                    break;
                }
            }

            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception('Delete order failed in position ' . $position + 1);
        }
    }
}