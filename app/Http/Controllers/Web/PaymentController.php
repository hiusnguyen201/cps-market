<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CheckoutRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Order_Product;
use App\Models\Shipping_Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PaymentController extends Controller
{
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function handleMomoPayment(CheckoutRequest $request)
    {
        $endpoint = env('MOMO_ENDPOINT', "https://test-payment.momo.vn/v2/gateway/api/create");
        $partnerCode = env('MOMO_PARTNER_CODE', 'MOMOBKUN20180529');
        $accessKey = env('MOMO_ACCESS_KEY', 'klm05TvNBzhg7h7j');
        $secretKey = env('MOMO_SECRET_KEY', 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa');

        $orderInfo = "Thanh toán qua MoMo";
        $orderId = time() . "";
        $redirectUrl = env("APP_URL") . "/cart/success";
        $ipnUrl = env("APP_URL") . "/cart/success";
        $extraData = "";
        $requestId = time() . "";
        $requestType = "captureWallet";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");

        $totalPrice = 0;
        foreach (Auth::user()->carts as $cart) {
            $totalPrice += (($cart->product->sale_price ?? $cart->product->price) * $cart->quantity);
        }

        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $totalPrice . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $totalPrice,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));

        if (!$result)
            return redirect()->back()->with("error", "Error Payment with Momo");

        $this->createOrder($request, $orderId, Auth::user());

        $jsonResult = json_decode($result, true);
        return redirect($jsonResult['payUrl']);

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

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();
            return $order;
        } catch (\Exception $err) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $err->getMessage());
            throw new \Exception($err->getMessage());
        }
    }

}