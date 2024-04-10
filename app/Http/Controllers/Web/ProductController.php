<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\AttributeService;

use App\Models\Product;

class ProductController extends Controller
{
    private ProductService $productService;
    private CategoryService $categoryService;
    private AttributeService $attributeService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
    }

    public function home(Request $request)
    {
        $products = $this->productService->findAllAndPaginate($request);
        $categories = $this->categoryService->findAll();

        return view('admin.products.home', [
            'products' => $products,
            "categories" => $categories,
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Products']],
            'title' => 'Manage Products'
        ]);
    }

    public function details(Product $product)
    {
        return view('admin.products.details', [
            'product' => $product,
            'breadcumbs' => [
                'titles' => ['Products', 'Details'],
                'title_links' => ["/admin/products"]
            ],
            'title' => 'Details Product',
        ]);
    }

    public function create()
    {
        $categories = $this->categoryService->findAll();
        return view('admin.products.create', [
            'categories' => $categories,
            'breadcumbs' => [
                'titles' => ['Products', 'Create'],
                'title_links' => ["/admin/products"]
            ],
            'title' => 'Create Product',
        ]);
    }

    public function edit(Product $product)
    {
        $attributes = $this->attributeService->findAllWithSpecificationByCategoryId($product);
        $categories = $this->categoryService->findAll();

        return view('admin.products.edit', [
            'categories' => $categories,
            'product' => $product,
            'attributes' => $attributes,
            'breadcumbs' => [
                'titles' => ['Products', 'Edit'],
                'title_links' => ["/admin/products"]
            ],
            'title' => 'Edit Product',
        ]);
    }

    public function handleDelete(Request $request)
    {
        try {
            $ids = is_array($request->id) ? $request->id : [$request->id];
            $this->productService->deleteProducts($ids);
            session()->flash('success', 'Delete product successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
}