<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RestaurantController extends Controller
{
    public function index(Request $request){
       

        $restaurants=User::where('role','restaurant');
        if($request->filled('search')){
            $restaurants->where('name','like','%' .$request->search .'%');
        }
        if($request->filled('status')){
            $restaurants->where('status',$request->status);
        }
        $restaurants=$restaurants->latest()->paginate(10);
        return view('admin.restaurants.index',compact('restaurants'));
    }
}
