<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Services\WishlistService;

class WishlistController extends Controller
{
    private WishlistService $wishlistService;

    public function handleCreate(Request $request)
    {
        try {
            $this->wishlistService->add($request->product_id, Auth::id());
            session()->flash('success', 'Add product to wishlist successfully');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }

    public function handleDelete(Request $request)
    {
        try {
            $this->wishlistService->delete($request->wishlist_id, Auth::id());
            session()->flash('success', 'Remove product from wishlist successfully!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->back();
    }
}
