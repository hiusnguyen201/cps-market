<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Specification;

class AttributeController extends Controller
{
    public function findAllAttributeByCategory(Category $category) {
        try {
            $brands = $category->brands()->get();
            $specifications = Specification::with('attributes')->where("category_id", $category->id)->get();

            if ($brands) {
                return response()->json([
                    'message' => 'Success',
                    'brands' => $brands ?? [],
                    'specifications' => $specifications ?? [],
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