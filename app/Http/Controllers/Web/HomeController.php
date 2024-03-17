<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class HomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        $products = Product::all();

        return view("customer/home", [
            'title' => "Cps Market",
            'carts' => $carts
        ], compact('products'));
    }

}