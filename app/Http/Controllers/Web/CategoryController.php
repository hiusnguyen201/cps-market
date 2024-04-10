<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\CategoryRequest;
use App\Services\CategoryService;
use App\Models\Category;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }


    public function home(Request $request)
    {
        $categories = $this->categoryService->findAllAndPaginate($request);
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
            $this->categoryService->create($request);
            session()->flash('success', 'Create category successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
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
            $this->categoryService->update($request, $category);
            session()->flash('success', 'Edit category successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $categoryIds = is_array($request->id) ? $request->id : [$request->id];
            $this->categoryService->deleteCategories($categoryIds);
            session()->flash('success', 'Delete category successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
}