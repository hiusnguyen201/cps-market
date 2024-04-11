<?php

$GENDERS = [
    'male' => [
        "value" => 0,
        "title" => "Male",
    ],
    'female' => [
        "value" => 1,
        "title" => "Female",
    ],
    'Other' => [
        "value" => 2,
        "title" => "Other",
    ],
];


$USER_STATUS = [
    "inactive" => [
        "value" => 0,
        "title" => "Inactive",
        "css" => "btn btn-info"
    ],
    "active" => [
        "value" => 1,
        "title" => "Active",
        "css" => "btn btn-success"
    ],
    "locked" => [
        "value" => 2,
        "title" => "Locked",
        "css" => "btn btn-danger"
    ],
];

$LIMIT_PAGE = [
    10,
    25,
    50,
    100
];

$DATE_FORMAT = "d/m/Y H:i:s";

$PAYMENT_METHOD = [
    "cod" => [
        "value" => 0,
        "title" => "Cash on Delivery",
        "redirect" => "/payment/cod"
    ],
    "momo" => [
        "value" => 1,
        "title" => "Momo Wallet",
        "redirect" => "/payment/momo"
    ],
];

$PAYMENT_STATUS = [
    "pending" => [
        "value" => 0,
        "title" => "Pending",
        "css" => "btn btn-info"
    ],
    "paid" => [
        "value" => 1,
        "title" => "Paid",
        "css" => "btn btn-success"
    ],
    "canceled" => [
        "value" => 2,
        "title" => "Canceled",
        "css" => "btn btn-danger"
    ]
];

$ORDER_STATUS = [
    "pending" => [
        "value" => 0,
        "title" => "Pending",
        "css" => "btn btn-info"
    ],
    "confirmed" => [
        "value" => 1,
        "title" => "Confirmed",
        "css" => "btn btn-primary"
    ],
    "shipping" => [
        "value" => 2,
        "title" => "Shipping",
        "css" => "btn btn-warning"
    ],
    "completed" => [
        "value" => 3,
        "title" => "Completed",
        "css" => "btn btn-success"
    ],
    "canceled" => [
        "value" => 4,
        "title" => "Canceled",
        "css" => "btn btn-danger"
    ],
];

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