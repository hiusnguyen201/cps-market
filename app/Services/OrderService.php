<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

use App\Services\ProductService;
use App\Services\UserService;

use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Shipping_Address;
use App\Models\Cart;

class OrderService
{
    private ProductService $productService;
    private UserService $userService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->userService = new UserService();
    }

    public function findAllAndPaginate($request)
    {
        $orders = Order::where(function ($query) use ($request) {
            $query->orWhere('code', 'like', '%' . $request->keyword . '%');
            if($request->status) {
                $query->where("status", $request->status);
            }
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
            [$countProductsInCart, $totalPrice] = $this->userService->countProductsAndCalculatePriceInCart($customer);

            // Tạo order
            $order = Order::create([
                'code' => $orderId,
                'quantity' => $countProductsInCart,
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
                if($cart->product) {
                    Order_Product::create([
                        "product_id" => $cart->product->id,
                        "order_id" => $order->id,
                        "quantity" => $cart->quantity,
                        "market_price" => $cart->product->market_price,
                        "price" => $cart->product->sale_price ?? $cart->product->price,
                    ]);

                    $cart->product->update([
                        "quantity" => $cart->product->quantity - $cart->quantity
                    ]);
                }
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
            if ($e->getCode() != 0) {
                throw new \Exception("Create order failed");
            } else {
                throw new \Exception($e->getMessage());
            }
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

                    foreach ($order->orders_products as $order_product) {
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
            if ($e->getCode() != 0) {
                throw new \Exception("Update payment status failed");
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }
    public function createOrderInAdmin($request, $customer)
    {
        // Tính tổng price và quantity
        $totalPrice = 0;
        $countProductsInCart = 0;
        $products = [];

        foreach ($request->product_id as $index => $product_id) {
            $result = $this->productService->findOneById($product_id);
            array_push($products, $result);
            $countProductsInCart += +$request->quantity[$index];
            $totalPrice += (($result->sale_price ?? $result->price) * +$request->quantity[$index]);
        }

        DB::beginTransaction();
        try {
            // Tạo order
            $order = Order::create([
                'code' => time() . "",
                'quantity' => $countProductsInCart,
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
                    "market_price" => $product->market_price,
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
            if ($e->getCode() != 0) {
                throw new \Exception("Create order failed");
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function updateOrderInAdmin($request, $customer, $order)
    {
        $totalPrice = 0;
        $countProductsInCart = 0;

        DB::beginTransaction();
        try {
            foreach ($order->orders_products as $index => $order_product) {
                $countProductsInCart += +$request->quantity[$index];
                $totalPrice += $order_product->price * +$request->quantity[$index];

                Order_Product::find($order_product->id)->update([
                    "quantity" => $request->quantity[$index],
                ]);

                $order_product->product->update([
                    "quantity" => $order_product->product->quantity + $order_product->quantity - $request->quantity[$index]
                ]);
            }

            $order->update([
                'quantity' => $countProductsInCart,
                'sub_total' => $totalPrice,
                'shipping_fee' => config("constants.shipping_fee"),
                'total' => $totalPrice + config("constants.shipping_fee"),
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'status' => $request->order_status,
                'customer_id' => $customer->id
            ]);

            $order->shipping_address->update([
                "customer_name" => $customer->name,
                "customer_email" => $customer->email,
                "customer_phone" => $customer->phone,
                "province" => $request->province,
                "district" => $request->district,
                "ward" => $request->ward,
                "address" => $request->address,
                "note" => $request->note,
            ]);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() != 0) {
                throw new \Exception("Create order failed");
            } else {
                throw new \Exception($e->getMessage());
            }
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
            if ($e->getCode() != 0) {
                throw new \Exception('Delete order failed in position ' . $position + 1);
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function countNewOrders()
    {
        $count = Order::where(function ($query) {
            $query->whereDate("created_at", today());
        })->count();

        return $count ? $count : 0;
    }

    public function calculateTotalIncome()
    {
        $total = Order::where("status", config("constants.order_status.completed.value"))->sum("total");
        return $total ? $total : 0;
    }

    public function calculateRevenueInYear($year)
    {
        $revenueInMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = Order::where(function ($query) use ($year, $i) {
                $query->where("status", config("constants.order_status.completed.value"));
                $query->whereYear('created_at', $year);
                $query->whereMonth('created_at', $i);
            })->sum('total');
            array_push($revenueInMonths, $total);
        }
        return $revenueInMonths;
    }

    public function countOrdersCompletedInYear($year)
    {
        $counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $count = Order::where(function ($query) use ($year, $i) {
                $query->where("status", config("constants.order_status.completed.value"));
                $query->whereYear('created_at', $year);
                $query->whereMonth('created_at', $i);
            })->count();
            array_push($counts, $count);
        }
        return $counts;
    }
}