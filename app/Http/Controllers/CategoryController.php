<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function home(Request $request)
    {
        $categories = Category::paginate(10);
        
        if ($kw = request()->kw) {
            $categories = Category::orderBy('id', 'ASC')
                ->where(function ($query) use ($kw) {
                    $query->where('name', 'like', '%' . $kw . '%');

                })
                ->paginate(10);

                

            
        }
        return view('admin.categories.category', [
            'categories' => $categories,
            'breadcumbs' => ['titles' => ['Categories']],
            'title' => 'Manage Categories',
            compact('categories')
        ]);



    }

    public function create()
    {
        
        return view('admin.categories.create', [
            'breadcumbs' => ['titles' => ['Category', 'Create'], 'title_links' => ["/categories"]],
            'title' => 'Create category'
        ]);
    }

    public function handleCreate(CategoryRequest $request)
    {
        
        try {
            
            Category::create([
                'name' => $request['name']
                
            ]);
            
            session()->flash('success', 'create category was successful!');
        } catch (\Exception $err) {
            session()->flash('error', 'create category was not successful!');
        }

        return redirect()->back();
    }


    public function edit(Category $category)
    {
  
        return view('admin.categories.edit', [
            'category' => $category,
            'breadcumbs' => ['titles' => ['Categories', 'Edit'], 'title_links' => ["/admin/categories"]],
            'title' => 'Edit category'
        ]);
    }

    public function handleUpdate(Category $category, CategoryRequest $request)
    {
        try {
            $request->request->add(['updated_at' => date(config('global.date_format'))] );
            $category->fill($request->input());
            $category->save();
            session()->flash('success', 'update category was successful!');
        } catch (\Exception $err) {
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

            foreach ($categoryIds as $index => $categoryIds) {
                $categoryIds = Category::find($categoryIds);

                if (is_null($categoryIds)) {
                    session()->flash('error', 'Delete category was not successful! in position ' . $index);
                    return redirect()->back();
                }

                $categoryIds->delete();
                session()->flash('success', 'Delete category was successful!');

            }
        } catch (\Exception $err) {
            session()->flash('error', 'Delete category was not successful!');
        }

        return redirect()->back();
    }

}
