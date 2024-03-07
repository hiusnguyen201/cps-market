<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function home(Request $request)
    {
        $kw = $request->keyword;

        $categories = Category::where(function ($query) use ($kw) {
            $query->orWhere('name', 'like', '%' . $kw . '%');
        });

        $categories = $categories->paginate($request->limit ?? 10);

        return view('admin.categories.home', [
            'categories' => $categories,
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Categories']],
            'title' => 'Manage Categories',
            compact('categories')
        ]);
    }

    public function details(Category $category)
    {
        return view('admin.categories.details', [
            'category' => $category,
            'user_status' => config('constants.user_status'),
            'breadcumbs' => ['titles' => ['Categories', 'Details'], 'title_links' => ["/admin/categories"]],
            'title' => 'Details Category'
        ]);
    }

    public function create()
    {
        return view('admin.categories.create', [
            'breadcumbs' => ['titles' => ['Categories', 'Create'], 'title_links' => ["/admin/categories"]],
            'title' => 'Create Category'
        ]);
    }

    public function handleCreate(CategoryRequest $request)
    {
        try {
            Category::create([
                'name' => $request['name']
            ]);

            session()->flash('success', 'create category was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'create category was not successful!');
        }
        return redirect()->back();
    }


    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'breadcumbs' => ['titles' => ['Categories', 'Edit'], 'title_links' => ["/admin/categories"]],
            'title' => 'Edit Category'
        ]);
    }

    public function handleUpdate(Category $category, CategoryRequest $request)
    {
        try {
            $request->request->add(['updated_at' => date(config('constants.date_format'))]);
            $category->fill($request->input());
            $category->save();
            session()->flash('success', 'update category was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Edit category was not successful!');
        }
        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $categoryIds = $request->id;

            if (!is_array($categoryIds)) {
                $categoryIds = [$categoryIds];
            }

            foreach ($categoryIds as $index => $categoryId) {
                $category = Category::find($categoryId);

                if (is_null($category)) {
                    session()->flash('error', 'Delete category was not successful! in position ' . $index);
                    return redirect()->back();
                }
                $category->delete();
                session()->flash('success', 'Delete category was successful!');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Delete category was not successful!');
        }

        return redirect()->back();
    }
}
