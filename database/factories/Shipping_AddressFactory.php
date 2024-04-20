<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipping_Address>
 */
class Shipping_AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_name' => fake()->name(),
            'customer_phone' => "0912345678",
            'customer_email' => fake()->email(),
            'province' => 1,
            'district' => 57,
            'ward' => 352,
            'address' => "ascas",
            'order_id' => Order::factory()
        ];
    }
}
