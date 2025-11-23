{{-- 
    Product Card Component
    Required: $product object with properties: id, name, price, image_url, category
--}}

<div class="card h-100 product-card">
    {{-- Product Image --}}
    <div class="product-image-wrapper">
        <img 
            src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/400x400/e2e8f0/667eea?text=' . urlencode($product->name) }}" 
            class="product-image" 
            alt="{{ $product->name }}"
            loading="lazy">
        
        {{-- Category Badge --}}
        <span class="category-badge">
            <i class="bi bi-tag-fill me-1"></i>
            {{ $product->category->name ?? 'Menu' }}
        </span>

        {{-- Stock Badge (if needed) --}}
        @if(isset($product->stock) && $product->stock <= 5 && $product->stock > 0)
            <span class="stock-badge stock-low">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Sisa {{ $product->stock }}
            </span>
        @elseif(isset($product->stock) && $product->stock <= 0)
            <span class="stock-badge stock-empty">
                <i class="bi bi-x-circle me-1"></i>
                Habis
            </span>
        @endif
    </div>
    
    {{-- Product Body --}}
    <div class="card-body d-flex flex-column">
        {{-- Product Name --}}
        <h6 class="product-name">{{ $product->name }}</h6>
        
        {{-- Product Description (Optional) --}}
        @if(isset($product->description) && $product->description)
            <p class="product-description">
                {{ Str::limit($product->description, 60) }}
            </p>
        @endif

        {{-- Price & Action --}}
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="product-price">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                
                @if(isset($product->discount) && $product->discount > 0)
                    <span class="badge bg-danger">
                        -{{ $product->discount }}%
                    </span>
                @endif
            </div>
            
            {{-- Add to Cart Button --}}
            @if(!isset($product->stock) || $product->stock > 0)
                <button 
                    class="btn btn-add-cart"
                    onclick="addToCart('{{ $product->id }}', '{{ addslashes($product->name) }}', {{ $product->price }})"
                    aria-label="Tambah {{ $product->name }} ke pesanan">
                    <i class="bi bi-cart-plus me-2"></i>
                    <span>Tambah ke Pesanan</span>
                </button>
            @else
                <button class="btn btn-add-cart" disabled>
                    <i class="bi bi-x-circle me-2"></i>
                    <span>Stok Habis</span>
                </button>
            @endif
        </div>
    </div>
</div>

<style>
    /* Product Card Styling */
    .product-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.2);
    }

    /* Image Wrapper */
    .product-image-wrapper {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    /* Category Badge */
    .category-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Stock Badge */
    .stock-badge {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stock-badge.stock-low {
        background: #ffc107;
        color: #000;
    }

    .stock-badge.stock-empty {
        background: #dc3545;
        color: white;
    }

    /* Card Body */
    .product-card .card-body {
        padding: 1.25rem;
    }

    /* Product Name */
    .product-name {
        font-size: 1rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        min-height: 2.8rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Product Description */
    .product-description {
        font-size: 0.85rem;
        color: #718096;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Product Price */
    .product-price {
        color: #667eea;
        font-size: 1.25rem;
        font-weight: 700;
    }

    /* Add to Cart Button */
    .btn-add-cart {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-add-cart:hover:not(:disabled) {
        background: linear-gradient(135deg, #5568d3 0%, #653a8b 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-add-cart:disabled {
        background: #cbd5e0;
        cursor: not-allowed;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 576px) {
        .product-image-wrapper {
            height: 150px;
        }

        .product-name {
            font-size: 0.9rem;
            min-height: 2.4rem;
        }

        .product-price {
            font-size: 1.1rem;
        }

        .btn-add-cart {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .category-badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.75rem;
        }
    }
</style>