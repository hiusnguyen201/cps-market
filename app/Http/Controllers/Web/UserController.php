<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\UserRequest;
use App\Jobs\SendPassCreateUser;

class UserController extends Controller
{
    public function home(Request $request)
    {
        $users = User::where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->kw . '%');
            $query->orWhere('email', 'like', '%' . $request->kw . '%');
        })->whereHas('role', function ($query) {
            $query->where('name', '=', 'admin');
        })->orderBy('created_at', 'desc');

        if ($request->status) {
            $users = $users->where('status', $request->status);
        }

        $users = $users->paginate($request->limit ?? 10);

        return view('admin.users.home', [
            'users' => $users,
            compact('users'),
            'user_status' => config('constants.user_status'),
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
        return view('admin.users.create', [
            'breadcumbs' => [
                'titles' => ['Users', 'Create'],
                'title_links' => ["/admin/users"]
            ],
            'genders' => config('constants.genders'),
            'title' => 'Create User'
        ]);
    }

    public function handleCreate(UserRequest $request)
    {
        try {
            $role = Role::where('name', 'admin')->first();
            $password = Str::random(16);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'gender' => $request['gender'],
                'role_id' => $role->id,
                'password' => Hash::make($password)
            ]);

            $details = ["email" => $user->email, "password" => $password];
            SendPassCreateUser::dispatch($details);

            session()->flash('success', 'create user was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'create user was not successful!');
        }

        return redirect()->back();
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'genders' => config('constants.genders'),
            'breadcumbs' => [
                'titles' => ['Users', 'Edit'],
                'title_links' => ["/admin/users"]
            ],
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