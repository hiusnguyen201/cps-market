<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Role;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => time(),
            'quantity' => 1,
            'sub_total' => 1000,
            'shipping_fee' => 0,
            'total' => 1000,
            'payment_method' => 0,
            'payment_status' => 0,
            'status' => 0,
            'customer_id' => User::factory()
        ];
    }
}