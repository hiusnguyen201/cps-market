<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_id' => "integer",
        'user_id' => "integer",
        'quantity' => "integer",
        'price' => "integer",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}