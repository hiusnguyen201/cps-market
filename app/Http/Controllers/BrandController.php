<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Requests\Admin\BrandRequest;


class BrandController extends Controller
{
    public function home(Request $request)
    {
        //Search bar
        $kw = $request->keyword;

        $brands = Brand::with('category')->where(function ($query) use ($kw) {
            $query->orWhere('name', 'like', '%' . $kw . '%');
        });
        $categories = Category::all();

        if($request->category) {
            $brands = $brands->where('category_id', $request->category);
        }

        $brands = $brands->paginate($request->limit ?? 10);
        
        return view('admin.brands.home', [
            'brands' => $brands, compact('brands'),
            'categories' => $categories,
            'limit_page' => config('global.limit_page'),
            'breadcumbs' => ['titles' => ['Brands']],
            'title' => 'Manage brands'
        ]);
    }

    public function details(Brand $brand)
    {
        return view('admin.brands.details', [
            'brand' => $brand,
            'breadcumbs' => ['titles' => ['Brands', 'Details'],
            'title_links' => ["/admin/brands"]],
            'title' => 'Details brand'
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.brands.create', [
            'categories' => $categories,
            'breadcumbs' => ['titles' => ['Brands', 'Create'],
            'title_links' => ["/admin/brands"]],
            'title' => 'Create brand'
        ]);
    }

    public function handleCreate(BrandRequest $request)
    {
        try {
            Brand::create([
                'name' => $request['name'],
                'category_id' => $request['category'],
            ]);

            session()->flash('success', 'create brand was successful!');
        } catch (\Exception $err) {
            session()->flash('error', 'create brand was not successful!');
        }

        return redirect()->back();
    }


    public function edit(Brand $brand)
    {
        $categories = Category::all();
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
            $brand->fill($request->input());
            $brand->save();
            session()->flash('success', 'Update brand was successful!');
        } catch (\Exception $err) {
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

                $brand->delete();
                session()->flash('success', 'Delete brand was successful!');
            }
        } catch (\Exception $err) {
            session()->flash('error', 'Delete brand was not successful!');
        }

        return redirect()->back();
    }
}
