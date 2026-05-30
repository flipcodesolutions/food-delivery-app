<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserProfile;

class ProfileController extends Controller
{
    // Show Profile
    public function profile()
    {
        $user = auth()->user();

        $profile = UserProfile::where('user_id', $user->id)
            ->select(
                'id',
                'user_id',
                'wallet_balance',
                'profile_image'
            )
            ->first();

        return response()->json([
            'status' => true,
            'message' => 'Profile fetched successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'status' => $user->status,
                ],
                'profile' => $profile
            ]
        ]);
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|digits:10',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        $user = auth()->user();

        // Update user table
        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->phone) {
            $user->phone = $request->phone;
        }

        $user->save();

        // Get profile
        $profile = UserProfile::where('user_id', $user->id)->first();

        // Upload image
        if ($request->hasFile('profile_image')) {

            $image = $request->file('profile_image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('/profile_images'), $imageName);

            $profile->profile_image = 'profile_images/' . $imageName;
        }

        $profile->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'user' => $user,
                'profile' => $profile
            ]
        ]);
    }
}