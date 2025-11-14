<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token untuk fetch API -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Katalog UMKM F&B</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ff4757;
            color: white;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .cart-button {
            position: relative;
            background-color: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .cart-button:hover {
            background-color: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        /* Off-Canvas Cart Styling */
        .offcanvas-cart {
            width: 400px !important;
        }

        @media (max-width: 576px) {
            .offcanvas-cart {
                width: 90% !important;
            }
        }

        .cart-item {
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-empty {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        /* Toast Container */
        .toast-container {
            z-index: 9999;
        }

        .toast-success {
            background-color: #10b981;
            color: white;
        }

        .toast-success .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>

</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('customer.menu') }}">
                <i class="bi bi-shop me-2"></i>UMKM F&B
            </a>
            
            <button class="cart-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
                <i class="bi bi-cart3 fs-5"></i>
                <span class="cart-badge" id="cart-count">0</span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Off-Canvas Cart (Keranjang Geser) -->
    <div class="offcanvas offcanvas-end offcanvas-cart" tabindex="-1" id="cartOffcanvas">
        <div class="offcanvas-header bg-light">
            <h5 class="offcanvas-title fw-bold">
                <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <!-- Cart Items Container -->
            <div id="cart-items-container" class="p-3">
                <!-- Items akan diisi oleh JavaScript -->
                <div class="cart-empty">
                    <i class="bi bi-cart-x fs-1 text-muted"></i>
                    <p class="mt-3">Keranjang Anda masih kosong</p>
                    <small class="text-muted">Mulai tambahkan produk favorit Anda!</small>
                </div>
            </div>
        </div>
        <!-- Cart Footer (Total & Checkout Button) -->
        <div class="offcanvas-footer border-top p-3 bg-light" id="cart-footer" style="display: none;">
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Total:</span>
                <span class="fw-bold text-primary fs-5" id="cart-total">Rp 0</span>
            </div>
            <a href="{{ route('customer.checkout') }}" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout
            </a>
        </div>
    </div>

    <!-- Toast Container (untuk notifikasi) -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="addToCartToast" class="toast toast-success" role="alert">
            <div class="d-flex align-items-center p-3">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div class="toast-body flex-grow-1" id="toast-message">
                    Produk ditambahkan ke keranjang!
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Cart JavaScript -->
    <script src="{{ asset('js/cart.js') }}" defer></script>

    <!-- Semua logic cart sudah dipindah ke cart.js -->

</body>
</html>