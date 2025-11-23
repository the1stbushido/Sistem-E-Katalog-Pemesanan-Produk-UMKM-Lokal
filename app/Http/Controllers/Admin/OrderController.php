<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan.
     */
    public function index()
    {
        // Ambil pesanan, yang terbaru di atas
        $orders = Order::orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        // Load relasi 'items' dan 'product' di dalam 'items'
        $order->load('items.product');
        
        // Kirim data order ke view baru 'admin.orders.show'
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Konfirmasi pembayaran tunai.
     */
    public function confirmCashPayment(Order $order)
    {
        if ($order->payment_method == 'cash' && $order->status == 'pending') {
            $order->update([
                'status' => 'paid',
                'paid_at' => now()
            ]);
            return redirect()->route('admin.orders.index')->with('success', 'Pembayaran tunai untuk Order #'.$order->id.' berhasil dikonfirmasi.');
        }

        return redirect()->route('admin.orders.index')->with('error', 'Gagal mengkonfirmasi pembayaran.');
    }
}