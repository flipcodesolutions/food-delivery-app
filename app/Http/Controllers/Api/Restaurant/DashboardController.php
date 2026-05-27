<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $restaurant = $request->user();
        $restaurantId = $restaurant->id;

        $totalCategories = $restaurant->restaurantCategories()->count();
        $totalMenuItems = MenuItem::where('restaurant_id', $restaurantId)->count();

        $totalOrders = Order::where('restaurant_id', $restaurantId)->count();

        $todayOrders = Order::where('restaurant_id', $restaurantId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $pendingOrders = Order::where('restaurant_id', $restaurantId)
            ->where('status', 'pending')
            ->count();

        $completedOrders = Order::where('restaurant_id', $restaurantId)
            ->where('status', 'completed')
            ->count();

        $totalEarnings = Order::where('restaurant_id', $restaurantId)
            ->where('status', 'completed')
            ->sum('total_amount');

        $todayEarnings = Order::where('restaurant_id', $restaurantId)
            ->where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        $topItems = MenuItem::where('restaurant_id', $restaurantId)
            ->withCount(['orderItems as sold_count'])
            ->orderByDesc('sold_count')
            ->take(5)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Dashboard data fetched successfully',
            'data' => [
                'restaurant_name' => $restaurant->restaurant_name,

                'overview' => [
                    'total_categories' => $totalCategories,
                    'total_menu_items' => $totalMenuItems,
                ],

                'orders' => [
                    'total_orders' => $totalOrders,
                    'today_orders' => $todayOrders,
                    'pending_orders' => $pendingOrders,
                    'completed_orders' => $completedOrders,
                ],

                'earnings' => [
                    'total_earnings' => $totalEarnings,
                    'today_earnings' => $todayEarnings,
                ],

                'top_selling_items' => $topItems,
            ]
        ]);
    }
}
