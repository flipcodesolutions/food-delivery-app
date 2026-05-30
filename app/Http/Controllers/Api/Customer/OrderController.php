<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:cod,online',
            'delivery_address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        $customer = auth()->user();

        $cart = Cart::where('user_id',$customer->id)->first();


        $cartItems = CartItem::with('menuItem')
            ->where('cart_id', $cart->id)
            ->get();

        if ($cartItems->isEmpty()) {

            return response()->json([
                'status' => false,
                'message' => 'Cart is empty',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $subtotal = 0;

            foreach ($cartItems as $item) {
                $subtotal += $item->quantity * $item->menuItem->price;
            }

            $deliveryCharge = 40;
            $tax = ($subtotal * 5) / 100;
            $discount = 0;

            $grandTotal = $subtotal + $deliveryCharge + $tax - $discount;

            // restaurant id from first cart item
            $restaurantId = $cartItems->first()->menuItem->restaurant_id;

            $order = Order::create([
                'order_number' => 'ORD' . rand(100000, 999999),

                'customer_id' => $customer->id,
                'restaurant_id' => $restaurantId,

                'subtotal' => $subtotal,
                'delivery_charge' => $deliveryCharge,
                'tax' => $tax,
                'discount' => $discount,
                'grand_total' => $grandTotal,

                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method == 'cod'
                    ? 'unpaid'
                    : 'paid',

                'delivery_address' => $request->delivery_address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            foreach ($cartItems as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item->menu_item_id,
                    'quantity' => $item->quantity,
                    'price' => $item->menuItem->price,
                    'total' => $item->quantity * $item->menuItem->price,
                ]);
            }

            // clear cart
            CartItem::where('cart_id', $cart->id)->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'data' => $order->load('items.menuItem')
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function myOrders()
    {
        $orders = Order::with('items.menuItem')
            ->where('customer_id', auth()->id())
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'My orders fetched successfully',
            'data' => $orders
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::with('items.menuItem')
            ->where('customer_id', auth()->id())
            ->find($id);

        if (!$order) {

            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Order details fetched successfully',
            'data' => $order
        ]);
    }

    public function cancelOrder($id)
    {
        $order = Order::where('customer_id', auth()->id())
            ->find($id);

        if (!$order) {

            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ], 404);
        }

        if ($order->order_status != 'pending') {

            return response()->json([
                'status' => false,
                'message' => 'Order cannot be cancelled now',
            ], 400);
        }

        $order->update([
            'order_status' => 'cancelled'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order cancelled successfully',
            'data' => $order
        ]);
    }
}