<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class ProductService
{
    public function findAllAndPaginate($request)
    {
        $products = Product::where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->kw . '%');
        });

        if ($request->category) {
            $products = $products->where("category_id", $request->category);
        }

        $products = $products->orderBy('created_at', "desc")->paginate($request->limit ?? 10);

        return $products && count($products) ? $products : [];
    }

    public function deleteProducts($ids)
    {

        $position = null;
        try {
            foreach ($ids as $index => $id) {
                $product = Product::find($id);
                if (!$product) {
                    throw new \InvalidArgumentException("Product is not found in position " . $position + 1);
                }

                foreach ($product->images as $image) {
                    $folder_path = explode("/", $image->thumbnail)[0];
                    if (Storage::directoryExists("public/" . $folder_path)) {
                        Storage::deleteDirectory("public/" . $folder_path);
                        break;
                    }
                }

                $status = $product->delete();
                if (!$status) {
                    $position = $index;
                    break;
                }
            }

            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception('Delete product failed in position ' . $position + 1);
        }

    }

    public function findOneBySlug($slug)
    {
        if (!$slug) {
            return null;
        }

        $product = Product::where(['slug' => $slug])->first();
        return $product ? $product : null;
    }

    public function findAllWithLimitBestSoldInDay($limit)
    {
        $products = Product::whereDate('updated_at', today())
            ->orderBy('sold', 'desc')
            ->limit($limit)
            ->get();

        return $products && count($products) ? $products : [];
    }

    public function findAllWithLimitBestSoldInWeek($limit)
    {
        $products = Product::whereDate('updated_at', today())
            ->orderBy('sold', 'desc')
            ->limit($limit)
            ->get();

        return $products && count($products) ? $products : [];
    }

    public function findAllWithLimitBestSoldInMonth($limit)
    {
        $products = Product::whereYear('updated_at', now()->year)
            ->whereMonth('updated_at', now()->month)
            ->orderBy('sold', 'desc')
            ->limit(3)
            ->get();

        return $products && count($products) ? $products : [];
    }

    public function findAllWithLimitByCategoryName($limit, $categoryName)
    {
        $products = Product::whereHas('category', function ($query) use ($categoryName) {
            $query->where('name', $categoryName);
        })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $products && count($products) ? $products : [];
    }
}