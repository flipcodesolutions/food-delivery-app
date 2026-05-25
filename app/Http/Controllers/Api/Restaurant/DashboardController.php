<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $restaurant = $request->user();

        return response()->json([
            'status' => true,
            'data' => [
                'restaurant_name' => $restaurant->restaurant_name,
                'total_categories' => $restaurant->restaurantCategories()->count(),
                'total_menu_items' => $restaurant->menuItems()->count(),
            ]
        ]);
    }
}