<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;

use App\Services\UserService;

class SettingController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function changePasswordPage()
    {
        return view("admin.settings.change-password", [
            "title" => "Change Password",
            'breadcumbs' => [
                'titles' => ['Password'],
            ],
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

        return redirect("/admin/settings/password");
    }
}
