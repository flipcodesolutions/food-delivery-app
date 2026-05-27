<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\RestaurantOffer;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;

        if (!$search) {

            return apiResponse(false,'Search keyword is required',[],422);
        }

        //search Restaurant
        $restaurants = User::where('role', 'restaurant')
            ->where('name', 'LIKE', "%{$search}%")
            ->get();

        // Search Food Items
        $foodItems = MenuItem::where('item_name', 'LIKE', "%{$search}%")
            ->where('status', 'active')
            ->where('is_available', 1)
            ->with('restaurant')
            ->get();
        
        // Group Food By Restaurant

        $foodRestaurants = [];

        foreach ($foodItems as $item) {

            $restaurant = $item->restaurant;

            if (!$restaurant) {
                continue;
            }

            $restaurantId = $restaurant->id;

            if (!isset($foodRestaurants[$restaurantId])) {

                $foodRestaurants[$restaurantId] = [
                    'restaurant_id' => $restaurant->id,
                    'restaurant_name' => $restaurant->name,
                    'foods' => []
                ];
            }

            $foodRestaurants[$restaurantId]['foods'][] = [
                'id' => $item->id,
                'item_name' => $item->item_name,
                'price' => $item->price,
                'discount_price' => $item->discount_price,
                'image' => $item->image,
            ];
        }

        return apiResponse(
            true,
            'Search Result',
            [
                'restaurants' => $restaurants,
                'food_restaurants' => array_values($foodRestaurants)
            ]
        );
    }

    //SEARCH Restaurant List API

    public function restaurantList(Request $request)
    {

        $search = $request->search;

        $restaurants = User::where('role', 'restaurant')

            ->when($search, function ($query) use ($search) {

                $query->where('name', 'LIKE', "%{$search}%");
            })->get();
            
        return apiResponse(true,'Restaurant List',$restaurants,200);
    }

   public function restaurantOffer(Request $request)
    {
        // Get Restaurant Offers
        $offers = RestaurantOffer::with('restaurant')
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
    
                    'address' => $offer->restaurant->address ?? '',
                ];
            });
    
        return apiResponse(true,'Restaurant Offer Show',$offers,200);
    }
}
