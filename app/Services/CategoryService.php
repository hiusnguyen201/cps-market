<?php

namespace App\Services;

use Illuminate\Support\Str;

use App\Models\Category;

class CategoryService
{
    public function findAll()
    {
        $categories = Category::all();
        return $categories && count($categories) ? $categories : [];
    }

    public function findAllAndPaginate($request)
    {
        $categories = Category::where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->keyword . '%');
        });

        $categories = $categories->orderBy('created_at', 'desc')->paginate($request->limit ?? 10);

        return $categories && count($categories) ? $categories : [];
    }

    public function create($request)
    {
        try {
            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
            ]);

            return $category;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception('Create category failed');
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function update($request, $category)
    {
        try {
            $status = $category->update([
                'name' => $request->name,
                'updated_at' => now(),
                'slug' => Str::slug($request->name, '-')
            ]);

            return $status;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception('Edit category failed');
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function deleteCategories($ids)
    {
        $position = null;
        try {
            foreach ($ids as $index => $categoryId) {
                $category = Category::find($categoryId);

                if (!$category) {
                    throw new \InvalidArgumentException('Category is not found in position ' . $index + 1);
                }

                $status = $category->delete();
                if (!$status) {
                    $position = $index;
                    break;
                }
            }

            return true;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception("Delete category failed in position " . $position + 1);
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }
}