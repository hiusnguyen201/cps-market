<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
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
        Role::create([
            "name" => "customer",
        ]);
        Role::create([
            "name" => "admin",
        ]);

        for ($i = 0; $i < 30; $i++) {
            User::create([
                'name' => "User " . $i,
                'email' => "user" . $i . "@gmail.com",
                "password" => Hash::make("1234"),
                "phone" => "0912345678",
                "gender" => 0,
                "role_id" => 1
            ]);
        }

        User::create([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            "password" => Hash::make("1234"),
            "phone" => "0912345678",
            "gender" => 0,
            "role_id" => 2
        ]);

        for ($i = 30; $i < 45; $i++) {
            User::create([
                'name' => "User " . $i,
                'email' => "user" . $i . "@gmail.com",
                "password" => Hash::make("1234"),
                "phone" => "0912345678",
                "gender" => 1,
                "role_id" => 2
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            $category = Category::create([
                'name' => "Smartphone" . $i,
                'slug' => "Smartphone" . $i
            ]);

            $brand = Brand::create([
                'name' => "Brand" . $i,
                'slug' => "Brand" . $i
            ]);

            $brand->categories()->attach($category->id);
        }

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 30; $j++) {
                $product = Product::create([
                    'name' => "Product " . $i + 1 . $j + 1,
                    'slug' => "Product-" . $i + 1 . $j + 1,
                    'price' => $i + 5000,
                    "sale_price" => $i + 1000,
                    "quantity" => $i + 10,
                    "sold" => $i + 10,
                    "description" => "descrip " . $i,
                    "brand_id" => $i + 1,
                    "category_id" => $i + 1
                ]);

                Product_Images::create([
                    'thumbnail' => "images/Phone.jpg",
                    'pin' => 1,
                    'product_id' => $product->id

                ]);
            }
        }

        for ($i = 0; $i < 30; $i++) {
            $order = Order::create([
                'code' => Str::random(25),
                'quantity' => 2,
                'sub_total' => 10000,
                "shipping_fee" => 0,
                "total" => 10000,
                "payment_method" => config("constants.payment_method.cod")['value'],
                "payment_status" => config("constants.payment_status.pending"),
                "status" => config("constants.order_status.pending"),
                "customer_id" => $i + 1
            ]);

            Shipping_Address::create([
                'province' => 1,
                'district' => 1,
                'ward' => 7,
                'address' => "Addres " . $i + 1,
                'note' => "Note " . $i + 1,
                "order_id" => $order->id,
            ]);
        }
    }
}