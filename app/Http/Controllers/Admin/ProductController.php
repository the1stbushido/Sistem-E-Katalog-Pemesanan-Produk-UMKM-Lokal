<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $products = Product::with('category')
        ->when($request->search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    
    if ($request->ajax()) {
        return view('admin.products.index', compact('products'))->render();
    }

    return view('admin.products.index', compact('products'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown di form
        $categories = Category::all();
       
        return view('admin.products.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'boolean'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan gambar di 'storage/app/public/products'
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image_url' => $imagePath,
            'is_available' => $request->boolean('is_available'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dibuat.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Ambil kategori untuk form
        $categories = Category::all();
        
        // KIRIM 'product' DAN 'categories' ke view
        return view('admin.products.form', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'boolean'
        ]);

        $imagePath = $product->image_url; // Gunakan gambar lama sebagai default
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            // Upload gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image_url' => $imagePath,
            'is_available' => $request->boolean('is_available'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 1. Hapus data anak 

        $product->orderItems()->delete(); 

        // 2. hapus produk induk
        $product->delete(); 

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}