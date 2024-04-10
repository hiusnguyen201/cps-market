<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Services\UserService;
use App\Services\RoleService;

use App\Models\User;

class CustomerController extends Controller
{
    private UserService $userService;
    private RoleService $roleService;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->roleService = new RoleService();
    }
    public function home(Request $request)
    {
        $users = $this->userService->findAllAndPaginateWithRole($request, "customer");

        return view('admin.customers.home', [
            'users' => $users,
            compact('users'),
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
            $role = $this->roleService->findRoleByName("customer");
            $this->userService->createUserWithRole($request, $role);
            session()->flash('success', 'Create customer was successful!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
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
            $this->userService->updateUser($request, $user);
            session()->flash('success', 'Edit customer was successful!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $userIds = is_array($request->id) ? $request->id : [$request->id];
            $this->userService->deleteUsers($userIds, "customer");
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
}