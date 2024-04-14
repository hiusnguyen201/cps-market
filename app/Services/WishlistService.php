<?php

namespace App\Services;

use App\Models\Wishlist;
use App\Models\Product;

class WishlistService
{
    public function findAllByCustomerId($customerId)
    {
        $wishlist = Wishlist::where('user_id', $customerId)->get();
        return $wishlist && count($wishlist) ? $wishlist : [];
    }

    public function findOneByProductIdAndCustomerId($productId, $userId)
    {
        $wishlist = Wishlist::where([
            'product_id' => $productId,
            'user_id' => $userId
        ])->first();

        return $wishlist ? $wishlist : null;
    }

    public function delete($wishlistId, $userId)
    {
        try {
            $wishlist = Wishlist::where([
                "user_id" => $userId,
                "id" => $wishlistId
            ]);

            if (!$wishlist) {
                throw new \InvalidArgumentException("Wishlist not found");
            }

            $wishlist->delete();

            return true;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception("Remove product from wishlist failed");
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public function add($productId, $userId)
    {
        try {
            $product = Product::find($productId);
            if (!$product) {
                throw new \InvalidArgumentException("Product is not found");
            }

            $wishlist = Wishlist::create([
                'product_id' => $productId,
                'user_id' => $userId,
            ]);

            return $wishlist;
        } catch (\Exception $e) {
            if ($e->getCode() != 0) {
                throw new \Exception("Add product to wishlist failed");
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }
}