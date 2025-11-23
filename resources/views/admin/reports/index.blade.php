<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-semibold text-xl leading-tight" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #667eea;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ __('Laporan Penjualan') }}
            </h2>
            
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-white rounded-lg shadow-md transition duration-200 transform hover:-translate-y-0.5 hover:shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <!-- Print Area -->
    <div class="py-12 print-area">
        
        <!-- Kop Laporan (Hidden di layar, tampil saat print) -->
        <div class="hidden print:block mb-8 text-center max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-black">E-KATALOG UMKM F&B</h1>
            <p class="text-sm text-black">Jl. Merdeka 123, Kota Pekanbaru, Riau</p>
            <p class="text-sm text-black">Telp: (0761) 123456</p>
            <hr class="mt-4 border-t-2 border-black">
            <h2 class="text-xl font-semibold text-black mt-2">LAPORAN PENJUALAN</h2>
            <p class="text-sm text-black mt-1">Tanggal Cetak: {{ now()->format('d M Y, H:i') }}</p>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Form Filter (Hidden saat print) -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl mb-6 no-print">
                
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter Laporan
                    </h3>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    <form action="{{ route('admin.reports.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            
                            <!-- Jenis Filter -->
                            <div>
                                <label for="filter_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Jenis Filter
                                </label>
                                <select name="filter_type" id="filter_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                                    <option value="daily" {{ request('filter_type') == 'daily' ? 'selected' : '' }}>📅 Harian</option>
                                    <option value="weekly" {{ request('filter_type') == 'weekly' ? 'selected' : '' }}>📆 Mingguan</option>
                                    <option value="monthly" {{ request('filter_type') == 'monthly' ? 'selected' : '' }}>📊 Bulanan</option>
                                    <option value="custom" {{ request('filter_type') == 'custom' ? 'selected' : '' }}>🔧 Custom Tanggal</option>
                                </select>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Tanggal Mulai
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date', date('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                            </div>

                            <!-- Tanggal Akhir -->
                            <div>
                                <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Tanggal Akhir
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date', date('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                            </div>

                            <!-- Tombol Submit -->
                            <div class="flex items-end">
                                <button type="submit" class="w-full px-4 py-3 text-sm font-semibold text-white rounded-lg shadow-md transition duration-200 transform hover:-translate-y-0.5 hover:shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Hasil Laporan -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                
                <!-- Title -->
                <div class="px-6 py-4 border-b border-gray-200 no-print" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 class="text-xl font-bold text-white text-center">{{ $reportTitle }}</h3>
                </div>

                <!-- Print Title (Hidden di layar) -->
                <div class="hidden print:block px-6 py-3 bg-gray-100 border-b">
                    <h3 class="text-xl font-bold text-black text-center">{{ $reportTitle }}</h3>
                </div>

                <div class="p-6">
                    
                    <!-- Ringkasan Statistik (Cards) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        
                        <!-- Total Penjualan -->
                        <div class="rounded-xl p-6 shadow-md" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-semibold text-gray-600 print:text-black">Total Penjualan</h4>
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 print:text-black">
                                Rp {{ number_format($totalSales, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Tunai -->
                        <div class="rounded-xl p-6 shadow-md" style="background: linear-gradient(135deg, #10b98115 0%, #059669 15 100%);">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-semibold text-gray-600 print:text-black">Pembayaran Tunai</h4>
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 print:text-black">
                                Rp {{ number_format($totalCash, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- QRIS -->
                        <div class="rounded-xl p-6 shadow-md" style="background: linear-gradient(135deg, #3b82f615 0%, #2563eb15 100%);">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-semibold text-gray-600 print:text-black">Pembayaran QRIS</h4>
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 print:text-black">
                                Rp {{ number_format($totalQris, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>

                    <!-- Tabel Detail Transaksi -->
                    <div class="mt-8">
                        <h4 class="text-lg font-bold mb-4 text-gray-900 print:text-black flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Detail Transaksi
                        </h4>

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider print:text-black">
                                            Order ID
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider print:text-black">
                                            Tanggal
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider print:text-black">
                                            Meja
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider print:text-black">
                                            Total
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider print:text-black">
                                            Pembayaran
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($orders as $order)
                                        <tr class="hover:bg-gray-50 transition duration-200 no-print-hover">
                                            <!-- Order ID -->
                                            <td class="px-6 py-4 whitespace-nowrap print:text-black">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                        {{ $order->id }}
                                                    </div>
                                                    <span class="ml-3 text-sm font-semibold text-gray-900">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </div>
                                            </td>

                                            <!-- Tanggal -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 print:text-black">
                                                {{ $order->paid_at ? $order->paid_at->format('d M Y, H:i') : $order->created_at->format('d M Y, H:i') }}
                                            </td>

                                            <!-- Meja -->
                                            <td class="px-6 py-4 whitespace-nowrap print:text-black">
                                                <div class="flex items-center text-sm font-semibold text-gray-900">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $order->table_number }}
                                                </div>
                                            </td>

                                            <!-- Total -->
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900 print:text-black">
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </td>

                                            <!-- Pembayaran -->
                                            <td class="px-6 py-4 whitespace-nowrap text-center print:text-black">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold {{ $order->payment_method == 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                    @if($order->payment_method == 'cash')
                                                        💵 Cash
                                                    @else
                                                        💳 QRIS
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center print:text-black">
                                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <p class="text-gray-500 font-medium">Tidak ada data penjualan pada periode ini.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <!-- Footer Total (jika ada data) -->
                                @if($orders->count() > 0)
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-900 print:text-black">
                                            TOTAL KESELURUHAN:
                                        </td>
                                        <td class="px-6 py-4 text-right text-xl font-bold text-purple-600 print:text-black">
                                            Rp {{ number_format($totalSales, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4"></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>

                    </div>

                    <!-- Print Footer -->
                    <div class="hidden print:block mt-8 text-center border-t-2 border-black pt-4">
                        <p class="text-sm font-semibold text-black">Dicetak oleh: {{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-black mt-1">Waktu Cetak: {{ now()->format('d M Y, H:i:s') }}</p>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print { display: none !important; }
            .no-print-hover:hover { background-color: white !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .print-area { padding: 20px; }
        }
    </style>
</x-app-layout>