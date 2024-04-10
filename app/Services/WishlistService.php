<?php

namespace App\Services;

use App\Models\Wishlist;

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
            error_log($e->getMessage());
            throw new \Exception("Remove product from wishlist failed");
        }
    }

    public function add($request, $userId)
    {
        try {
            $wishlist = Wishlist::create([
                'product_id' => $request->product_id,
                'user_id' => $userId,
            ]);

            return $wishlist;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception("Add product to wishlist failed");
        }
    }
}