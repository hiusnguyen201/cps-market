<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class BrandController extends Controller
{
    public function getAllByCategory(Category $category)
    {
        try {
            $brands = $category->brands()->get();

            if ($brands) {
                return response()->json([
                    'message' => 'Success',
                    'brands' => $brands ?? []
                ], 200);
            } else {
                return response()->json([
                    'message' => 'No brands found',
                ], 404);
            }
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'Server Error',
                'error' => $err
            ], 500);
        }
    }
}