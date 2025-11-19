@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            
            <!-- Container: Tampilan QRIS -->
            <div class="card shadow-lg border-0" id="payment-container">
                <div class="card-body p-5 text-center">
                    
                    <i class="bi bi-qr-code-scan fs-1 text-primary mb-3"></i>
                    
                    <h1 class="h4 fw-bold mb-2">Selesaikan Pembayaran</h1>
                    <p class="text-muted mb-4">
                        Scan QRIS di bawah ini untuk membayar<br>
                        <span class="badge bg-secondary">Order ID: #{{ $order->id }}</span>
                    </p>

                    <!-- QRIS Code (Dummy) -->
                    <div class="mb-4">
                        <img 
                            src="https://api.qrserver.com/v1/create-qr-code/?size=280x280&data={{ $order->payment_token ?? 'test-token' }}" 
                            alt="QRIS Code"
                            class="img-fluid rounded shadow-sm"
                            style="max-width: 280px;">
                    </div>

                    <!-- Total Amount -->
                    <div class="alert alert-primary mb-3" role="alert">
                        <div class="fw-bold">Total Pembayaran</div>
                        <h3 class="mb-0 text-primary">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </h3>
                    </div>

                    <p class="text-muted small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Ini adalah simulasi. Pembayaran akan terkonfirmasi otomatis dalam beberapa detik.
                    </p>

                </div>
            </div>

            <!-- Container: Loading (Muncul setelah delay) -->
            <div class="card shadow-lg border-0 d-none" id="checking-container">
                <div class="card-body p-5 text-center">
                    
                    <div class="spinner-border text-primary mb-4" style="width: 4rem; height: 4rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    
                    <h2 class="h5 fw-bold mb-2">Mengecek Status Pembayaran...</h2>
                    <p class="text-muted mb-0">Mohon tunggu sebentar, jangan tutup halaman ini.</p>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Variabel ---
        const orderId = {{ $order->id }};
        const successUrl = "{{ route('customer.order.success', $order) }}";
        const checkStatusUrl = "{{ route('customer.order.check_payment', $order) }}";
        const webhookUrl = "{{ route('customer.order.webhook') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const paymentContainer = document.getElementById('payment-container');
        const checkingContainer = document.getElementById('checking-container');
        
        let pollerInterval;
        const simulationDelay = 5000; // 5 detik simulasi

        // --- FUNGSI 1: Simulasi Webhook ---
        async function simulateWebhookPayment() {
            console.log('🔔 Simulasi Webhook: Mengubah status order ke PAID...');
            try {
                await fetch(webhookUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ dummy_order_id: orderId })
                });
                console.log('✅ Webhook berhasil dipanggil');
            } catch (error) {
                console.error('❌ Simulasi webhook gagal:', error);
            }
        }

        // --- FUNGSI 2: Cek Status ke Server ---
        async function checkPaymentStatus() {
            console.log('🔍 Mengecek status pembayaran...');
            try {
                const response = await fetch(checkStatusUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();

                if (data.status === 'paid') {
                    console.log('✅ Status PAID terdeteksi!');
                    clearInterval(pollerInterval);
                    
                    // Redirect ke halaman sukses
                    window.location.href = successUrl;
                }
            } catch (error) {
                console.error('❌ Error cek status:', error);
            }
        }

        // --- Timer Tersembunyi ---
        // Setelah 5 detik, sembunyikan QR dan panggil webhook
        setTimeout(() => {
            console.log('⏰ Timer simulasi habis. Proses pembayaran...');
            
            // Ganti UI: Tampilkan loading
            if (paymentContainer) {
                paymentContainer.classList.add('d-none');
            }
            if (checkingContainer) {
                checkingContainer.classList.remove('d-none');
            }
            
            // Panggil webhook (simulasi pembayaran sukses)
            simulateWebhookPayment();
            
        }, simulationDelay);

        // Mulai polling status setiap 3 detik
        pollerInterval = setInterval(checkPaymentStatus, 3000);

    });
</script>

<style>
    .card {
        border-radius: 16px;
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .spinner-border {
        border-width: 0.35rem;
    }
</style>
@endsection