<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function restaurantRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'restaurant_name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'nullable|string',

            // optional restaurant fields
            'detail' => 'nullable|string',
            'logo' => 'nullable|string',
            'opening_time' => 'nullable',
            'closing_time' => 'nullable',
            'commission_rate' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'restaurant_name' => $request->get('restaurant_name'),
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => 'restaurant',
            'status' => 'active',
        ]);

        $profile = Restaurant::create([
            'user_id' => $user->id,
            'restaurant_name' => $request->restaurant_name,
            'detail' => $request->detail,
            'logo' => $request->logo,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'commission_rate' => $request->commission_rate,
        ]);

        $token = $user->createToken('RestaurantToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Restaurant registered successfully',
            'token' => $token,
            'data' => [
                'user' => $user,
                'restaurant' => $profile
            ]
        ]);
    }

    public function restaurantLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
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

        if ($user->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Account is inactive'
            ], 403);
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json([
                'status' => true,
                'message' => 'Reset link sent'
            ])
            : response()->json([
                'status' => false,
                'message' => 'Unable to send reset link'
            ], 500);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'status' => true,
                'message' => 'Password reset successful'
            ])
            : response()->json([
                'status' => false,
                'message' => 'Reset failed'
            ], 500);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Old password is incorrect'
            ], 401);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

       
        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
