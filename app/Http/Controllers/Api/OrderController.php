<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with filters.
     */
    public function index(Request $request)
    {
        $query = Order::with('items')->withCount('items');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by table number
        if ($request->has('table_number')) {
            $query->where('table_number', $request->table_number);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Sort by latest
        $query->latest();

        // Pagination
        $perPage = $request->get('per_page', 15);
        $orders = $query->paginate($perPage);

        return OrderResource::collection($orders);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        return response()->json([
            'success' => true,
            'data' => new OrderResource($order->load('items')),
        ], 200);
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
            'paid_at' => $request->status === 'paid' ? now() : $order->paid_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diupdate.',
            'data' => new OrderResource($order->load('items')),
        ], 200);
    }

    /**
     * Confirm cash payment.
     */
    public function confirmPayment(Order $order)
    {
        if ($order->payment_method !== 'cash') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya pesanan dengan metode pembayaran cash yang dapat dikonfirmasi.',
            ], 422);
        }

        if ($order->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan sudah dikonfirmasi sebelumnya.',
            ], 422);
        }

        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran cash berhasil dikonfirmasi.',
            'data' => new OrderResource($order->load('items')),
        ], 200);
    }
}
