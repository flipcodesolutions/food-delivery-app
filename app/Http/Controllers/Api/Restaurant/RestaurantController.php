<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function getRestaurantProfile()
    {
        $profile = Restaurant::where('user_id', auth()->id())->first();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Profile not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $profile
        ]);
    }

    public function updateRestaurantProfile(Request $request)
    {
        $profile = Restaurant::where('user_id', auth()->id())->first();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Profile not found'
            ], 404);
        }

        $request->validate([
            'restaurant_name' => 'nullable|string|max:255',
            'detail' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'opening_time' => 'nullable',
            'closing_time' => 'nullable',
            'commission_rate' => 'nullable|numeric'
        ]);

        $profile->restaurant_name = $request->restaurant_name ?? $profile->restaurant_name;
        $profile->detail = $request->detail ?? $profile->detail;
        $profile->opening_time = $request->opening_time ?? $profile->opening_time;
        $profile->closing_time = $request->closing_time ?? $profile->closing_time;
        $profile->commission_rate = $request->commission_rate ?? $profile->commission_rate;

        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/restaurants'), $filename);

            $profile->logo = 'uploads/restaurants/' . $filename;
        }

        $profile->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $profile->fresh()
        ]);
    }
}