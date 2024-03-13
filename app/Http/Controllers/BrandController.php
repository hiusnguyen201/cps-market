<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Requests\Admin\BrandRequest;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function home(Request $request)
    {
        // Áp dụng điều kiện tìm kiếm nếu có
        $brands = Brand::where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->keyword . '%');
        })->whereHas('categories', function ($query) use ($request) {
            if ($request->category) {
                $query->where('categories.id', $request->category);
            }
        });

        // Thực hiện phân trang
        $brands = $brands->paginate($request->limit ?? 10);

        $categories = Category::all();

        return view('admin.brands.home', [
            'brands' => $brands,
            'categories' => $categories,
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Brands']],
            'title' => 'Manage brands | Cps Market'
        ]);
    }


    public function details(Brand $brand)
    {
        $brand->categories()->get();
        return view('admin.brands.details', [
            'brand' => $brand,
            'breadcumbs' => [
                'titles' => ['Brands', 'Details'],
                'title_links' => ["/admin/brands"]
            ],
            'title' => 'Details brand | Cps Market'
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.brands.create', [
            'categories' => $categories,
            'breadcumbs' => [
                'titles' => ['Brands', 'Create'],
                'title_links' => ["/admin/brands"]
            ],
            'title' => 'Create brand | Cps Market'
        ]);
    }

    public function handleCreate(BrandRequest $request)
    {
        try {
            $brand = Brand::create([
                'name' => $request['name'],
            ]);

            $brand->categories()->attach($request['category']);

            session()->flash('success', 'Create brand was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Create brand was not successful!');
        }

        return redirect()->back();
    }


    public function edit(Brand $brand)
    {
        $categories = Category::all();

        $brand_category_ids = [];
        foreach ($brand->categories as $category) {
            array_push($brand_category_ids, $category->id);
        }

        return view('admin.brands.edit', [
            'brand' => $brand,
            'categories' => $categories,
            'brand_category_ids' => $brand_category_ids,
            'breadcumbs' => ['titles' => ['Brands', 'Brand'], 'title_links' => ["/admin/brands"]],
            'title' => 'Edit brand | Cps Market'
        ]);
    }

    public function handleUpdate(Brand $brand, BrandRequest $request)
    {
        try {
            $request->request->add(['updated_at' => now()]);
            $brand->fill($request->all());
            $brand->save();
            $brand->categories()->detach();
            $brand->categories()->attach($request['category']);

            session()->flash('success', 'Update brand was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Edit brand was not successful!');
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $brandIds = $request->id;

            if (!is_array($brandIds)) {
                $brandIds = [$brandIds];
            }

            foreach ($brandIds as $index => $brandIds) {
                $brand = Brand::find($brandIds);

                if (is_null($brand)) {
                    session()->flash('error', 'Delete brand was not successful! in position ' . $index);
                    return redirect()->back();
                }
                $brand->categories()->detach();
                $brand->delete();
                session()->flash('success', 'Delete brand was successful!');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Delete brand was not successful!');
        }

        return redirect()->back();
    }
}
