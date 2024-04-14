<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Brand;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name();
        return [
            'code' => time(),
            'name' => $name,
            'slug' => Str::slug($name, '-'),
            'market_price' => 1000,
            'price' => 2000,
            'quantity' => 10,
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
        ];
    }
}