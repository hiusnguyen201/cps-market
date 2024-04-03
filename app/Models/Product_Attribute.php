<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute extends Model
{
    use HasFactory;

    protected $table = 'products_attributes';

    protected $fillable = [
        'attribute_id',
        'product_id',
        'value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attribute_id' => "integer",
        'product_id' => "integer",
        "value" => "string",
    ];

     public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

     public function product()
    {
        return $this->belongsTo(Product::class);
    }
}