<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function home()
    {

        //category phone
        $sections2 = Product::whereHas('category', function ($query) {
            $query->where('name', 'phone');
        })
            ->orderBy('sold', 'desc')
            ->limit(20)
            ->get();

        //category laptop
        $sections3 = Product::whereHas('category', function ($query) {
            $query->where('name', 'laptop');
        })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        //category earphones
        $sections4 = Product::whereHas('category', function ($query) {
            $query->where('name', 'earphone');
        })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        //category watchs
        $sections5 = Product::whereHas('category', function ($query) {
            $query->where('name', 'watch');
        })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        //category accessories
        $sections6 = Product::whereHas('category', function ($query) {
            $query->where('name', 'accessory');
        })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        //category second-hand
        $sections7 = Product::whereHas('category', function ($query) {
            $query->where('name', 'second-hand');
        })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        //category tablets
        $sections8 = Product::whereHas('category', function ($query) {
            $query->where('name', 'tablet');
        })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $sections9D = Product::whereDate('created_at', today())
        ->orderBy('sold', 'desc')
        ->limit(3)
        ->get();

        $sections9W = Product::whereYear('created_at', now()->year)
        ->whereBetween('created_at', [Carbon::now()->subWeek()->format("Y-m-d H:i:s"), Carbon::now()])
        ->orderBy('sold', 'desc')
        ->limit(3)
        ->get();

        $sections9M = Product::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->orderBy('sold', 'desc')
        ->limit(3)
        ->get();
  

        return view("customer/home", [
            'sections2' => $sections2,
            'sections3' => $sections3,
            'sections4' => $sections4,
            'sections5' => $sections5,
            'sections6' => $sections6,
            'sections7' => $sections7,
            'sections8' => $sections8,
            'sections9D' => $sections9D,
            'sections9W' => $sections9W,
            'sections9M' => $sections9M,
            'title' => "Cps Market"
        ]);
    }

    public function details($slug)
    {

        $product = Product::where(['slug' => $slug])->first();


        return view('customer.products.details', [
            'product' => $product,
            'title' => 'Details Product',
        ]);
    }

}
