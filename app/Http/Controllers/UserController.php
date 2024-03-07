<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\UserRequest;

use function PHPSTORM_META\type;

class UserController extends Controller
{
    public function home(Request $request)
    {
        $kw = $request->keyword;

        $users = User::where(function ($query) use ($kw) {
            $query->orWhere('name', 'like', '%' . $kw . '%');
            $query->orWhere('email', 'like', '%' . $kw . '%');
        });

        if ($request->role) {
            $users = $users->where('role_id', $request->role);
        }

        if ($request->status) {
            $users = $users->where('status', $request->status);
        }

        $users = $users->paginate($request->limit ?? 10);

        $roles = Role::all();

        return view('admin.users.home', [
            'users' => $users, compact('users'),
            'user_status' => config('constants.user_status'),
            'roles' => $roles,
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Users']],
            'title' => 'Manage Users'
        ]);
    }

    public function details(User $user)
    {
        return view('admin.users.details', [
            'user' => $user,
            'user_status' => config('constants.user_status'),
            'genders' => config('constants.genders'),
            'breadcumbs' => ['titles' => ['Users', 'Details'], 'title_links' => ["/admin/users"]],
            'title' => 'Details User'
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', [
            'roles' => $roles, 'genders' => config('constants.genders'),
            'breadcumbs' => ['titles' => ['Users', 'Create'], 'title_links' => ["/admin/users"]],
            'title' => 'Create User'
        ]);
    }

    public function handleCreate(UserRequest $request)
    {
        try {
            $password = Str::random(16);
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'gender' => $request['gender'],
                'role_id' => $request['role'],
                'password' => Hash::make($password)
            ]);

            session()->flash('success', 'create user was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'create user was not successful!');
        }

        return redirect()->back();
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'genders' => config('constants.genders'),
            'breadcumbs' => ['titles' => ['Users', 'Edit'], 'title_links' => ["/admin/users"]],
            'title' => 'Edit User'
        ]);
    }

    public function handleUpdate(User $user, UserRequest $request)
    {
        try {
            $request->request->add(['updated_at' => now()]);
            $user->fill($request->input());
            $user->save();
            session()->flash('success', 'update user was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Edit user was not successful!');
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $userIds = $request->id;

            if (!is_array($userIds)) {
                $userIds = [$userIds];
            }

            foreach ($userIds as $index => $userId) {
                $user = User::find($userId);

                if (is_null($user)) {
                    session()->flash('error', 'Delete user was not successful! in position ' . $index);
                    return redirect()->back();
                }

                $user->delete();
                session()->flash('success', 'Delete user was successful!');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Delete user was not successful!');
        }

        return redirect()->back();
    }
}
