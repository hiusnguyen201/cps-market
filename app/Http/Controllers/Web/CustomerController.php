<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;

use App\Services\UserService;

use App\Models\User;

class CustomerController extends Controller
{
    private UserService $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function home(Request $request)
    {
        $users = $this->userService->findAllAndPaginateWithRole($request, "customer");
        if (!count($users) && +$request->page > 1) {
            return redirect()->route('admin.customers.home', ['page' => +$request->page - 1]);
        }

        return view('admin.customers.home', [
            'users' => $users,
            'breadcumbs' => ['titles' => ['Customers']],
            'title' => 'Manage Customers'
        ]);
    }

    public function details(User $user)
    {
        return view('admin.customers.details', [
            'user' => $user,
            'breadcumbs' => ['titles' => ['Customers', 'Details'], 'title_links' => [route("admin.customers.home")]],
            'title' => 'Details Customer'
        ]);
    }

    public function create()
    {
        return view('admin.customers.create', [
            'breadcumbs' => [
                'titles' => ['Customers', 'Create'],
                'title_links' => [route("admin.customers.home")]
            ],
            'title' => 'Create Customer'
        ]);
    }

    public function handleCreate(UserRequest $request)
    {
        try {
            $this->userService->createUserWithRole($request, "customer");
            session()->flash('success', 'Create customer was successful!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/admin/customers/create");
    }


    public function edit(User $user)
    {
        return view('admin.customers.edit', [
            'user' => $user,
            'breadcumbs' => [
                'titles' => ['Customers', 'Edit'],
                'title_links' => [route("admin.customers.home")]
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

        return redirect("/admin/customers/edit/" . $user->id);
    }

    public function handleDelete(Request $request)
    {
        try {
            $userIds = is_array($request->id) ? $request->id : [$request->id];
            $this->userService->deleteUsers($userIds, "customer");
            session()->flash('success', 'Delete customer successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/admin/customers");
    }
}
