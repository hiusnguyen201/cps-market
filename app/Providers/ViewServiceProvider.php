<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $cartCount = 0;
            $categories = Category::all();

            if ($user = Auth::user()) {

                $cartCount = Cart::where('user_id', $user->id)
                    ->whereHas('product', function ($query) {
                        $query->where('quantity', '>', 0);
                    })
                    ->sum('quantity');
                    $view->with('user', $user);
            }

            $view->with('cartCount', $cartCount);
            $view->with('categories', $categories);
        });
    }
}
