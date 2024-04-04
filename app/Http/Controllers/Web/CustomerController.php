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

class CustomerController extends Controller
{
    public function home(Request $request)
    {
        $kw = $request->keyword;

        $users = User::where(function ($query) use ($kw) {
            $query->orWhere('name', 'like', '%' . $kw . '%');
            $query->orWhere('email', 'like', '%' . $kw . '%');
        })->whereHas('role', function ($query) {
            $query->where('name', '=', 'customer');
        });

        if ($request->status) {
            $users = $users->where('status', $request->status);
        }

        $users = $users->paginate($request->limit ?? 10);

        return view('admin.customers.home', [
            'users' => $users, compact('users'),
            'user_status' => config('constants.user_status'),
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Customers']],
            'title' => 'Manage Customers'
        ]);
    }

    public function details(User $user)
    {
        return view('admin.customers.details', [
            'user' => $user,
            'user_status' => config('constants.user_status'),
            'genders' => config('constants.genders'),
            'breadcumbs' => ['titles' => ['Customers', 'Details'], 'title_links' => ["/admin/customers"]],
            'title' => 'Details Customer'
        ]);
    }

    public function create()
    {
        return view('admin.customers.create', [
            'breadcumbs' => [
                'titles' => ['Customers', 'Create'],
                'title_links' => ["/admin/customers"]
            ],
            'genders' => config('constants.genders'),
            'title' => 'Create Customer'
        ]);
    }

    public function handleCreate(UserRequest $request)
    {
        try {
            $role = Role::where('name', 'customer')->first();
            $password = Str::random(16);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'gender' => $request['gender'],
                'role_id' => $role->id,
                'password' => Hash::make($password)
            ]);

            $details = ["email" => $user->email, "password" => $password];
            SendPassCreateUser::dispatch($details);

            session()->flash('success', 'Create customer was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Create customer was not successful!');
        }

        return redirect()->back();
    }


    public function edit(User $user)
    {
        return view('admin.customers.edit', [
            'user' => $user,
            'genders' => config('constants.genders'),
            'breadcumbs' => [
                'titles' => ['Customers', 'Edit'],
                'title_links' => ["/admin/customers"]
            ],
            'title' => 'Edit Customer'
        ]);
    }

    public function handleUpdate(User $user, UserRequest $request)
    {
        try {
            $request->request->add(['updated_at' => now()]);
            $user->fill($request->input());
            $user->save();
            session()->flash('success', 'Edit customer was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Edit customer was not successful!');
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
                    session()->flash('error', 'Delete customer was not successful! in position ' . $index);
                    return redirect()->back();
                }

                $user->delete();
                session()->flash('success', 'Delete customer was successful!');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Delete customer was not successful!');
        }

        return redirect()->back();
    }
}
