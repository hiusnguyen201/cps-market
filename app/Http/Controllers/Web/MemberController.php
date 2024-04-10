<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\ChangePasswordRequest;

use Illuminate\Support\Facades\Auth;

use App\Services\CategoryService;
use App\Services\UserService;

class MemberController extends Controller
{
    private CategoryService $categoryService;
    private UserService $userService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->userService = new UserService();
    }

    public function home()
    {
        $categories = $this->categoryService->findAll();
        return view("customer.account.home", [
            'title' => "Member",
            "user" => Auth::user(),
            "categories" => $categories
        ]);
    }

    public function user_info()
    {
        $categories = $this->categoryService->findAll();
        return view("customer.account.user-info", [
            'title' => "User info ",
            "user" => Auth::user(),
            "categories" => $categories
        ]);
    }

    public function handleUpdate_User_info(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'in:0,1,2',
            'address' => 'string|max:150',
        ]);

        try {
            $this->userService->updateInfoMember($request, Auth::user());
            session()->flash('success', "Edit information successfully");
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function changePasswordPage()
    {
        $categories = $this->categoryService->findAll();
        return view("customer.account.change-password", [
            'title' => "Change password",
            "user" => Auth::user(),
            "categories" => $categories
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

        return redirect()->back();
    }
}