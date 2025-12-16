<x-guest-layout>
    <div class="mb-4 text-center">

        <!-- Logo -->
        <img src="{{ asset('images/2.jpg') }}" alt="Logo Aplikasi" class="mx-auto w-24 h-24 object-contain mb-4">

        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Selamat Datang Kembali</h2>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" class="font-semibold" />
                <x-text-input 
                    id="email" 
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <x-input-label for="password" :value="__('Password')" class="font-semibold" />
                    @if (Route::has('password.request'))
                        <a class="text-xs text-indigo-600 hover:text-indigo-800 transition duration-150" href="{{ route('password.request') }}">
                            Lupa sandi?
                        </a>
                    @endif
                </div>
                <x-text-input 
                    id="password" 
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                </label>
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition ease-in-out duration-150">
                    {{ __('Masuk Ke Akun') }}
                </x-primary-button>
            </div>

            @if (Route::has('register'))
                <p class="mt-4 text-center text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Daftar sekarang</a>
                </p>
            @endif
        </form>
    </div>
</x-guest-layout>
