<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Order_Product;
use App\Models\Product_Images;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use \App\Models\User;
use \App\Models\Role;
use \App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Shipping_Address;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleCustomer = Role::create([
            "name" => "customer",
        ]);
        $roleAdmin = Role::create([
            "name" => "admin",
        ]);

        User::create([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            "password" => Hash::make("admin123"),
            "phone" => "0912345678",
            "gender" => 0,
            'status' => 2,
            "role_id" => $roleAdmin->id
        ]);

        for ($i = 2; $i < 62; $i++) {
            User::create([
                'name' => 'User' . $i,
                'email' => 'User' . $i . '@gmail.com',
                "password" => Hash::make("1234567"),
                "phone" => "0912345678",
                'status' => rand(1, 3),
                "role_id" => $roleCustomer->id
            ]);
        }

        for ($i = 63; $i < 83; $i++) {
            User::create([
                'name' => 'User' . $i,
                'email' => 'User' . $i . '@gmail.com',
                "password" => Hash::make("1234567"),
                "phone" => "0912345678",
                'status' => rand(1, 3),
                "role_id" => $roleAdmin->id
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            Category::create([
                "name" => "Category" . $i,
                "slug" => Str::slug("Category" . $i)
            ]);
        }

        for ($i = 0; $i < 30; $i++) {
            $brand = Brand::create([
                "name" => "Brand" . $i,
                "slug" => Str::slug("Brand" . $i)
            ]);

            $brand->categories()->attach(rand(1, 10));
        }

        for ($i = 0; $i < 200; $i++) {
            $product = Product::create([
                "code" => time() + $i,
                "slug" => Str::slug("Product" . $i),
                "name" => Str::slug(Str::random(6) . " " . Str::random(6) . " " . Str::random(6) . " " . Str::random(6) . " " . Str::random(6) . " " . Str::random(6) . " " . Str::random(6) . " " . Str::random(6) . " " . $i),
                "market_price" => 1000,
                "price" => 5000,
                "quantity" => 25,
                "sold" => rand(0, 100),
                "brand_id" => rand(1, 30),
                "category_id" => rand(1, 10)
            ]);

            Product_Images::create([
                "thumbnail" => "images/Phone.jpg",
                "product_id" => $product->id,
                "pin" => 1
            ]);
        }

        for ($i = 0; $i < 30; $i++) {
            $order = Order::create([
                "code" => time() + $i,
                "quantity" => 1,
                "total" => 5000,
                "sub_total" => 5000,
                "shipping_fee" => 0,
                "payment_method" => rand(1, 2),
                "payment_status" => rand(1, 2),
                "status" => rand(1, 5),
                "customer_id" => rand(1, 30),
            ]);

            Order_Product::create([
                "product_id" => rand(1, 30),
                "order_id" => $order->id,
                "quantity" => 1,
                "market_price" => 1000,
                "price" => 5000
            ]);

            Shipping_Address::create([
                "customer_name" => "user",
                "customer_email" => "user@gmail.com",
                "customer_phone" => "0912345678",
                "province" => 1,
                "district" => 57,
                "ward" => 328,
                "address" => "address",
                "order_id" => $order->id
            ]);
        }
    }
}
