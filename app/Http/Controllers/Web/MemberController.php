<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Order_Product;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $categories = Category::all();

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        $ordersQuery = Order::where('customer_id', Auth::id());
        $orders = $ordersQuery->latest()->take(5)->get();

        return view("customer.account.home", [
            'title' => "Member",
            "user" => $user,
            "categories" => $categories,
            "orders" => $orders,
            'countProductInCart' => $countProductInCart,

        ]);
    }

    public function user_info()
    {
        $user = Auth::user();
        $categories = Category::all();

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        return view("customer.account.user-info", [
            'title' => "User info ",
            "user" => $user,
            "categories" => $categories,
            'countProductInCart' => $countProductInCart,
        ]);
    }

    public function handleUpdate_User_info(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'in:0,1,2',
        ]);

        try {
            $user = Auth::user();
            $user = User::findOrFail($user->id);
            $request->request->add(['updated_at' => now()]);
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->save();
            session()->flash('success', 'Update info was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            dd($e);
            session()->flash('error', 'Edit info was not successful!');
        }

        return redirect()->back();
    }

    public function change_password()
    {
        $user = Auth::user();
        $categories = Category::all();

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        return view("customer.account.change-password", [
            'title' => "Change password",
            "user" => $user,
            "categories" => $categories,
            'countProductInCart' => $countProductInCart,
        ]);
    }

    public function handleChange_password(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $user = User::findorFail($user->id);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'The current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect('/member/account/user-info')->with('success', 'Password changed successfully.');
    }

    public function orders(Request $request)
    {
        $user = Auth::user();
        $categories = Category::all();
        $ordersQuery = Order::where('customer_id', Auth::id());

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        $time_sort = $request->input('time_sort');
        switch ($time_sort) {
            case '5':
                $orders = $ordersQuery->latest()->take(5)->get();
                break;
            case '15':
                $orders = $ordersQuery->where('created_at', '>=', now()->subDays(15))->get();
                break;
            case '30':
                $orders = $ordersQuery->where('created_at', '>=', now()->subDays(30))->get();
                break;
            case '180':
                $orders = $ordersQuery->where('created_at', '>=', now()->subMonths(6))->get();
                break;
            case 'all':
                $orders = $ordersQuery->get();
                break;
            default:
                $orders = $ordersQuery->latest()->take(5)->get();
                break;
        }

        return view("customer.account.orders", [
            'title' => "Order",
            "user" => $user,
            "categories" => $categories,
            "orders" => $orders,
            "time_sort" => $time_sort,
            'countProductInCart' => $countProductInCart,
        ]);
    }

    public function order_detail($order_id)
    {
        $user = Auth::user();
        $categories = Category::all();

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        $order_Products = Order_Product::where('order_id', $order_id)->get();
        $order = Order::findOrFail($order_id);

        if($order->customer_id != Auth::id()) {
            return view("customer.404", [
                'title' => "Not found",
                "user" => $user,
                "categories" => $categories,
                'countProductInCart' => $countProductInCart,
            ]);
        }

        return view("customer.account.order-detail", [
            'title' => "Order",
            "user" => $user,
            "categories" => $categories,
            "order_Products" => $order_Products,
            "order" => $order,
            'countProductInCart' => $countProductInCart,
        ]);
    }
}
