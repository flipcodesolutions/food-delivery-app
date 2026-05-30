<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\RestaurantOffer;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $search = trim($request->search);

    if (!$search) {
        return apiResponse(false, 'Search keyword is required', [], 422);
    }

    // Search restaurants
    $restaurants = User::where('role', 'restaurant')
        ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
        ->with(['restaurant','menuItems' => function ($query) {
            $query->where('status', 'active')
                  ->where('is_available', 1);
        }])
         ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->get();

    // Search foods
    $foodItems = MenuItem::whereRaw('LOWER(item_name) LIKE ?', ["%{$search}%"])
        ->where('status', 'active')
        ->where('is_available', 1)
        ->with('restaurant.restaurant')
        ->get();

    $foodRestaurants = [];

    foreach ($foodItems as $item) {

        if (!$item->restaurant) {
            continue;
        }

        $restaurant = $item->restaurant;

        if (!isset($foodRestaurants[$restaurant->id])) {

            $foodRestaurants[$restaurant->id] = [
                'restaurant_id'   => $restaurant->id,
                'restaurant_name' => $restaurant->name,
                'restaurant_image'=> $restaurant->image,
                'foods' => []
            ];
        }

        $foodRestaurants[$restaurant->id]['foods'][] = [
            'id' => $item->id,
            'item_name' => $item->item_name,
            'price' => $item->price,
            'discount_price' => $item->discount_price,
            'image' => $item->image,
        ];
        
    }

    return apiResponse(true, 'Search Result', [
        'restaurant_results' => $restaurants,
        // 'profile' => $restaurant->restaurant,
        'food_results' => array_values($foodRestaurants),
    ]);
}

    //SEARCH Restaurant List API

    public function restaurantList(Request $request)
{
    $search = $request->search;

    $restaurants = User::where('role', 'restaurant')
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->get();

    return apiResponse(true, 'Restaurant List', $restaurants, 200);
}

   public function restaurantOffer()
    {
        // Get Restaurant Offers
        $offers = RestaurantOffer::with('restaurant.restaurant')
            ->where('is_active', true)
    
            // Only non-expired offers
            ->where(function ($query) {
                $query->whereNull('expire_at')
                      ->orWhereDate('expire_at', '>=', now());
            })
    
            ->latest()
            ->get()
    
            ->map(function ($offer) {
    
                return [
                    'id' => $offer->id,
    
                    'offer_text' => $offer->offer_text,
    
                    'banner' => $offer->banner
                        ? asset('storage/' . $offer->banner)
                        : null,
                        
                    'expire_at' => $offer->expire_at,
    
                    'restaurant_id' => $offer->restaurant->id ?? null,
    
                    'restaurant_name' => $offer->restaurant->name ?? '',
                ];
            });
    
        return apiResponse(true,'Restaurant Offer Show',$offers,200);
    }
  
}
