@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            
            <div class="card shadow-lg border-0 success-card">
                <div class="card-body p-5 text-center">
                    
                    @if ($order->status == 'paid')
                        <!-- Status: LUNAS (QRIS) -->
                        <div class="success-icon-wrapper mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                        </div>
                        
                        <h1 class="h3 fw-bold mb-2">Pembayaran Berhasil!</h1>
                        <p class="text-muted mb-4">
                            Terima kasih! Pesanan Anda telah kami terima dan <strong>sudah dibayar</strong>. 
                            Makanan akan segera diproses.
                        </p>
                        
                        <div class="alert alert-success border-0 mb-4" role="alert">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-receipt fs-4 me-3"></i>
                                <div>
                                    <div class="small text-muted">Order ID</div>
                                    <div class="fw-bold fs-5">#{{ $order->id }}</div>
                                </div>
                            </div>
                        </div>
                    
                    @else
                        <!-- Status: PENDING (Tunai) -->
                        <div class="success-icon-wrapper mb-4">
                            <i class="bi bi-clock-history text-warning" style="font-size: 5rem;"></i>
                        </div>
                        
                        <h1 class="h3 fw-bold mb-2">Pesanan Diterima!</h1>
                        <p class="text-muted mb-4">
                            Pesanan Anda telah kami terima. Silakan lakukan pembayaran <strong>tunai di kasir</strong> 
                            setelah selesai makan.
                        </p>
                        
                        <div class="alert alert-warning border-0 mb-3" role="alert">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-receipt fs-4 me-3"></i>
                                <div>
                                    <div class="small">Order ID</div>
                                    <div class="fw-bold fs-5">#{{ $order->id }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-light border mb-4" role="alert">
                            <div class="fw-bold mb-1">Total Tagihan</div>
                            <h3 class="mb-0 text-primary">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </h3>
                        </div>
                    @endif

                    <!-- Tombol Pesan Lagi -->
                    <a href="{{ route('customer.menu') }}" class="btn btn-primary btn-lg w-100 fw-bold">
                        <i class="bi bi-arrow-left-circle me-2"></i>Pesan Lagi
                    </a>
                    
                    <p class="text-muted small mt-4 mb-0">
                        <i class="bi bi-heart-fill text-danger me-1"></i>
                        Terima kasih telah memesan di <strong>UMKM F&B</strong>
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .success-card {
        border-radius: 16px;
        animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .success-icon-wrapper {
        animation: bounceIn 0.8s ease;
    }
    
    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            opacity: 1;
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection