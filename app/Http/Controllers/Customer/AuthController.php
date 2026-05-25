<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //Register API
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return apiResponse(false,'unvalid Data',$validator->errors(),422);
        }

        $customer = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $customer->createToken('Customer_Token')->plainTextToken;

        return apiResponse(true,'register succeessfully',['token' => $token,'customer' =>$customer],200);
    }

    // login API
    public function login(Request $request){
       $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return apiResponse(false,'unvalid Data',$validator->errors(),422);
        }

        
        $customer = User::where('email', $request->email)->first();

        if (!$customer) {

            // return apiResponse(false,'Customer not found, please register',$customer,404);
            $customer = User::create([
                'email' => $request->emial,
                'password' => $request->password,
            ]);
        }

        if (!Hash::check($request->password, $customer->password)) {

            return apiResponse( false, 'Invalid Password', [], 401 );
        }


        $token = $customer->createToken('Customer_Token')->plainTextToken;

        return apiResponse(true,'Customer Login',[ 'token' => $token , 'customer' => $customer, 200]);
    }

    //Forgate Password API
    public function forgotPassword(Request $request){


        
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

        $customer = auth()->user();

        if (!Hash::check($request->old_password, $customer->password)) {

            return apiResponse(false,'Old Password Incorrect',[],401);
        }

        $customer->update([
            'password' => Hash::make($request->new_password)
        ]);

        return apiResponse(true,'Password Changed Successfully',[],200);
    }

}
