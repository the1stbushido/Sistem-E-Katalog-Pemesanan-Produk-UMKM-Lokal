<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #667eea;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Update Profile Information Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl animate-fade-in-up">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Informasi Profil
                    </h3>
                    <p class="text-sm text-white opacity-90 mt-1">Update informasi profil dan alamat email Anda.</p>
                </div>
                
                <!-- Card Body -->
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl animate-fade-in-up" style="animation-delay: 0.1s;">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Ganti Password
                    </h3>
                    <p class="text-sm text-white opacity-90 mt-1">Pastikan akun Anda menggunakan password yang kuat dan aman.</p>
                </div>
                
                <!-- Card Body -->
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete Account Card (Optional - karena Wak sudah hapus button) -->
            <!-- Jika mau tampilkan, uncomment bagian ini -->
            <!--
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
                    <h3 class="text-lg font-bold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Hapus Akun
                    </h3>
                    <p class="text-sm text-red-700 mt-1">Hapus akun Anda secara permanen.</p>
                </div>
                
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
            -->

        </div>
    </div>

    <!-- Animation Styles -->
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out;
            animation-fill-mode: both;
        }
    </style>
</x-app-layout>