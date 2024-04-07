<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'code',
        'quantity',
        "sub_total",
        "shipping_fee",
        "total",
        "payment_method",
        "payment_status",
        "status",
        "customer_id",
    ];

    protected $casts = [
        'code' => "string",
        'quantity' => "integer",
        "sub_total" => "integer",
        "shipping_fee" => "integer",
        "total" => "integer",
        "payment_method" => "integer",
        "payment_status" => "integer",
        "status" => "integer",
        "customer_id" => "integer",
    ];

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function shipping_address()
    {
        return $this->hasOne(Shipping_Address::class);
    }

    public function products()
    {
        return $this->hasMany(Order_Product::class);
    }
}