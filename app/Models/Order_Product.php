<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Product extends Model
{
    use HasFactory;

    protected $table = "orders_products";

    protected $fillable = [
        'product_id',
        'order_id',
        "quantity",
        "market_price",
        "price",
    ];

    protected $casts = [
        'product_id' => "integer",
        "order_id" => "integer",
        "quantity" => "integer",
        "price" => "integer",
        "market_price" => "integer",
    ];

    public function order()
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
