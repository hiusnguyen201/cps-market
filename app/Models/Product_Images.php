<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Images extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'thumbnail',
        'product_id',
        'pin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'thumbnail' => "string",
        'product_id' => "integer",
        "pin" => "integer",
    ];
}
