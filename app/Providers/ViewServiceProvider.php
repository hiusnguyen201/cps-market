<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

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
            $carts = null;

            if ($user = Auth::user()) {
                $carts = Cart::with('product')->where('user_id', $user->id)->get();
                $cartCount = count($carts);
            }

            $view->with('carts', $carts);
            $view->with('cartCount', $cartCount);
        });
    }
}
