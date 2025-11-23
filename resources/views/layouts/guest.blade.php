<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- ONLY CSS, NO JS -->
        @vite(['resources/css/app.css'])

        <style>
            .auth-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .auth-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-10px);
                }
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.6s ease-out;
            }

            .animate-float {
                animation: float 3s ease-in-out infinite;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .brand-icon {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 auth-gradient auth-pattern">
            
            <!-- Auth Card dengan Logo di Dalam -->
            <div class="w-full sm:max-w-md mt-6 glass-card shadow-2xl overflow-hidden sm:rounded-2xl animate-fade-in-up">
                
                <!-- Logo Header Inside Card -->
                <div class="flex flex-col items-center pt-8 pb-6 px-8 border-b border-gray-100">
                    <!-- Icon dengan Floating Animation -->
                    <div class="mb-4 animate-float">
                        <div class="w-20 h-20 brand-icon rounded-2xl shadow-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Brand Text -->
                    <div class="text-center">
                        <h1 class="text-2xl font-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            UMKM F&B
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">E-Katalog Platform</p>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="px-8 py-6">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-white text-sm opacity-75 animate-fade-in-up" style="animation-delay: 0.3s;">
                <p>&copy; {{ date('Y') }} E-Katalog UMKM F&B. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>