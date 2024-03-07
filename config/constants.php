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

$PROVIDER_NAME = [
    'facebook',
    'google'
];

$DATE_FORMAT = "Y/m/d H:i:s";

return ['genders' => $GENDERS, 'user_status' => $USER_STATUS, 'limit_page' => $LIMIT_PAGE, 'date_format' => $DATE_FORMAT, 'provider_name' => $PROVIDER_NAME];
