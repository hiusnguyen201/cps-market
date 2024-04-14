<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Attribute;

class ProductService
{
    public function findAllAndPaginate($request)
    {
        $products = Product::where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->keyword . '%');
        });

        if ($request->category) {
            $products = $products->where("category_id", $request->category);
        }

        $products = $products->orderBy('created_at', "desc")->paginate($request->limit ?? 10);

        return $products && count($products) ? $products : [];
    }

    public function findOneById($id)
    {
        if (!$id) {
            return null;
        }

        $product = Product::find($id);
        return $product ? $product : null;
    }

    public function searchProductWithFilterInCustomer($request)
    {
        $products = Product::where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
            $query->where('price', '>=', $request->price_min ?? 0);
            $query->where('price', '<=', $request->price_max ?? 100000000);
            if ($request->category_id) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->brand_id) {
                $query->where('brand_id', $request->brand_id);
            }
        });

        switch ($request->sort_by ?? 'newest') {
            case 'latest':
                $products = $products->orderBy('created_at', "asc");
                break;

            case 'lowest_price':
                $products = $products->orderBy('price', "asc");
                break;

            case 'highest_price':
                $products = $products->orderBy('price', "desc");
                break;

            default:
                $products = $products->orderBy('created_at', "desc");
                break;
        }

        return $products;
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
            if ($e->getCode() != 0) {
                throw new \Exception('Delete product failed in position ' . $position + 1);
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function findAllAttributesByCategoryId($categoryId)
    {
        $attributes = Attribute::whereHas('specification', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->get();

        return $attributes && count($attributes) ? $attributes : [];
    }

    public function findOneBySlug($slug)
    {
        if (!$slug) {
            return null;
        }

        $product = Product::where(['slug' => $slug])->first();
        return $product ? $product : null;
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
            ->limit($limit)
            ->get();

        return $products && count($products) ? $products : [];
    }
    public function findAllWithLimitBestSoldInYear($limit)
    {
        $products = Product::whereYear('updated_at', now()->year)
            ->orderBy('sold', 'desc')
            ->limit($limit)
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

    public function calculateTotalExpense()
    {
        $total = Product::all()->sum(function ($product) {
            return $product->quantity * $product->market_price;
        });
        return $total ? $total : 0;
    }

    public function getSimilarProductsWithLimit($brandId, $limit)
    {
        $product = Product::where("brand_id", $brandId)->inRandomOrder()->limit($limit)->get();
        return $product && count($product) ? $product : [];
    }

}