<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="bi bi-speedometer2 text-2xl text-purple-600 mr-3"></i>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card dengan Gradient -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 overflow-hidden shadow-xl rounded-2xl mb-8 transform hover:scale-[1.02] transition-all duration-300">
                <div class="p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                            <p class="text-purple-100 text-lg">Anda login sebagai <span class="font-semibold">Admin</span></p>
                        </div>
                        <div class="hidden md:block">
                            <i class="bi bi-person-badge text-8xl text-white/20"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Penjualan Hari Ini -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-currency-dollar text-2xl text-white"></i>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">Hari Ini</span>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Penjualan Hari Ini</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-1">
                            Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 flex items-center mt-2">
                            <i class="bi bi-graph-up-arrow text-green-500 mr-1"></i>
                            Total transaksi hari ini
                        </p>
                    </div>
                </div>

                <!-- Total Pesanan -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-receipt text-2xl text-white"></i>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Aktif</span>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Pesanan</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-1">
                            {{ $totalOrders ?? 0 }}
                        </p>
                        <p class="text-xs text-gray-500 flex items-center mt-2">
                            <i class="bi bi-clock-history text-blue-500 mr-1"></i>
                            Pending & Paid
                        </p>
                    </div>
                </div>

                <!-- Total Produk -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-box-seam text-2xl text-white"></i>
                            </div>
                            <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">Total</span>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Jumlah Produk</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-1">
                            {{ $totalProducts ?? 0 }}
                        </p>
                        <p class="text-xs text-gray-500 flex items-center mt-2">
                            <i class="bi bi-tags text-purple-500 mr-1"></i>
                            Produk terdaftar
                        </p>
                    </div>
                </div>

            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bi bi-lightning-charge-fill text-yellow-500 mr-2"></i>
                    Aksi Cepat
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.products.create') }}" class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl hover:from-purple-100 hover:to-indigo-100 transition-all duration-300 border border-purple-200 hover:border-purple-300 group">
                        <i class="bi bi-plus-circle text-3xl text-purple-600 mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-semibold text-gray-700">Tambah Produk</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl hover:from-blue-100 hover:to-cyan-100 transition-all duration-300 border border-blue-200 hover:border-blue-300 group">
                        <i class="bi bi-list-check text-3xl text-blue-600 mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-semibold text-gray-700">Lihat Pesanan</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl hover:from-green-100 hover:to-emerald-100 transition-all duration-300 border border-green-200 hover:border-green-300 group">
                        <i class="bi bi-tags text-3xl text-green-600 mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-semibold text-gray-700">Kelola Kategori</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-orange-50 to-red-50 rounded-xl hover:from-orange-100 hover:to-red-100 transition-all duration-300 border border-orange-200 hover:border-orange-300 group">
                        <i class="bi bi-bar-chart-line text-3xl text-orange-600 mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-semibold text-gray-700">Lihat Laporan</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>