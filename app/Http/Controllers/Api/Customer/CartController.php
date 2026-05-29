<?php

namespace App\Http\Controllers\Api\Customer;

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

        $cart = Cart::firstOrCreate(
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

        return apiResponse(true ,'food Add To Cart' ,[$cart,$cartItem] ,200);
    }

    //Get Cart
    public function getCart(){
        $user = Auth()->user();

        $cart = Cart::with('cartItems.menuItem')
        ->where('user_id',$user->id)
        ->first();

        if(!$cart){
            return apiResponse(false ,'Cart is Empty');
        }

        return apiResponse(true , 'Cart Data' ,$cart ,200);
    }
    public function updateCart(Request $request,$id){
        $validate = Validator::make($request->all(),[
            'quantity' => 'required|integer|min:1'
        ]);

        if($validate->fails()){
            return apiResponse(false ,'invalid data' ,$validate->errors(),422);
        }

        $cartItem = CartItem::find($id);

        if(!$cartItem){
            return apiResponse(false, 'Cart Item not Found');
        }

        $cartItem->quantity = $request->quantity;

        $cartItem->total_price = $cartItem->price * $request->qauntity;

        $cartItem->save();

        $cart = Cart::find($cartItem->id);

        $cart->total_amount = $cart->cartItems->sum('total_price');

        $cart->save();

        return apiResponse(true, 'cart update',$cart,200);
    }

    public function removeCartItem(Request $request,$id){
        $cartItem = CartItem::find($id);

        if(!$cartItem){
            return apiResponse(false, 'cart item not found',$cartItem);
        }

        $cart = Cart::find($cartItem->cart_id);

        $cartItem->delete();

       $cart->total_amount = $cart->cartItems()->sum('total_price');

        $cart->save();

        return apiResponse(true , 'Cart Item is reomved' ,$cart ,200);
    }

    public function clearCart()
{
    $user = auth()->user();

    $cart = Cart::where('user_id', $user->id)->first();

    if (!$cart) {

        return response()->json([
            'status' => false,
            'message' => 'Cart already empty',
        ]);
    }

    // delete all items first
    $cart->cartItems()->delete();

    // reset total
    $cart->total_amount = 0;
    $cart->save();

    return response()->json([
        'status' => true,
        'message' => 'Cart cleared successfully',
    ]);
}
}
