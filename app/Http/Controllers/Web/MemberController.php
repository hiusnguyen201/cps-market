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
        return view("customer.account.home", [
            'title' => "Member",
            "user" => $user,
            "categories" => $categories
        ]);
    }

    public function user_info()
    {
        $user = Auth::user();
        $categories = Category::all();
        return view("customer.account.user-info", [
            'title' => "User info ",
            "user" => $user,
            "categories" => $categories
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
        return view("customer.account.change-password", [
            'title' => "Change password",
            "user" => $user,
            "categories" => $categories
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

    public function orders()
    {
        $user = Auth::user();
        $categories = Category::all();
        $orders = Order::where('customer_id', Auth::id())->get();

        $countProductInCart = 0;
        if (Auth::user()) {
            foreach (Auth::user()->carts as $cart) {
                $countProductInCart += $cart->quantity;
            }
        }

        // foreach ($orders as $order) {
        //    foreach($order->products as $product)
        //    {
        //     dd($product->product->name);
        //    }
        // }

        return view("customer.account.orders", [
            'title' => "Order",
            "user" => $user,
            "categories" => $categories,
            "orders" => $orders,
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
        // dd($order->shipping_address);

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
