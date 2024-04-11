<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SpecificationRequest;

use App\Services\SpecificationService;

use App\Models\Category;
use App\Models\Specification;

class SpecificationController extends Controller
{
    private SpecificationService $specificationService;
    public function __construct()
    {
        $this->specificationService = new SpecificationService();
    }
    public function add(Category $category)
    {
        return view('admin.specifications.create', [
            'breadcumbs' => [
                'titles' => ['Categories', 'Details', "Specifications"],
                'title_links' => ["/admin/categories", "/admin/categories/details/" . $category->id]
            ],
            'title' => 'Add Specification',
            'category' => $category,
        ]);
    }

    public function handleAdd(SpecificationRequest $request)
    {
        try {
            $this->specificationService->addSpecificationToCategory($request, $request->category_id);
            session()->flash('success', 'Add specification to category successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function edit(Category $category, Specification $specification)
    {
        return view('admin.specifications.edit', [
            'category' => $category,
            'specification' => $specification,
            'breadcumbs' => ['titles' => ['Categories', 'Details', "Specifications"], 'title_links' => ["/admin/categories", "/admin/categories/details/" . $category->id]],
            'title' => 'Edit Specification'
        ]);
    }

    public function handleUpdate(SpecificationRequest $request)
    {
        try {
            $this->specificationService->updateSpecification($request, $request->specification_id);
            session()->flash('success', 'Edit specification successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $this->specificationService->removeSpecificationFromCategory($request->id);
            session()->flash('success', 'Delete specification successfully!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
}