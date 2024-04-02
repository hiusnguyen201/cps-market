<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpecificationRequest;
use App\Models\Attribute as ModelsAttribute;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Specification;

class SpecificationController extends Controller
{
    public function add(Category $category)
    {
        return view('admin.specifications.create', [
            'breadcumbs' => [
                'titles' => ['Categories', 'Details', "Specifications"],
                'title_links' => ["/admin/categories", "/admin/categories/details/".$category->id]
            ],
            'title' => 'Create Specification',
            'category' => $category,
        ]);
    }

    public function handleAdd(SpecificationRequest $request)
    {
        try {
            $specification = Specification::create([
                'name' => $request->name,
                'category_id' => $request->id,
            ]);

            foreach ($request->input('attributes') as $attribute) {
                if ($attribute === null) {
                    continue;
                }
                ModelsAttribute::create([
                    'specification_id' => $specification->id,
                    'key' => $attribute,
                ]);
            }

            session()->flash('success', 'create category was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'create category was not successful!');
        }
        return redirect()->back();
    }

    public function edit(Category $category, Specification $specification)
    {
        return view('admin.specifications.edit', [
            'category' => $category,
            'specification' => $specification,
            'breadcumbs' => ['titles' => ['Categories', 'Details', "Specifications"], 'title_links' => ["/admin/categories", "/admin/categories/details/".$category->id]],
            'title' => 'Edit Specification'
        ]);
    }

    public function handleUpdate(SpecificationRequest $request)
    {
        try {
            $specification = Specification::findOrFail($request->id);
            $specification->name = $request->input('name');
            $specification->updated_at = now();
            $specification->save();

            if ($request->input('attributes_new')) {
                foreach ($request->input('attributes_new') as $attribute) {
                    if ($attribute === null) {
                        continue;
                    }
                    ModelsAttribute::create([
                        'specification_id' => $specification->id,
                        'key' => $attribute,
                    ]);
                }
            }

            $attributes_update = json_decode($request->attributes_update, true);
            if (!empty($attributes_update)) {
                foreach ($attributes_update as $item) {
                    $attribute = ModelsAttribute::findOrFail($item['attributeId']);
                    if ($attribute) {
                        if ($item['key']) {
                            $attribute->update([
                                'key' => $item['key'],
                            ]);
                        } else {
                            $attribute->delete();
                        }
                    } else {
                        session()->flash('error', 'Edit specification was not successful!');
                    }
                }
            }

            $attributesToDelete = json_decode($request->attributes_delete);
            if ($attributesToDelete) {
                foreach ($attributesToDelete as $attributeId) {
                    ModelsAttribute::findOrFail($attributeId)->delete();
                }
            }

            session()->flash('success', 'update specification was successful!');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            dd($e);
            session()->flash('error', 'Edit specification was not successful!');
        }
        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $specificationIds = $request->id;

            if (!is_array($specificationIds)) {
                $specificationIds = [$specificationIds];
            }

            foreach ($specificationIds as $index => $specificationId) {
                $specification = Specification::find($specificationId);

                if (is_null($specificationId)) {
                    session()->flash('error', 'Delete category was not successful! in position ' . $index);
                    return redirect()->back();
                }
                $specification->delete();
                session()->flash('success', 'Delete category was successful!');
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            session()->flash('error', 'Delete category was not successful!');
        }

        return redirect()->back();
    }
}