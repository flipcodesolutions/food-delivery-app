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
        ->where('role', 'restaurant')
        ->find($id);

    if (!$restaurant) {

        return apiResponse(false, 'Restaurant not found', [], 404);
    }

    // categories
    $categories = RestaurantCategory::whereHas('menuItems', function ($q) use ($id) {
        $q->where('restaurant_id', $id);
    })->get();

    // menu query
    $menuQuery = MenuItem::where('restaurant_id', $id);

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
            'restaurant_name' => optional($restaurant->restaurantProfile)->restaurant_name,
            'detail' => optional($restaurant->restaurantProfile)->detail,
            'logo' => optional($restaurant->restaurantProfile)->logo,
            'opening_time' => optional($restaurant->restaurantProfile)->opening_time,
            'closing_time' => optional($restaurant->restaurantProfile)->closing_time,
            'commission_rate' => optional($restaurant->restaurantProfile)->commission_rate,
        ],

        'categories' => $categories,

        'menu' => $menu

    ], 200);
}
    // $id =  $request->id;

    // $data  =  User:: find($id);
    // $menu =  MenuItem::where('restaurant_id',$id)->get();
    // return $menu;


        // $categoryId = $request->category_id;

        // $restaurants = User::where('role', 'restaurant')
        //     ->get()
        //     ->map(function ($restaurant) use ($categoryId) {

        //         // Always return ALL categories (never filter)
        //         $categories = RestaurantCategory::whereHas('menuItems', function ($query) use ($restaurant) {
        //             $query->where('restaurant_id', $restaurant->id);
        //     })
        //     ->select('id', 'name')
        //     ->get();

        //     // Foods query (filtered only when category selected)
        //     $foodsQuery = MenuItem::with('category')
        //         ->where('restaurant_id', $restaurant->id);

        //     // filter by category only if selected
        //     if (!empty($categoryId)) {
        //         $foodsQuery->where('category_id', $categoryId);
        //     }

        //     $foods = $foodsQuery->get()
        //         ->map(function ($food) {
        //             return [
        //                 'id' => $food->id,
        //                 'name' => $food->item_name,
        //                 'price' => $food->price,
        //                 'image' => $food->image,
        //                 'category_id' => $food->category_id,
        //                 'category_name' => optional($food->category)->name,
        //             ];
        //         });

        //     return [
        //         'id' => $restaurant->id,
        //         'name' => $restaurant->name,
        //         'image' => $restaurant->image,
        //         'rating' => $restaurant->rating,
        //         'delivery_time' => $restaurant->delivery_time,
        //         'offer' => $restaurant->offer,
        //         'cuisine' => $restaurant->cuisine,

        //         'categories' => $categories,
        //         'foods' => $foods,
        //     ];
        // });

    // return apiResponse(true, 'Restaurant list fetched successfully', $restaurants, 200);
    
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