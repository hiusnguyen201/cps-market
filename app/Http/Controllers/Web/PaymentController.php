<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Admin\CheckoutRequest;
use App\Services\OrderService;

class PaymentController extends Controller
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
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
        $redirectUrl = env("APP_URL") . route("cart.success");
        $ipnUrl = env("APP_URL") . route("cart.success");
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

        if (!$result) {
            return redirect()->back()->with("error", "Error Payment with Momo");
        }

        try {
            $this->orderService->createOrder($request, $orderId, Auth::user());
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Create order failed");
        }

        $jsonResult = json_decode($result, true);
        return redirect($jsonResult['payUrl']);

    }

    public function handleCodPayment(CheckoutRequest $request)
    {
        $orderId = time() . "";
        try {
            $this->orderService->createOrder($request, $orderId, Auth::user());
            return redirect(route('cart.success') . '?orderId=' . $orderId);
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Create order failed");
        }
    }
}