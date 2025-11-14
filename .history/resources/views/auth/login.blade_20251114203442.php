<x-guest-layout>
    
    <!-- Page Title -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali!</h2>
        <p class="text-sm text-gray-600 mt-1">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Session Status (Success Message) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Error Message (Custom) -->
    @if (session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
        </div>
    @endif
    
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email Address" class="font-semibold text-gray-700" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <x-text-input 
                    id="email" 
                    class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="your@email.com"
                    required 
                    autofocus 
                    autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" class="font-semibold text-gray-700" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <x-text-input 
                    id="password" 
                    class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required 
                    autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input 
                id="remember_me" 
                type="checkbox" 
                class="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500 transition duration-200" 
                name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-600 cursor-pointer">
                Ingat saya
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full flex justify-center items-center px-4 py-3 text-white font-semibold rounded-lg shadow-md transition duration-200 transform hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk
            </button>
        </div>

        <!-- Links -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <a class="text-sm text-purple-600 hover:text-purple-800 font-medium transition duration-200 flex items-center" href="{{ route('register') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Belum punya akun?
            </a>

            @if (Route::has('password.request'))
                <a class="text-sm text-purple-600 hover:text-purple-800 font-medium transition duration-200 flex items-center" href="{{ route('password.request') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Lupa password?
                </a>
            @endif
        </div>
    </form>

    <!-- Alternative Login (Optional) -->
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Atau kembali ke</span>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ url('/') }}" class="w-full flex justify-center items-center px-4 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Halaman Utama
            </a>
        </div>
    </div>

</x-guest-layout>