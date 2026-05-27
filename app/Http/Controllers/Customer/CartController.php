<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $validate = Validator::make($request->all(),[
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if($validate->fails()){
            return apiResponse(false, 'Invalid Data', $validate->errors(),422);
        }

        $user = Auth()->user();

        $menuItem = MenuItem::find($request->menu_item_id);

        $cart = Cart::fisrtOrCreate(
            ['user_id' => $user->id],
            ['total_amount' => 0],
        );

        $cartItem = CartItem::where('cart_id',$cart->id)
        ->where('menu_item_id' ,$menuItem->id)
        ->first();

        if($cartItem){
            $cartItem->quantity += $request->quantity;
            $cartItem->total_price = $request->quantity * $menuItem->price;

            $cartItem->save();
        }else{
            CartItem::create([
                'cart_id' => $cart->id,
                'menu_item_id' => $menuItem->id,
                'quantity' => $request->quantity,
                'price' => $menuItem->price,
                'total_price' => $menuItem->price * $request->quantity,
            ]);
        }

        $cart->total_amount = $cart->cartItems()->sum('total_price');

        $cart->save();

        return apiResponse(true ,'food Add To Cart' ,$cart ,200);
    }
}