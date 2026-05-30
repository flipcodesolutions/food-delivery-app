<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\RestaurantCategory;
use App\Models\User;
use Illuminate\Http\Request;
class RestaurantListController extends Controller
{
    public function restaurants(Request $request, $id)
{
    $restaurant = User::with('restaurant')
    ->withAvg('reviews', 'rating')
    ->withCount('reviews')
    ->firstWhere([
        'id' => $id,
        'role' => 'restaurant'
    ]);

    if (!$restaurant) {

        return apiResponse(false, 'Restaurant not found', [], 404);
    }

    // categories
    $categories = RestaurantCategory::whereHas('menuItems', function ($q) use ($id) {
        $q->where('restaurant_id', $id);
    })->get();

    // menu query
   $menuQuery = MenuItem::where('restaurant_id', $id)
    ->where('status', 'active')
    ->where('is_available', 1);

    // category filter
    if ($request->filled('category_id')) {

        $menuQuery->where('category_id', $request->category_id);
    }

    $menu = $menuQuery->get();

    return apiResponse(true, 'Restaurant menu fetched successfully', [

        'restaurant' => [

            'id' => $restaurant->id,
            'owner_name' => $restaurant->name,
            'email' => $restaurant->email,
            'phone' => $restaurant->phone,

            // restaurant profile
            'restaurant_name' => optional($restaurant->restaurant)->restaurant_name,
            'detail' => optional($restaurant->restaurant)->detail,
            'logo' => optional($restaurant->restaurant)->logo,
            'opening_time' => optional($restaurant->restaurant)->opening_time,
            'closing_time' => optional($restaurant->restaurant)->closing_time,
            'commission_rate' => optional($restaurant->restaurant)->commission_rate,

            'rating' => round($restaurant->reviews_avg_rating ?? 0, 1),
            'total_reviews' => $restaurant->reviews_count,
        ],

        'categories' => $categories,

        'menu' => $menu

        ], 200);
    }
  
    //All Category List
   

    public function CategoryList(Request $req)
    {
        // If you want optional id
        $id = $req->id;

        // If you only want single category (optional logic)
        if ($id) {

            $category = RestaurantCategory::select('id', 'name')
                ->where('restaurant_id', $id)
                ->get();

            return apiResponse(true, 'Category Detail', $category, 200);
        }

        // Otherwise all categories
        $categories = RestaurantCategory::select('id', 'name')->get();

        return apiResponse(true, 'All Categories Show', $categories, 200);
    }


}