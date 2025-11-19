@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">

            <h1 class="h3 fw-bold mb-4">
                <i class="bi bi-clipboard-check me-2"></i>Konfirmasi Pesanan
            </h1>

            <!-- Form Checkout -->
            <form action="{{ route('customer.order.store') }}" method="POST">
                @csrf

                <!-- Card: Ringkasan Pesanan -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-bag-check me-2 text-primary"></i>Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        
                        <!-- Info Meja -->
                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Memesan untuk Meja:</strong> {{ $tableNumber }}
                            </div>
                        </div>

                        <!-- List Items -->
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @forelse ($cart as $id => $details)
                                        @php $subtotal = $details['price'] * $details['quantity']; $total += $subtotal; @endphp
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $details['name'] }}</div>
                                                <small class="text-muted">Rp {{ number_format($details['price'], 0, ',', '.') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{ $details['quantity'] }}</span>
                                            </td>
                                            <td class="text-end">
                                                Rp {{ number_format($details['price'], 0, ',', '.') }}
                                            </td>
                                            <td class="text-end fw-bold text-primary">
                                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-5">
                                                <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                                                Keranjang Anda kosong
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if(count($cart) > 0)
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="3" class="text-end">Total Keseluruhan:</th>
                                        <th class="text-end text-primary fs-5">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>

                    </div>
                </div>

                <!-- Card: Pilihan Pembayaran -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-credit-card me-2 text-primary"></i>Metode Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        
                        <!-- Option: Tunai -->
                        <div class="form-check p-3 border rounded mb-3 payment-option">
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="payment_method" 
                                id="payment_cash" 
                                value="cash" 
                                checked>
                            <label class="form-check-label w-100" for="payment_cash">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-cash-coin fs-3 text-success me-3"></i>
                                    <div>
                                        <div class="fw-bold">Bayar Tunai di Kasir</div>
                                        <small class="text-muted">Pesanan akan diproses, silakan bayar di kasir setelah makan.</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Option: QRIS -->
                        <div class="form-check p-3 border rounded payment-option">
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="payment_method" 
                                id="payment_qris" 
                                value="qris">
                            <label class="form-check-label w-100" for="payment_qris">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-qr-code fs-3 text-primary me-3"></i>
                                    <div>
                                        <div class="fw-bold">QRIS (Pembayaran Non-Tunai)</div>
                                        <small class="text-muted">Bayar sekarang menggunakan QRIS (Simulasi).</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        @error('payment_method')
                            <div class="alert alert-danger mt-3 mb-0" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
                            </div>
                        @enderror

                    </div>
                </div>

                <!-- Tombol Submit -->
                <button 
                    type="submit" 
                    class="btn btn-primary btn-lg w-100 fw-bold"
                    @if(count($cart) == 0) disabled @endif>
                    <i class="bi bi-check-circle me-2"></i>Buat Pesanan
                </button>

            </form>

        </div>
    </div>
</div>

<style>
    .payment-option {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-option:hover {
        background-color: #f8f9fa;
        border-color: #667eea !important;
    }
    
    .payment-option:has(input:checked) {
        background-color: #e7f0ff;
        border-color: #667eea !important;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endsection