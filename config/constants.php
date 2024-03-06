<?php

$GENDERS = [
    'Male',
    'Female',
     'Other'
];


$USER_STATUS = [
    'Inactive',
    'Active',
    'Locked'
];

$LIMIT_PAGE = [
    10,
    25, 
    50, 
    100
];

$DATE_FORMAT = "Y/m/d H:i:s";

return ['genders' => $GENDERS, 'user_status' => $USER_STATUS, 'limit_page' => $LIMIT_PAGE, 'date_format' => $DATE_FORMAT];