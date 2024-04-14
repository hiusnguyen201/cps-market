<?php

$GENDERS = [
    'male' => [
        "value" => 1,
        "title" => "Male",
    ],
    'female' => [
        "value" => 2,
        "title" => "Female",
    ],
    'Other' => [
        "value" => 3,
        "title" => "Other",
    ],
];


$USER_STATUS = [
    "inactive" => [
        "value" => 1,
        "title" => "Inactive",
        "css" => "btn btn-info"
    ],
    "active" => [
        "value" => 2,
        "title" => "Active",
        "css" => "btn btn-success"
    ],
    "locked" => [
        "value" => 3,
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
        "value" => 1,
        "title" => "Cash on Delivery",
        "redirect" => "/payment/cod"
    ],
    "momo" => [
        "value" => 2,
        "title" => "Momo Wallet",
        "redirect" => "/payment/momo"
    ],
];

$PAYMENT_STATUS = [
    "pending" => [
        "value" => 1,
        "title" => "Pending",
        "css" => "btn btn-info"
    ],
    "paid" => [
        "value" => 2,
        "title" => "Paid",
        "css" => "btn btn-success"
    ],
    "canceled" => [
        "value" => 3,
        "title" => "Canceled",
        "css" => "btn btn-danger"
    ]
];

$ORDER_STATUS = [
    "pending" => [
        "value" => 1,
        "title" => "Pending",
        "css" => "btn btn-info"
    ],
    "confirmed" => [
        "value" => 2,
        "title" => "Confirmed",
        "css" => "btn btn-primary"
    ],
    "shipping" => [
        "value" => 3,
        "title" => "Shipping",
        "css" => "btn btn-warning"
    ],
    "completed" => [
        "value" => 4,
        "title" => "Completed",
        "css" => "btn btn-success"
    ],
    "canceled" => [
        "value" => 5,
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