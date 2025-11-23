<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.tables.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl leading-tight" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                {{ isset($table) ? 'Edit Meja' : 'Tambah Meja Baru' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Main Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-200" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="flex items-center text-white">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <h3 class="text-xl font-bold">{{ isset($table) ? 'Edit Data Meja' : 'Form Meja Baru' }}</h3>
                            <p class="text-sm opacity-90 mt-0.5">{{ isset($table) ? 'Perbarui informasi meja' : 'Tambahkan meja baru ke sistem' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-8">
                    <form action="{{ isset($table) ? route('admin.tables.update', $table) : route('admin.tables.store') }}" method="POST">
                        @csrf
                        @if (isset($table))
                            @method('PUT')
                        @endif

                        <!-- Nomor Meja -->
                        <div class="mb-6">
                            <label for="table_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                Nomor Meja
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="table_number" 
                                id="table_number" 
                                value="{{ old('table_number', $table->table_number ?? '') }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 @error('table_number') border-red-500 @enderror" 
                                placeholder="Contoh: 01, 02, Teras A, VIP 1"
                                required>
                            @error('table_number')
                                <div class="flex items-center mt-2 text-red-600 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Gunakan format yang jelas seperti angka atau kode area (01, A1, Teras, dll)
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status Meja
                                <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="status" 
                                id="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 @error('status') border-red-500 @enderror" 
                                required>
                                <option value="available" {{ (old('status', $table->status ?? 'available') == 'available') ? 'selected' : '' }}>
                                    ✅ Available (Tersedia)
                                </option>
                                <option value="occupied" {{ (old('status', $table->status ?? '') == 'occupied') ? 'selected' : '' }}>
                                    🔴 Occupied (Sedang Digunakan)
                                </option>
                            </select>
                            @error('status')
                                <div class="flex items-center mt-2 text-red-600 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="mb-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-blue-800">Informasi:</p>
                                    <ul class="text-sm text-blue-700 mt-1 space-y-1">
                                        <li>• <strong>Available:</strong> Meja kosong dan siap digunakan customer</li>
                                        <li>• <strong>Occupied:</strong> Meja sedang digunakan atau tidak tersedia</li>
                                        <li>• Status akan otomatis berubah saat ada pemesanan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.tables.index') }}" 
                               class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2.5 text-sm font-semibold text-white rounded-lg shadow-md transition duration-200 transform hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ isset($table) ? 'Update Meja' : 'Simpan Meja' }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Quick Tips Card -->
            <div class="mt-6 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-6 shadow-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-gray-900">Contoh Penomoran Meja</h4>
                        <div class="mt-2 text-sm text-gray-600 space-y-1">
                            <p>• <strong>Angka Sederhana:</strong> 01, 02, 03, 04, 05...</p>
                            <p>• <strong>Kode Area:</strong> A1, A2, B1, B2 (berdasarkan zona)</p>
                            <p>• <strong>Nama Area:</strong> Teras A, VIP 1, Indoor 1, Outdoor 1</p>
                            <p class="text-xs text-gray-500 mt-2">💡 Gunakan format yang konsisten untuk memudahkan customer & staff</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>