@extends('layouts.customer')

@section('content')
<div class="container py-4">

    <!-- Info Meja & Link Ganti -->
    <div class="alert alert-primary d-flex justify-content-between align-items-center shadow-sm mb-4" role="alert">
        <div>
            <h5 class="alert-heading mb-1">
                <i class="bi bi-table me-2"></i>Meja: {{ $tableNumber }}
            </h5>
            <p class="mb-0 small">Silakan pilih menu di bawah ini untuk memulai pemesanan.</p>
        </div>
        <a href="{{ route('customer.select.table.clear') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-arrow-repeat me-1"></i>Ganti Meja
        </a>
    </div>

    <!-- Navigasi Kategori (Pills) -->
    <div class="mb-4">
        <h5 class="fw-bold mb-3">
            <i class="bi bi-grid-3x3-gap me-2"></i>Kategori
        </h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="#semua" class="btn btn-outline-secondary btn-sm active">
                <i class="bi bi-list-ul me-1"></i>Semua Produk
            </a>
            @foreach ($categories as $category)
                <a href="#kategori-{{ $category->id }}" class="btn btn-outline-secondary btn-sm">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Daftar Produk (Cards Grid) -->
    <div id="semua">
        <h4 class="fw-bold mb-4">Menu Kami</h4>
        
        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        
                        <!-- Gambar Produk -->
                        <div class="position-relative">
                            <img 
                                src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/400x400/e2e8f0/cbd5e0?text=Menu' }}" 
                                class="card-img-top product-image" 
                                alt="{{ $product->name }}"
                                style="height: 180px; object-fit: cover;">
                            
                            <!-- Badge Kategori -->
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold mb-2">{{ $product->name }}</h6>
                            
                            <div class="mt-auto">
                                <p class="text-primary fw-bold fs-5 mb-3">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                
                                <button 
                                    class="btn btn-primary w-100 btn-sm fw-semibold"
                                    onclick="addToCart('{{ $product->id }}', '{{ $product->name }}', {{ $product->price }})">
                                    <i class="bi bi-cart-plus me-1"></i>Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center" role="alert">
                        <i class="bi bi-exclamation-triangle fs-1 d-block mb-3"></i>
                        <p class="mb-0">Belum ada produk yang tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

</div>

<style>
    .product-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
    }
    
    .product-image {
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .btn-outline-secondary.active {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
    }
    
    .btn-outline-secondary:hover {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection