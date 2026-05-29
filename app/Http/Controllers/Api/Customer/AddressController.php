<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function addAddress(Request $request){
        $validate = Validator::make($request->all(),[
            'type' =>'nullable|string',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'landmark' =>'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|string',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'is_default'=>'nullable|boolean',
        ]);

        if($validate->fails()){
            return apiResponse(false,'Invalid Data',$validate->errors(),422);
        }
        $userId = $request->user()->id;

        if($request->is_default == true){
            CustomerAddress :: where('user_id',$userId)
            ->update(['is_default'=>false]);

        }

        
        $address = CustomerAddress::create([
            'user_id' => $userId,
            'type' => $request->type,
            'address_line_1' =>$request->address_line_1,
            'address_line_2' =>$request->address_line_2,
            'landmark' => $request->landmark,
            'city' => $request->city,
            'state' =>$request->state,
            'pincode' => $request->pincode,
            'latitude' => $request->latitude,
            'longitude'=>$request->longitude,
            'is_default' => $request->is_default ?? false,
        ]);

        return apiResponse(true ,'Address Add Successfully',$address,201);
    }

    public function getAddress(Request $request){
     
        $userId = $request->user()->id;
    $address = CustomerAddress::where('user_id',$userId)
    ->latest()
    ->get();

    return apiResponse(true ,'Address fetched Successfully',$address,200);

    }

    public function updateAddress(Request $request,$id){
         $validate = Validator::make($request->all(),[
            'type' =>'nullable|string',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'landmark' =>'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|string',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'is_default'=>'nullable|boolean',
        ]);

        
        if($validate->fails()){
            return apiResponse(false,'Invalid Data',$validate->errors(),422);
        }
        $userId = $request->user()->id;

        $address = CustomerAddress::where('user_id',$userId)
        ->find($id);

            if (!$address) {
        return apiResponse(false, 'Address not found', null, 404);
    }
        if($request->is_default == true){
            CustomerAddress :: where('user_id',$userId)
            ->update(['is_default'=>false]);

        }
         $address->update([
        'type' => $request->type,
        'address_line_1' => $request->address_line_1,
        'address_line_2' => $request->address_line_2,
        'landmark' => $request->landmark,
        'city' => $request->city,
        'state' => $request->state,
        'pincode' => $request->pincode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'is_default' => $request->is_default ?? $address->is_default,
    ]);

    return apiResponse(true, 'Address updated successfully', $address, 200);
}
    }
        
