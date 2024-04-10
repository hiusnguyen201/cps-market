<?php

namespace App\Services;

use Illuminate\Support\Str;

use App\Models\Brand;

class BrandService
{
    public function findAllCategories()
    {
        $brands = Brand::all();
        return $brands && count($brands) ? $brands : [];
    }

    public function findAllAndPaginate($request)
    {
        $brands = Brand::where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->kw . '%');
        });

        $brands = $brands->orderBy('created_at', 'desc')->paginate($request->limit ?? 10);

        return $brands && count($brands) ? $brands : [];
    }

    public function create($request)
    {
        try {
            $brand = Brand::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
            ]);

            $brand->categories()->attach($request->category);

            return $brand;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception('Create brand failed');
        }
    }

    public function update($request, $brand)
    {
        try {
            $status = $brand->update([
                'name' => $request->name,
                'updated_at' => now(),
                'slug' => Str::slug($request->name, '-')
            ]);

            $brand->categories()->detach();
            $brand->categories()->attach($request['category']);

            return $status;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception('Edit brand failed');
        }
    }

    public function deleteBrands($ids)
    {
        $position = null;
        try {
            foreach ($ids as $index => $id) {
                $brand = Brand::find($id);

                if (!$brand) {
                    throw new \InvalidArgumentException('Brand is not found in position ' . $index + 1);
                }

                $status = $brand->delete();
                if (!$status) {
                    $position = $index;
                    break;
                }
            }

            return true;
        } catch (\Exception $e) {
            throw new \Exception("Delete brand failed in position " . $position + 1);
        }
    }
}