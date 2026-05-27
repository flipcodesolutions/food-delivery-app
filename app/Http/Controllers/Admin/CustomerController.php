<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index(Request $request){
        
        $customers=User::where('role','customer');
        if($request->filled('search')){
            $customers->where('name','like','%' .$request->search .'%');
        }
        if($request->filled('status')){
            $customers->where('status',$request->status);
        }
        $customers=$customers->latest()->paginate(10);
        return view('admin.customer.index',compact('customers'));
    }
}
