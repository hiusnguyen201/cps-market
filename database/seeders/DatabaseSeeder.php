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
            'status' => 1,
            "role_id" => $roleAdmin->id
        ]);
    }
}