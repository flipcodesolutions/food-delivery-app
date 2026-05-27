<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request){
        
        $users = User::query();
        if($request->filled('search')){
            $users->where('name','like','%' . $request->search .'%');
        }
        if($request->filled('status')){
            $users->where('status',$request->status);
        }
        $users=$users->latest()->paginate(10);
        return view('admin.users.index',compact('users'));


    }

    public function create(){
        return view('admin.users.create');
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:10|min:10',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,customer,restaurant,delivery_partner',
            'status' => 'required|in:active,inactive,pending',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' =>$request->status,
        ]);
        return redirect()->route('admin.users.index')->with('success','User created successfully');
    
    }
    public function edit($id){
        $user=User::findOrFail($id);
        return view('admin.users.edit',compact('user'));
    }
    public function update(Request $request,$id){
        $user=User::findOrFail($id);

         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:10|min:10',
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,customer,restaurant,delivery_partner',
            'status' => 'required|in:active,inactive,pending',
        ]);
        $data=[
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' =>$request->status,
        ];
        if($request->filled('password')){
            $data['password']=Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success','User updated successfully');
    }
    public function destroy($id){
        $user=User::findOrFail($id);
        if($user->role=='admin'){
            return redirect()->back()->with('error','Admin cannot be deleted');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted successfully');
    }

}
