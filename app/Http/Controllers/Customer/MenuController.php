<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Table; 

class MenuController extends Controller
{
    /**
     * Menampilkan halaman menu utama (katalog) ATAU halaman pilih meja.
     */
    public function index(Request $request)
    {
        // Cek apakah nomor meja sudah ada di session
        if (!$request->session()->has('table_number')) {
            // JIKA BELUM:
            $tables = Table::where('status', 'available')->get();
            
            // Tampilkan halaman pilih meja (dengan dropdown)
            return view('customer.select_table', compact('tables'));
        }

        // JIKA SUDAH ADA MEJA:
        $tableNumber = $request->session()->get('table_number');

        // Ambil data kategori
        $categories = Category::get();
        
        // REVISI: Ambil produk yang tersedia dan kelompokkan berdasarkan category_id
        $products = Product::where('is_available', true)
                           ->with('category')
                           ->get()
                           ->groupBy('category_id'); // <-- PENTING: Pengelompokan data

        // Tampilkan katalog menu
        return view('customer.menu', compact('categories', 'products', 'tableNumber'));
    }

    /**
     * Menyimpan nomor meja ke session setelah customer input.
     */
    public function storeTable(Request $request)
    {
        // Validasi input (pastikan meja yang dipilih ada di database)
        $request->validate([
            'table_number' => 'required|string|exists:tables,table_number',
        ]);

        // Simpan ke session
        $request->session()->put('table_number', $request->table_number);

        // Arahkan ke halaman menu (katalog)
        return redirect()->route('customer.menu');
    }

    /**
     * FUNGSI Untuk "Ganti Meja"
     * Menghapus session meja dan mengarahkan kembali ke halaman pilih meja.
     */
    public function clearTable(Request $request)
    {
        $request->session()->forget('table_number');
        $request->session()->forget('cart'); // Hapus keranjang juga saat ganti meja
        
        // Setelah clear, diarahkan kembali ke halaman pilih meja (karena session kosong)
        return redirect()->route('customer.menu'); 
    }
}