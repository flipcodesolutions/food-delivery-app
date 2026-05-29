<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|unique:users,phone',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {

        return apiResponse(
            false,
            'Invalid Data',
            $validator->errors(),
            422
        );
    }

    // Create User
    $customer = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'status' => 1,
        'role' => 'customer',
    ]);

    // Create User Profile Automatically
    UserProfile::create([
        'user_id' => $customer->id,
    ]);

    // Generate Token
    $token = $customer->createToken('Customer_Token')->plainTextToken;

    return apiResponse(
        true,
        'Register Successfully',
        [
            'token' => $token,
            'customer' => $customer
        ],
        200
    );
}

    // login API
    public function login(Request $request){
       $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return apiResponse(false,'unvalid Data',$validator->errors(),422);
        }

        
        $customer = User::where('email', $request->email)->first();

        if (!$customer) {

            return apiResponse(false,'Customer not found, please register',$customer,404);
        
        }

        if (!Hash::check($request->password, $customer->password)) {

            return apiResponse( false, 'Invalid Password', [], 401 );
        }

        $token = $customer->createToken('Customer_Token')->plainTextToken;

        return apiResponse(
    true,
    'Customer Login',
    [
        'token' => $token,
        'customer' => $customer
    ],
    200
);
    }

   
public function forgotPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {

        return apiResponse(
            false,
            'Validation Error',
            $validator->errors(),
            422
        );
    }

    // Send Reset Link
    $status = Password::sendResetLink(
        $request->only('email')
    );

    // Success
    if ($status === Password::RESET_LINK_SENT) {

        return apiResponse(
            true,
            'Reset password link sent successfully',
            [],
            200
        );
    }

    return apiResponse(
        false,
        'Unable to send reset link',
        [],
        400
    );
}

public function resetPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    if ($validator->fails()) {

        return apiResponse(
            false,
            'Validation Error',
            $validator->errors(),
            422
        );
    }

    $status = Password::reset(

        $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ),

        function ($user, $password) {

            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {

        return apiResponse(
            true,
            'Password reset successfully',
            [],
            200
        );
    }

    return apiResponse(
        false,
        'Invalid token or email',
        [],
        400
    );
}
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6'
        ]);

        if ($validator->fails()) {

            return apiResponse(false,'Validation Error',$validator->errors(),422 );
        }

        $customer = $request->user();

        if (!Hash::check($request->old_password, $customer->password)) {

            return apiResponse(false,'Old Password Incorrect',[],401);
        }

        $customer->update([
            'password' => Hash::make($request->new_password)
        ]);

        return apiResponse(true,'Password Changed Successfully',[],200);
    }

}
