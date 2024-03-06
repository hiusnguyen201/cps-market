<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Requests\Admin\UserRequest;


class BrandController extends Controller
{
    public function home(Request $request)
    {
        //Search bar
        $kw = $request->keyword;

        $brands = Brand::where(function ($query) use ($kw) {
            $query->orWhere('name', 'like', '%' . $kw . '%');
        });

        $brands = $brands->paginate($request->limit ?? 10);

        return view('admin.brands.home', [
            'brands' => $brands, compact('brands'),
            // 'user_status' => config('global.user_status'),
            'limit_page' => config('global.limit_page'),
            'breadcumbs' => ['titles' => ['brands']],
            'title' => 'Manage brands'
        ]);
    }

    public function details(Brand $brand)
    {
        return view('admin.users.details', [
            'brand' => $brand,
            'user_status' => config('global.user_status'),
            'breadcumbs' => ['titles' => ['Users', 'Details'], 'title_links' => ["/admin/users"]],
            'title' => 'Details user'
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.brands.create', [
            'categories' => $categories,
            'breadcumbs' => ['titles' => ['Users', 'Create'],
            'title_links' => ["/admin/brands"]],
            'title' => 'Create brand'
        ]);
    }

    public function handleCreate(BrandRequest $request)
    {
        try {
            Brand::create([
                'name' => $request['name'],
            ]);

            session()->flash('success', 'create user was successful!');
        } catch (\Exception $err) {
            session()->flash('error', 'create user was not successful!');
        }

        return redirect()->back();
    }


    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', [
            'brand' => $brand,
            'breadcumbs' => ['titles' => ['Brands', 'Edit'], 'title_links' => ["/admin/brands"]],
            'title' => 'Edit user'
        ]);
    }

    public function handleUpdate(User $user, UserRequest $request)
    {
        try {
            $request->request->add(['updated_at' => date(config('global.date_format'))]);
            $user->fill($request->input());
            $user->save();
            session()->flash('success', 'update user was successful!');
        } catch (\Exception $err) {
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
        } catch (\Exception $err) {
            session()->flash('error', 'Delete user was not successful!');
        }

        return redirect()->back();
    }
}
