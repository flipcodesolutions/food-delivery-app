<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\RestaurantCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // List Categories
    public function index(Request $request)
    {
        $categories = RestaurantCategory::where(
            'restaurant_id',
            $request->user()->id
        )->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    // Create Category
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('categories', 'public');
        }

        $category = RestaurantCategory::create([
            'restaurant_id' => $request->user()->id,
            'name' => $request->name,
            'detail' => $request->detail,
            'image' => $imagePath,
            'status' => 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }

    // Single Category
    public function show(Request $request, $id)
    {
        $category = RestaurantCategory::where('id', $id)
            ->where('restaurant_id', $request->user()->id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    // Update Category
    public function update(Request $request, $id)
    {
        $category = RestaurantCategory::where('id', $id)
            ->where('restaurant_id', $request->user()->id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('categories', 'public');

            $category->image = $imagePath;
        }

        $category->name = $request->name;
        $category->detail = $request->detail;
        $category->status = $request->status ?? $category->status;

        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    // Delete Category
    public function destroy(Request $request, $id)
    {
        $category = RestaurantCategory::where('id', $id)
            ->where('restaurant_id', $request->user()->id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
