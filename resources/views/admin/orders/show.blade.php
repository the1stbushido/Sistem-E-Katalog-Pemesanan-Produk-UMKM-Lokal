<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-semibold text-xl leading-tight" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #667eea;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Detail Pesanan #{{ $order->id }}
            </h2>
            
            <div class="flex gap-2">
                <a href="{{ route('admin.orders.index') }}" 
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>

                <button onclick="window.print()" 
                        class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-white rounded-lg shadow-md transition duration-200 transform hover:-translate-y-0.5 hover:shadow-lg" 
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Struk
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Print Area -->
    <div class="py-12 print-area">
        
        <!-- Kop Struk (Hidden di layar, tampil saat print) -->
        <div class="hidden print:block mb-8 text-center">
            <h1 class="text-2xl font-bold text-black">E-KATALOG UMKM F&B</h1>
            <p class="text-sm text-black">Jl. Merdeka 123, Kota Pekanbaru, Riau</p>
            <p class="text-sm text-black">Telp: (0761) 123456</p>
            <hr class="mt-4 border-t-2 border-black">
            <h2 class="text-xl font-semibold text-black mt-2">STRUK PESANAN</h2>
            <p class="text-sm text-black mt-1">Order ID: #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Detail Items (2/3 width) -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                    
                    <!-- Card Header -->
                    <div class="px-6 py-4 border-b border-gray-200 no-print" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Item Pesanan
                        </h3>
                    </div>

                    <!-- Print Header (Hidden di layar) -->
                    <div class="hidden print:block px-6 py-3 bg-gray-100 border-b">
                        <h3 class="text-lg font-bold text-black">Item Pesanan</h3>
                    </div>

                    <!-- Table Items -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase print:text-black">
                                        Produk
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase print:text-black">
                                        Jumlah
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase print:text-black">
                                        Harga
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase print:text-black">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($order->items as $item)
                                    <tr class="print:text-black">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $item->product_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                                {{ $item->quantity }}x
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-600">
                                            Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                            Rp {{ number_format($item->sub_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                
                                <!-- Total Row -->
                                <tr class="bg-gray-50 print:bg-white">
                                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-900 print:text-black">
                                        TOTAL KESELURUHAN:
                                    </td>
                                    <td class="px-6 py-4 text-right text-xl font-bold text-purple-600 print:text-black">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan (1/3 width) -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                    
                    <!-- Card Header -->
                    <div class="px-6 py-4 border-b border-gray-200 no-print" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Ringkasan
                        </h3>
                    </div>

                    <!-- Print Header -->
                    <div class="hidden print:block px-6 py-3 bg-gray-100 border-b">
                        <h3 class="text-lg font-bold text-black">Ringkasan Pesanan</h3>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-4 print:text-black">
                        
                        <!-- Nomor Meja -->
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Nomor Meja
                            </dt>
                            <dd class="text-lg font-bold text-gray-900">{{ $order->table_number }}</dd>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Pembayaran
                            </dt>
                            <dd class="text-lg font-bold text-gray-900 uppercase">{{ $order->payment_method }}</dd>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status
                            </dt>
                            <dd>
                                @if ($order->status == 'paid')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <!-- Tanggal Pesan -->
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Pesan
                            </dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                        </div>

                        <!-- Tanggal Bayar (jika sudah paid) -->
                        @if($order->paid_at)
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Tanggal Bayar
                            </dt>
                            <dd class="text-sm font-semibold text-green-600">{{ $order->paid_at->format('d M Y, H:i') }}</dd>
                        </div>
                        @endif

                        <!-- Total (Highlighted) -->
                        <div class="mt-6 pt-4 border-t-2 border-gray-300">
                            <div class="flex items-center justify-between">
                                <dt class="text-base font-bold text-gray-700">Total Tagihan:</dt>
                                <dd class="text-2xl font-bold text-purple-600 print:text-black">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </dd>
                            </div>
                        </div>

                        <!-- Tombol Konfirmasi (hanya untuk cash pending) -->
                        @if ($order->payment_method == 'cash' && $order->status == 'pending')
                            <div class="mt-6 no-print">
                                <form action="{{ route('admin.orders.confirm_cash', $order) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran tunai untuk order ini?');">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-bold text-white bg-green-600 rounded-lg hover:bg-green-700 transition duration-200 shadow-md hover:shadow-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Konfirmasi Pembayaran Tunai
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>

                </div>

                <!-- Print Footer (Terima Kasih) -->
                <div class="hidden print:block mt-6 text-center">
                    <hr class="border-t-2 border-black mb-4">
                    <p class="text-sm font-semibold text-black">Terima kasih atas kunjungan Anda!</p>
                    <p class="text-xs text-black mt-1">Silakan datang kembali</p>
                    <p class="text-xs text-black mt-3">{{ now()->format('d M Y, H:i') }}</p>
                </div>

            </div>

        </div>
    </div>

    <!-- Auto Print Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const shouldPrint = urlParams.get('print');
            
            if (shouldPrint === 'true') {
                setTimeout(() => window.print(), 500);
            }
        });
    </script>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .print-area { padding: 20px; }
        }
    </style>
</x-app-layout>