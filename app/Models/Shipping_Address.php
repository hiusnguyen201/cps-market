<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping_Address extends Model
{
    use HasFactory;

    protected $table = "shipping_address";

    protected $fillable = [
        'province',
        'district',
        "ward",
        "note",
        "address",
        "order_id"
    ];

    protected $casts = [
        'province' => "integer",
        'district' => "integer",
        "ward" => "integer",
        "address" => "string",
        "note" => "string",
        "order_id" => "integer",
    ];

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function shipping_address()
    {
        return $this->hasOne(Shipping_Address::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}