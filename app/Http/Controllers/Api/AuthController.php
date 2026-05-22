<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Restaurant Register
     */
    public function restaurantRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name'              => 'required|string|max:255',
            'restaurant_name'   => 'required|string|max:255',
            'phone'             => 'required|unique:users,phone',
            'email'             => 'nullable|email|unique:users,email',
            'password'          => 'required|min:6',
            'address'           => 'nullable|string',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()

            ], 422);
        }

        $user = User::create([

            'name'              => $request->name,
            'restaurant_name'   => $request->restaurant_name,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'address'           => $request->address,

            'role'              => 'restaurant',
            'status'            => 'active',

        ]);

        $token = $user->createToken('RestaurantToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Restaurant registered successfully',
            'token' => $token,
            'data' => $user
        ]);
    }

    /**
     * Restaurant Login
     */
    public function restaurantLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'phone'     => 'required',
            'password'  => 'required',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $user = User::where('phone', $request->phone)
            ->where('role', 'restaurant')
            ->first();

        if (!$user) {

            return response()->json([
                'status' => false,
                'message' => 'Restaurant not found'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {

            return response()->json([
                'status' => false,
                'message' => 'Invalid password'
            ], 401);
        }

        $token = $user->createToken('RestaurantToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'data' => $user
        ]);
    }

    // logout api

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }
}
