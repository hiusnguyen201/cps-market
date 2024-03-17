<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'market_price',
        'quantity',
        'sold',
        'description',
        'brand_id',
        'category_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => "string",
        'price' => "integer",
        "market_price" => "integer",
        "quantity" => "integer",
        "sold" => "integer",
        "description" => "string",
        "brand_id" => "integer",
        "category_id" => "integer"
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(Product_Images::class);
    }
}
