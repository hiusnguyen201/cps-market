<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    //
    public function index()
    {
        return view('layouts.customer.account', [
            'title' => "Account"
        ]);
    }

    public function home()
    {
        return view("customer.account.home", [
            'title' => "Account | Cps Market ",
        ]);
    }

    public function user_info()
    {
        return view("customer.account.user-info", [
            'title' => "User info | Cps Market ",
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
            $user = Auth::user();
            $user = User::findOrFail($user->id);
            $request->request->add(['updated_at' => now()]);
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->save();
            session()->flash('success', 'Update info was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Edit info was not successful!');
        }

        return redirect()->back();
    }

    public function change_password()
    {
        return view("customer.account.change-password", [
            'title' => "Change password | Cps Market ",
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
}
