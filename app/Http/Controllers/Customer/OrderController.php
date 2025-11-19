<?php

namespace App\Http\Controllers\Customer; // <-- Pastikan namespace Anda BENAR

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Mengambil data keranjang dari session.
     */
    public function getCart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        return response()->json($cart);
    }

    /**
     * Menambah item ke keranjang di session.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $request->session()->get('cart', []);
        $productId = $request->product_id; // <-- PERBAIKAN (->)

        if (isset($cart[$productId])) {
            // Jika sudah ada, tambahkan quantity
            $cart[$productId]['quantity'] += $request->quantity; // <-- PERBAIKAN (->)
        } else {
            // Jika belum ada, tambahkan item baru
            $cart[$productId] = [
                'name' => $request->name, // <-- PERBAIKAN (->)
                'price' => $request->price, // <-- PERBAIKAN (->)
                'quantity' => $request->quantity, // <-- PERBAIKAN (->)
            ];
        }

        $request->session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'cart' => $cart
        ]);
    }

    /**
     * FUNGSI BARU UNTUK TOMBOL (+) DAN (-) DI KERANJANG
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string', // ID bisa jadi string dari JS
            'quantity' => 'required|integer' // JS akan kirim quantity baru
        ]);

        $cart = $request->session()->get('cart', []);
        $productId = $request->product_id; // <-- PERBAIKAN (->)

        if (isset($cart[$productId])) {
            if ($request->quantity > 0) {
                 // Langsung set quantity baru
                $cart[$productId]['quantity'] = $request->quantity; // <-- PERBAIKAN (->)
            } else {
                // Jika quantity 0, hapus
                unset($cart[$productId]);
            }
        }
        
        $request->session()->put('cart', $cart);
        
        return response()->json([
            'status' => 'success',
            'cart' => $cart
        ]);
    }

    /**
     * FUNGSI BARU UNTUK TOMBOL HAPUS (X) DI KERANJANG
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string', // ID bisa jadi string dari JS
        ]);
        
        $cart = $request->session()->get('cart', []);
        $productId = $request->product_id; // <-- PERBAIKAN (->)

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        $request->session()->put('cart', $cart);
        
        return response()->json([
            'status' => 'success',
            'cart' => $cart
        ]);
    }
    
    /**
     * Tampilkan halaman checkout.
     */
    public function checkout(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $tableNumber = $request->session()->get('table_number');

        if (empty($cart) || !$tableNumber) {
            return redirect()->route('customer.menu')->with('error', 'Keranjang kosong atau meja belum dipilih.');
        }

        return view('customer.checkout', compact('cart', 'tableNumber'));
    }

    /**
     * Simpan pesanan ke database (saat klik "Buat Pesanan").
     */
    public function store(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $tableNumber = $request->session()->get('table_number');

        if (empty($cart) || !$tableNumber) {
            return redirect()->route('customer.menu')->with('error', 'Sesi berakhir, silakan coba lagi.');
        }
        
        $request->validate([
            'payment_method' => 'required|in:cash,qris'
        ]);

        $totalPrice = 0;
        foreach ($cart as $id => $details) {
            $totalPrice += $details['price'] * $details['quantity'];
        }

        // Kita gunakan DB Transaction untuk memastikan data konsisten
        try {
            DB::beginTransaction();

            // 1. Buat Order
            $order = Order::create([
                'table_number' => $tableNumber,
                'total_amount' => $totalPrice,
                'payment_method' => $request->payment_method,
                'status' => 'pending', // Status awal
                'payment_token' => ($request->payment_method == 'qris') ? Str::uuid() : null,
                // 'order_code' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)), // Jika Anda punya kolom ini
            ]);

            // 2. Buat Order Items
            foreach ($cart as $id => $details) {
                // Pastikan $id adalah integer
                $productId = (int)$id;
                
                $subtotal = $details['price'] * $details['quantity'];
                OrderItem::create([
                    'order_id' => $order->id, // <-- PERBAIKAN (->)
                    'product_id' => $productId,
                    'product_name' => $details['name'],
                    'quantity' => $details['quantity'],
                    'price_at_purchase' => $details['price'],
                    'sub_total' => $subtotal,
                ]);
            }

            DB::commit(); // Simpan perubahan jika semua sukses

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
             return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }


        // Kosongkan keranjang
        $request->session()->forget('cart');

        // Arahkan ke halaman yang sesuai
        if ($order->payment_method == 'qris') {
            return redirect()->route('customer.order.payment', $order);
        } else {
            return redirect()->route('customer.order.success', $order);
        }
    }
    
    /**
     * Tampilkan halaman pembayaran (QRIS).
     */
    public function payment(Request $request, Order $order)
    {
        if ($order->status == 'paid' || $order->payment_method != 'qris') {
            return redirect()->route('customer.order.success', $order);
        }
        return view('customer.payment', compact('order'));
    }

    /**
     * Tampilkan halaman sukses.
     */
    public function success(Request $request, Order $order)
    {
        return view('customer.order_success', compact('order'));
    }

    /**
     * Cek status pembayaran (untuk timer QRIS).
     */
    public function checkPaymentStatus(Request $request, Order $order)
    {
        if ($order->status == 'paid') {
            return response()->json(['status' => 'paid']);
        }
        return response()->json(['status' => $order->status]);
    }

    /**
     * Simulasi Webhook (untuk timer QRIS).
     */
    public function webhook(Request $request)
    {
        $order = Order::where('payment_method', 'qris')->where('status', 'pending')->latest()->first();
        if ($order) {
            $order->update(['status' => 'paid', 'paid_at' => now()]);
            return response()->json(['status' => 'success', 'order_id' => $order->id]);
        }
        return response()->json(['status' => 'no_order_found']);
    }
}