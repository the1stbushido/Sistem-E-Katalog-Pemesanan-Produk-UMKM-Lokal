<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Get sales report with date range filter.
     */
    public function sales(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = Order::where('status', 'paid');

        // Apply date filters
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->with('items')->get();

        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Group by payment method
        $salesByPaymentMethod = $orders->groupBy('payment_method')->map(function ($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum('total_amount'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'start_date' => $request->start_date ?? 'all',
                    'end_date' => $request->end_date ?? 'all',
                ],
                'summary' => [
                    'total_sales' => $totalSales,
                    'total_orders' => $totalOrders,
                    'average_order_value' => round($averageOrderValue, 2),
                ],
                'by_payment_method' => $salesByPaymentMethod,
            ],
        ], 200);
    }

    /**
     * Get dashboard statistics.
     */
    public function dashboard()
    {
        // Today's sales
        $todaySales = Order::where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        // Total orders
        $totalOrders = Order::count();

        // Pending orders
        $pendingOrders = Order::where('status', 'pending')->count();

        // Total products
        $totalProducts = Product::count();

        // Available products
        $availableProducts = Product::where('is_available', true)->count();

        // Recent orders (last 5)
        $recentOrders = Order::with('items')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'table_number' => $order->table_number,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'payment_method' => $order->payment_method,
                    'created_at' => $order->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'today_sales' => $todaySales,
                'total_orders' => $totalOrders,
                'pending_orders' => $pendingOrders,
                'total_products' => $totalProducts,
                'available_products' => $availableProducts,
                'recent_orders' => $recentOrders,
            ],
        ], 200);
    }
}
