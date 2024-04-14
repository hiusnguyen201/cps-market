<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Services\BrandService;
use App\Services\CategoryService;

use App\Models\Brand;

class BrandController extends Controller
{
    private CategoryService $categoryService;
    private BrandService $brandService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
    }

    public function home(Request $request)
    {
        $brands = $this->brandService->findAllAndPaginate($request);
        if (!count($brands) && +$request->page > 1) {
            return redirect()->route('admin.brands.home', ['page' => +$request->page - 1]);
        }
        $categories = $this->categoryService->findAll();

        return view('admin.brands.home', [
            'brands' => $brands,
            'categories' => $categories,
            'breadcumbs' => ['titles' => ['Brands']],
            'title' => 'Manage Brands'
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
            'title' => 'Details Brand'
        ]);
    }

    public function create()
    {
        $categories = $this->categoryService->findAll();
        return view('admin.brands.create', [
            'categories' => $categories,
            'breadcumbs' => [
                'titles' => ['Brands', 'Create'],
                'title_links' => ["/admin/brands"]
            ],
            'title' => 'Create Brand'
        ]);
    }

    public function handleCreate(BrandRequest $request)
    {
        try {
            $this->brandService->create($request);
            session()->flash('success', 'Create brand was successful!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/admin/brands/create");
    }

    public function edit(Brand $brand)
    {
        $categories = $this->categoryService->findAll();

        $brand_category_ids = [];
        foreach ($brand->categories as $category) {
            array_push($brand_category_ids, $category->id);
        }

        return view('admin.brands.edit', [
            'brand' => $brand,
            'categories' => $categories,
            'brand_category_ids' => $brand_category_ids,
            'breadcumbs' => ['titles' => ['Brands', 'Edit'], 'title_links' => ["/admin/brands"]],
            'title' => 'Edit Brand'
        ]);
    }

    public function handleUpdate(Brand $brand, BrandRequest $request)
    {
        try {
            $this->brandService->update($request, $brand);
            session()->flash('success', 'Edit brand was successful!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/admin/brands/edit/" . $brand->id);
    }

    public function handleDelete(Request $request)
    {
        try {
            $brandIds = is_array($request->id) ? $request->id : [$request->id];
            $this->brandService->deleteBrands($brandIds);
            session()->flash('success', 'Delete brand was successful!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect("/admin/brands");
    }
}