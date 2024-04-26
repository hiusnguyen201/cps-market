<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Customer\ProfileRequest;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

use App\Services\CategoryService;
use App\Services\UserService;
use App\Services\WishlistService;

class MemberController extends Controller
{
    private CategoryService $categoryService;
    private UserService $userService;
    private WishlistService $wishlistService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->userService = new UserService();
        $this->wishlistService = new WishlistService();
    }

    public function home()
    {
        $recentOrders = $this->userService->getRecentOrdersWithLimit(Auth::id(), 5);
        [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        $countPlacedOrders = $this->userService->countPlacedOrders(Auth::id());
        $countCancelOrders = $this->userService->countCancelOrders(Auth::id());
        $countWishlist = count(Auth::user()->wishlist);
        $wishlist = $this->wishlistService->findAllByCustomerId(Auth::id());

        $categories = $this->categoryService->findAll();
        return view("customer.member.home", [
            'title' => "Member",
            "categories" => $categories,
            "recentOrders" => $recentOrders,
            'countProductsInCart' => $countProductsInCart ?? 0,
            "countPlacedOrders" => $countPlacedOrders,
            "countCancelOrders" => $countCancelOrders,
            "countWishlist" => $countWishlist,
            "wishlist" => $wishlist
        ]);
    }

    public function profilePage()
    {
        [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        $countPlacedOrders = $this->userService->countPlacedOrders(Auth::id());
        $countCancelOrders = $this->userService->countCancelOrders(Auth::id());
        $countWishlist = count(Auth::user()->wishlist);

        $categories = $this->categoryService->findAll();
        return view("customer.member.profile", [
            'title' => "My Profile",
            "categories" => $categories,
            'countProductsInCart' => $countProductsInCart ?? 0,
            "countPlacedOrders" => $countPlacedOrders,
            "countCancelOrders" => $countCancelOrders,
            "countWishlist" => $countWishlist
        ]);
    }

    public function editProfilePage()
    {
        [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        $countPlacedOrders = $this->userService->countPlacedOrders(Auth::id());
        $countCancelOrders = $this->userService->countCancelOrders(Auth::id());
        $countWishlist = count(Auth::user()->wishlist);
        $categories = $this->categoryService->findAll();
        return view("customer.member.edit-profile", [
            'title' => "My Profile",
            "categories" => $categories,
            'countProductsInCart' => $countProductsInCart ?? 0,
            "countPlacedOrders" => $countPlacedOrders,
            "countCancelOrders" => $countCancelOrders,
            "countWishlist" => $countWishlist
        ]);
    }

    public function handleUpdateProfile(ProfileRequest $request)
    {
        try {
            $this->userService->updateInfoMember($request, Auth::user());
            session()->flash('success', "Edit information successfully");
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/member/edit-profile");
    }

    public function changePasswordPage()
    {
        [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        $countPlacedOrders = $this->userService->countPlacedOrders(Auth::id());
        $countCancelOrders = $this->userService->countCancelOrders(Auth::id());
        $countWishlist = count(Auth::user()->wishlist);

        $categories = $this->categoryService->findAll();
        return view("customer.member.change-password", [
            'title' => "Change password",
            "categories" => $categories,
            'countProductsInCart' => $countProductsInCart ?? 0,
            "countPlacedOrders" => $countPlacedOrders,
            "countCancelOrders" => $countCancelOrders,
            "countWishlist" => $countWishlist
        ]);
    }

    public function handleChangePassword(ChangePasswordRequest $request)
    {
        try {
            $this->userService->changePassword(Auth::user(), $request->new_password, $request->current_password);
            session()->flash('success', 'Change password successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/member/change-password");
    }

    public function orders(Request $request)
    {
        $categories = $this->categoryService->findAll();
        [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        $countPlacedOrders = $this->userService->countPlacedOrders(Auth::id());
        $countCancelOrders = $this->userService->countCancelOrders(Auth::id());
        $countWishlist = count(Auth::user()->wishlist);

        $orders = $this->userService->showOrdersWithFilterInCustomer(Auth::id(), $request->time_sort);

        return view("customer.member.orders", [
            'title' => "My Orders",
            "categories" => $categories,
            "orders" => $orders,
            'countProductsInCart' => $countProductsInCart ?? 0,
            "countPlacedOrders" => $countPlacedOrders,
            "countCancelOrders" => $countCancelOrders,
            "countWishlist" => $countWishlist
        ]);
    }

    public function orderDetailsPage(Order $order)
    {
        if ($order->customer_id != Auth::id()) {
            return abort(404);
        }

        $categories = $this->categoryService->findAll();
        [$countProductsInCart] = $this->userService->countProductsAndCalculatePriceInCart(Auth::user());
        $countPlacedOrders = $this->userService->countPlacedOrders(Auth::id());
        $countCancelOrders = $this->userService->countCancelOrders(Auth::id());
        $countWishlist = count(Auth::user()->wishlist);

        return view("customer.member.order-details", [
            'title' => "Order Details",
            "categories" => $categories,
            "order" => $order,
            'countProductsInCart' => $countProductsInCart ?? 0,
            "countPlacedOrders" => $countPlacedOrders,
            "countCancelOrders" => $countCancelOrders,
            "countWishlist" => $countWishlist
        ]);
    }
}
