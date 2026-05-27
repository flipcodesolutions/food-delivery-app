<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\RestaurantCategory;
use App\Models\User;
use Illuminate\Http\Request;

class RestaurantListController extends Controller
{
    public function restaurants(Request $request)
    {
        $categoryId = $request->category_id;

        $restaurants = User::where('role', 'restaurant')
            ->get()
            ->map(function ($restaurant) use ($categoryId) {

                // Always return ALL categories (never filter)
                $categories = RestaurantCategory::whereHas('menuItems', function ($query) use ($restaurant) {
                    $query->where('restaurant_id', $restaurant->id);
            })
            ->select('id', 'name')
            ->get();

            // Foods query (filtered only when category selected)
            $foodsQuery = MenuItem::with('category')
                ->where('restaurant_id', $restaurant->id);

            // filter by category only if selected
            if (!empty($categoryId)) {
                $foodsQuery->where('category_id', $categoryId);
            }

            $foods = $foodsQuery->get()
                ->map(function ($food) {
                    return [
                        'id' => $food->id,
                        'name' => $food->item_name,
                        'price' => $food->price,
                        'image' => $food->image,
                        'category_id' => $food->category_id,
                        'category_name' => optional($food->category)->name,
                    ];
                });

            return [
                'id' => $restaurant->id,
                'name' => $restaurant->name,
                'image' => $restaurant->image,
                'rating' => $restaurant->rating,
                'delivery_time' => $restaurant->delivery_time,
                'offer' => $restaurant->offer,
                'cuisine' => $restaurant->cuisine,

                'categories' => $categories,
                'foods' => $foods,
            ];
        });

    return apiResponse(true, 'Restaurant list fetched successfully', $restaurants, 200);
    }
    //All Category List
    public function CategoryList(){
        $categories = RestaurantCategory::select(
            'id','name'
        )->get();

        return apiResponse(true, 'All Categories Show' ,$categories ,200);

    }


}