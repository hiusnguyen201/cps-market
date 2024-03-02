<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function home()
    {
        $users = User::all();
        return view('admin.users.home', ['users' => $users]);



    }

    public function createUser()
    {

        $roles = Role::all();
        return view('admin.users.create', ['roles' => $roles, 'genders' => config('global.genders')]);


    }

    public function handleCreateUser(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'gender' => 'required|integer',
            'role' => 'required|integer'

        ], [
            'name.required' => 'Name is required',
            'name.string' => 'Invalid',
            'email.required' => 'Email is reuired',
            'email.email' => 'Invalid email',
            'email.unique' => 'Email was registered',
            'phone.required' => 'Phone is required',
            'phone.string' => 'Invalid',
            'gender.required' => 'Gender is required',
            'gender.integer' => 'Invalid',
            'role.required' => 'Role is required',
            'role.integer' => 'Invalid',
        ]);

        $request->request->remove('_token');



        try {
            $password = Str::random(16);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'gender' => $request['gender'],
                'role_id' => $request['role'],
                'password' => Hash::make($password)
            ]);

            $request->session()->flash('success', 'create user was successful!');
            return redirect()->back();

        } catch (\Exception $err) {
            $request->session()->flash('error', 'create user was not successful!');
        }




    }


    public function editUser(User $user)
    {

        $roles = Role::all();
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'genders' => config('global.genders')
        ]);

    }

    public function updateUser(User $user, Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'gender' => 'required|integer',
            'role' => 'required|integer'

        ], [
            'name.required' => 'Name is required',
            'name.string' => 'Invalid',
            'email.required' => 'Email is reuired',
            'email.email' => 'Invalid email',
            'phone.required' => 'Phone is required',
            'phone.string' => 'Invalid',
            'gender.required' => 'Gender is required',
            'gender.integer' => 'Invalid',
            'role.required' => 'Role is required',
            'role.integer' => 'Invalid',
        ]);

        try {
            $user->fill($request->input());
            $user->save();
            $request->session()->flash('success', 'update user was successful!');
            return redirect()->back();
        } catch (\Exception $err) {
            $request->session()->flash('error', 'create user was not successful!');
            \log::info($err->getMessage());
            return false;
        }


    }

    public function deleteUser(Request $request)
    {
        $userIds = $request->input('id');


        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }
        dd($userIds);
        foreach ($userIds as $userId) {


            $user = User::find($userId);

            if (!is_null($user)) {
                $user->delete();
            }
        }

        return redirect()->back();
    }


}
