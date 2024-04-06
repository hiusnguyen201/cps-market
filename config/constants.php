<?php

$GENDERS = [
    'Male' => 0,
    'Female' => 1,
    'Other' => 2,
];


$USER_STATUS = [
    'Inactive' => 0,
    'Active' => 1,
    'Locked' => 2,
];

$LIMIT_PAGE = [
    10,
    25,
    50,
    100
];

$DATE_FORMAT = "Y/m/d H:i:s";

$PAYMENT_METHOD = [
    "cod" => [
        "value" => 0,
        "name" => "Cash on Delivery",
        "redirect" => "/payment/cod"
    ],
    "momo" => [
        "value" => 1,
        "name" => "Payment with Momo",
        "redirect" => "/payment/momo"
    ],
    "vnpay" => [
        "value" => 2,
        "name" => "Payment with Vnpay",
        "redirect" => "/payment/vnpay"
    ]
];
$PAYMENT_STATUS = ["pending" => 0, "paid" => 1, "canceled" => 2];
$ORDER_STATUS = ["pending" => 0, "confirmed" => 1, "shipping" => 2, "completed" => 3, "canceled" => 4];

$SHIPPING_FEE = 0;

return [
    'genders' => $GENDERS,
    'user_status' => $USER_STATUS,
    'limit_page' => $LIMIT_PAGE,
    'date_format' => $DATE_FORMAT,
    'payment_method' => $PAYMENT_METHOD,
    'payment_status' => $PAYMENT_STATUS,
    'order_status' => $ORDER_STATUS,
    'shipping_fee' => $SHIPPING_FEE
];