<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use \App\Models\Role;
use \App\Models\Category;
use App\Models\Product;

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
            Category::create([
                'name' => "Smartphone" . $i,
                'slug' => "Smartphone" . $i
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Brand::create([
                'name' => "Brand" . $i,
                'slug' => "Brand" . $i
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 30; $j++) {
                Product::create([
                    'name' => "Product " . $i + 1 . $j + 1,
                    'slug' => "Product-" . $i + 1 . $j + 1,
                    'price' => $i + 1000,
                    "market_price" => $i + 1000,
                    "quantity" => $i + 10,
                    "sold" => $i + 10,
                    "description" => "descrip " . $i,
                    "brand_id" => $i + 1,
                    "category_id" => $i + 1
                ]);
            }
        }
    }
}
