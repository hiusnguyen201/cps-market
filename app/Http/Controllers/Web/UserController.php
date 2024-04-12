<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Admin\UserRequest;
use App\Services\RoleService;
use App\Services\UserService;

use App\Models\User;

class UserController extends Controller
{
    private RoleService $roleService;
    private UserService $userService;

    public function __construct()
    {
        $this->roleService = new RoleService();
        $this->userService = new UserService();
    }

    public function home(Request $request)
    {
        $users = $this->userService->findAllAndPaginateWithRole($request, "admin");
        if (!count($users) && +$request->page > 1) {
            return redirect()->route('admin.users.home', ['page' => +$request->page - 1]);
        }

        return view('admin.users.home', [
            'users' => $users,
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Users']],
            'title' => 'Manage Users'
        ]);
    }

    public function details(User $user)
    {
        return view('admin.users.details', [
            'user' => $user,
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
            'title' => 'Create User'
        ]);
    }

    public function handleCreate(UserRequest $request)
    {
        try {
            $role = $this->roleService->findRoleByName("admin");
            $this->userService->createUserWithRole($request, $role);
            session()->flash('success', 'Create user successfully');
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
        }

        return redirect()->back();
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'breadcumbs' => [
                'titles' => ['Users', 'Edit'],
                'title_links' => ["/admin/users"]
            ],
            'title' => 'Edit User',
            'user' => $user
        ]);
    }

    public function handleUpdate(User $user, UserRequest $request)
    {
        try {
            $this->userService->updateUser($request, $user);
            session()->flash('success', 'Edit user successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $userIds = is_array($request->id) ? $request->id : [$request->id];
            $this->userService->deleteUsers($userIds, "admin");
            session()->flash('success', 'Delete user was successful!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
}