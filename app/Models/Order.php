<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "orders";

    protected $fillable = [
        'code',
        'quantity',
        "sub_total",
        "shipping_fee",
        "total",
        "payment_method",
        "payment_status",
        "paid_date",
        "status",
        "completed_at",
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
        "paid_date" => "datetime",
        "status" => "integer",
        "completed_at" => "datetime",
        "customer_id" => "integer",
    ];

    public function customer()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function shipping_address()
    {
        return $this->hasOne(Shipping_Address::class);
    }

    public function orders_products()
    {
        return $this->hasMany(Order_Product::class);
    }
}
