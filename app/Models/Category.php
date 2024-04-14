<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug' 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => "string",
        'slug' => "string",
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'categories_brands', 'category_id', 'brand_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }
}