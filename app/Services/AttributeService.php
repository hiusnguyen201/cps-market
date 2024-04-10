<?php

namespace App\Services;

use App\Models\Attribute;

class AttributeService
{
    public function findAllWithSpecificationByCategoryId($product)
    {
        $attributes = Attribute::whereHas('specification', function ($query) use ($product) {
            $query->where('category_id', $product->category_id);
        })->get();

        return $attributes && count($attributes) ? $attributes : [];
    }
}