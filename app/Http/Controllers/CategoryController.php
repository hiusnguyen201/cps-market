<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function home(Request $request)
    {
        $categories = Category::paginate(15);
        
        if ($kw = request()->kw) {
            $categories = Category::orderBy('id', 'ASC')
                ->where(function ($query) use ($kw) {
                    $query->where('name', 'like', '%' . $kw . '%');

                })
                ->paginate(15);

                

            
        }
        return view('Categories.category', [
            'categories' => $categories,
            'breadcumbs' => ['titles' => ['Categories']],
            'title' => 'Manage Categories',
            compact('categories')
        ]);



    }

    public function create()
    {
        
        return view('Categories.create', [
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
            
            session()->flash('success', 'create user was successful!');
        } catch (\Exception $err) {
            session()->flash('error', 'create user was not successful!');
        }

        return redirect()->back();
    }


    public function edit(Category $category)
    {
  
        return view('Categories.edit', [
            'category' => $category,
            'breadcumbs' => ['titles' => ['Users', 'Edit'], 'title_links' => ["/admin/users"]],
            'title' => 'Edit user'
        ]);
    }

    public function handleUpdate(Category $category, CategoryRequest $request)
    {
        try {
            $request->request->add(['updated_at' => date(config('global.date_format'))] );
            $category->fill($request->input());
            $category->save();
            session()->flash('success', 'update user was successful!');
        } catch (\Exception $err) {
            session()->flash('error', 'Edit user was not successful!');
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
                    session()->flash('error', 'Delete user was not successful! in position ' . $index);
                    return redirect()->back();
                }

                $categoryIds->delete();
                session()->flash('success', 'Delete user was successful!');

            }
        } catch (\Exception $err) {
            session()->flash('error', 'Delete user was not successful!');
        }

        return redirect()->back();
    }

}
