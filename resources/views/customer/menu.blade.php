@extends('layouts.customer')

@section('content')
<style>
    /* Header Section dengan Gradient */
    .table-info-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        margin-bottom: 2rem;
        animation: fadeInDown 0.5s ease;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-change-table {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-change-table:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.6);
        color: white;
        transform: translateY(-2px);
    }

    /* Category Pills Section */
    .category-section {
        background: white;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        position: sticky;
        top: 70px;
        z-index: 100;
    }

    .category-pills-wrapper {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding: 0.5rem 0;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }

    .category-pills-wrapper::-webkit-scrollbar {
        display: none;
    }

    .category-pill {
        background: white;
        border: 2px solid #e2e8f0;
        color: #4a5568;
        padding: 0.6rem 1.5rem;
        border-radius: 25px;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-pill:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .category-pill.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* Section Headers */
    .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #667eea;
        animation: fadeIn 0.5s ease;
    }

    .section-header h4 {
        color: #2d3748;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-header h4 i {
        color: #667eea;
        font-size: 1.5rem;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Product Card Improvements */
    .product-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.2);
    }

    .product-image-wrapper {
        position: relative;
        height: 180px;
        overflow: hidden;
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
    }

    .product-card .card-body {
        padding: 1.25rem;
    }

    .product-name {
        font-size: 1rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        min-height: 2.8rem;
    }

    .product-price {
        color: #667eea;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .btn-add-cart {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-add-cart:hover {
        background: linear-gradient(135deg, #5568d3 0%, #653a8b 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .empty-state i {
        font-size: 5rem;
        color: #cbd5e0;
        margin-bottom: 1.5rem;
    }

    .empty-state h5 {
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #718096;
        margin: 0;
    }

    /* Scroll Offset untuk Section */
    [id^="semua"],
    [id^="kategori-"] {
        scroll-margin-top: 150px;
    }

    /* Animation untuk Cards */
    .product-card {
        animation: fadeInUp 0.5s ease;
    }

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
    @media (max-width: 768px) {
        .table-info-banner {
            padding: 1rem;
        }

        .category-section {
            top: 60px;
        }

        .product-image-wrapper {
            height: 150px;
        }

        .section-header h4 {
            font-size: 1.25rem;
        }
    }
</style>

<div class="container py-4">

    {{-- Table Info Banner --}}
    <div class="table-info-banner">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-bold">
                    <i class="bi bi-bookmark-fill me-2"></i>Meja #{{ $tableNumber }}
                </h5>
                <p class="mb-0 small opacity-90">
                    <i class="bi bi-info-circle me-1"></i>
                    Silakan pilih menu favorit Anda untuk memulai pemesanan
                </p>
            </div>
            <a href="{{ route('customer.select.table.clear') }}" class="btn btn-change-table">
                <i class="bi bi-arrow-repeat me-2"></i>Ganti Meja
            </a>
        </div>
    </div>

    {{-- Category Pills (Sticky) --}}
    <div class="category-section">
        <h6 class="fw-bold mb-3 text-muted small">
            <i class="bi bi-funnel me-2"></i>FILTER KATEGORI
        </h6>
        
        <div class="category-pills-wrapper">
            {{-- Semua Produk --}}
            <a href="#semua" class="category-pill active">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Semua Menu</span>
            </a>
            
            {{-- Per Kategori --}}
            @foreach ($categories as $category)
                <a href="#kategori-{{ $category->id }}" class="category-pill">
                    <i class="bi bi-{{ $category->icon ?? 'tag' }}"></i>
                    <span>{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Section: Semua Produk --}}
    <div id="semua">
        <div class="section-header">
            <h4>
                <i class="bi bi-stars"></i>
                <span>Semua Menu Kami</span>
            </h4>
        </div>
        
        <div class="row g-4 mb-5">
            @php
                $allProducts = $products->flatten(); 
            @endphp
            
            @forelse ($allProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    {{-- Product Card --}}
                    <div class="card product-card">
                        <div class="product-image-wrapper">
                            <img 
                                src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/400x400/e2e8f0/667eea?text=' . urlencode($product->name) }}" 
                                class="product-image" 
                                alt="{{ $product->name }}">
                            
                            <span class="category-badge">
                                {{ $product->category->name ?? 'Menu' }}
                            </span>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h6 class="product-name">{{ $product->name }}</h6>
                            
                            <div class="mt-auto">
                                <p class="product-price mb-3">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                
                                <button 
                                    class="btn btn-add-cart"
                                    onclick="addToCart('{{ $product->id }}', '{{ addslashes($product->name) }}', {{ $product->price }})">
                                    <i class="bi bi-cart-plus me-2"></i>Tambah ke Pesanan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h5>Belum Ada Menu</h5>
                        <p>Menu akan segera tersedia</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    
    {{-- Section: Per Kategori --}}
    @foreach ($categories as $category)
        <div id="kategori-{{ $category->id }}">
            <div class="section-header">
                <h4>
                    <i class="bi bi-{{ $category->icon ?? 'tag' }}"></i>
                    <span>{{ $category->name }}</span>
                </h4>
            </div>
            
            <div class="row g-4 mb-5">
                @php
                    $categoryProducts = $products->get($category->id, collect());
                @endphp
                
                @forelse ($categoryProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        {{-- Product Card --}}
                        <div class="card product-card">
                            <div class="product-image-wrapper">
                                <img 
                                    src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/400x400/e2e8f0/667eea?text=' . urlencode($product->name) }}" 
                                    class="product-image" 
                                    alt="{{ $product->name }}">
                                
                                <span class="category-badge">
                                    {{ $product->category->name ?? 'Menu' }}
                                </span>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="product-name">{{ $product->name }}</h6>
                                
                                <div class="mt-auto">
                                    <p class="product-price mb-3">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    
                                    <button 
                                        class="btn btn-add-cart"
                                        onclick="addToCart('{{ $product->id }}', '{{ addslashes($product->name) }}', {{ $product->price }})">
                                        <i class="bi bi-cart-plus me-2"></i>Tambah ke Pesanan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-info-circle"></i>
                            <h5>Tidak Ada Menu</h5>
                            <p>Belum ada produk untuk kategori <strong>{{ $category->name }}</strong> saat ini</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endforeach

</div>

{{-- JavaScript untuk Category Pills Active State & Smooth Scroll --}}
<script>
  // Ganti JavaScript di bagian bawah menu.blade.php dengan kode ini:

document.addEventListener('DOMContentLoaded', function() {
    const categoryPills = document.querySelectorAll('.category-pill');
    const sections = document.querySelectorAll('[id^="semua"], [id^="kategori-"]');
    
    let lastActiveId = null;
    let isUserScrolling = false;
    let scrollTimeout;
    
    // Function untuk update active pill
    function updateActivePill(targetId) {
        // Cegah update jika sudah active (menghindari kedip-kedip)
        if (lastActiveId === targetId) return;
        
        lastActiveId = targetId;
        const activeLink = document.querySelector(`a[href="#${targetId}"]`);
        
        if (activeLink) {
            // Hapus semua active
            categoryPills.forEach(pill => pill.classList.remove('active'));
            
            // Tambah active ke yang sesuai
            activeLink.classList.add('active');
            
            // Auto scroll kategori pill ke view (tanpa smooth agar tidak bentrok)
            activeLink.scrollIntoView({
                behavior: 'auto',
                block: 'nearest',
                inline: 'center'
            });
        }
    }
    
    // Intersection Observer untuk Auto-Update Active State
    const observer = new IntersectionObserver(entries => {
        // Skip jika user sedang scroll manual dari klik
        if (isUserScrolling) return;
        
        let mostVisibleSection = null;
        let maxRatio = 0;
        
        // Cari section yang paling terlihat
        entries.forEach(entry => {
            if (entry.isIntersecting && entry.intersectionRatio > maxRatio) {
                maxRatio = entry.intersectionRatio;
                mostVisibleSection = entry.target;
            }
        });
        
        // Update active state berdasarkan section yang paling terlihat
        if (mostVisibleSection && maxRatio > 0.3) { // Minimum 30% visible
            updateActivePill(mostVisibleSection.id);
        }
        
        // Fallback: Aktifkan 'Semua Menu' jika di paling top
        if (window.scrollY < 100) {
            updateActivePill('semua');
        }
    }, {
        rootMargin: '-30% 0px -30% 0px',
        threshold: [0, 0.3, 0.5, 0.7, 1]
    });

    // Observe semua sections
    sections.forEach(section => observer.observe(section));

    // Smooth Scroll saat klik kategori
    categoryPills.forEach(pill => {
        pill.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Set flag bahwa user sedang klik
            isUserScrolling = true;
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offset = 150;
                const targetPosition = targetElement.offsetTop - offset;
                
                // Update active langsung
                updateActivePill(targetId);
                
                // Scroll ke target
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Reset flag setelah scroll selesai
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    isUserScrolling = false;
                }, 1500);
            }
        });
    });
});

// Function untuk add to cart (placeholder - sesuaikan dengan implementasi Anda)
function addToCart(productId, productName, price) {
    // Implementasi add to cart
    console.log('Add to cart:', productId, productName, price);
    
    // Show toast notification
    showToast(`${productName} ditambahkan ke pesanan`);
}

// Toast Notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>
        <span>${message}</span>
    `;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideInRight 0.3s ease;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add CSS animations for toast
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection