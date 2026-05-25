<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // ---------------- REGISTER ----------------
    public function restaurantRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'restaurant_name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'restaurant_name' => $request->restaurant_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => 'restaurant',
            'status' => 'active',
        ]);

        $token = $user->createToken('RestaurantToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Restaurant registered successfully',
            'token' => $token,
            'data' => $user
        ]);
    }

    // ---------------- LOGIN ----------------
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

    // ---------------- LOGOUT ----------------
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }

    // ---------------- FORGOT PASSWORD ----------------
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
            ? response()->json(['status' => true, 'message' => 'Reset link sent'])
            : response()->json(['status' => false, 'message' => 'Unable to send reset link'], 500);
    }

    // ---------------- RESET PASSWORD ----------------
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
            ? response()->json(['status' => true, 'message' => 'Password reset successful'])
            : response()->json(['status' => false, 'message' => 'Reset failed'], 500);
    }

    // ---------------- CHANGE PASSWORD ----------------
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
