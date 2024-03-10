<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\CategoriesBrand;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function home(Request $request)
    {
        $brandsQuery = Brand::with('categories');

        // Áp dụng điều kiện tìm kiếm nếu có
        $kw = $request->keyword;
        if ($kw) {
            $brandsQuery->where('name', 'like', '%' . $kw . '%');
        }

        // Lọc theo danh mục nếu được chọn
        if ($request->category) {
            $brandsQuery->whereHas('categories', function ($query) use ($request) {
                $query->where('id', $request->category);
            });
        }

        // Thực hiện phân trang
        $brands = $brandsQuery->paginate($request->limit ?? 10);

        $categories = Category::all();

        return view('admin.brands.home', [
            'brands' => $brands,
            'categories' => $categories,
            'limit_page' => config('global.limit_page'),
            'breadcumbs' => ['titles' => ['Brands']],
            'title' => 'Manage brands'
        ]);
    }


    public function details(Brand $brand)
    {
        $categories = $brand->categories()->get();
        return view('admin.brands.details', [
            'brand' => $brand,
            'categories' => $categories,
            'breadcumbs' => [
                'titles' => ['Brands', 'Details'],
                'title_links' => ["/admin/brands"]
            ],
            'title' => 'Details brand'
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
            'title' => 'Create brand'
        ]);
    }

    public function handleCreate(BrandRequest $request)
    {
        try {

            $brand = Brand::create([
                'name' => $request['name'],
            ]);

            CategoriesBrand::create([
                'brand_id' => $brand->id,
                'category_id' => $request['category'],
            ]);

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
        $brand->categories()->get();
        return view('admin.brands.edit', [
            'brand' => $brand,
            'categories' => $categories,
            'breadcumbs' => ['titles' => ['Brands', 'Brand'], 'title_links' => ["/admin/brands"]],
            'title' => 'Edit brand'
        ]);
    }

    public function handleUpdate(Brand $brand, BrandRequest $request)
    {
        try {
            $request->request->add(['updated_at' => date(config('global.date_format'))]);
            $brand->fill([
                'name' => $request->input('name'),
            ]);
            $brand->save();

            $newCategory = $request->input('category');
            DB::table('categories_brands')
                ->where('brand_id', $brand->id)
                ->update([
                    'category_id' => $newCategory,
                    'updated_at' => now()
                ]);

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

                DB::table('categories_brands')
                ->where('brand_id', $brand->id)->delete();
                
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
