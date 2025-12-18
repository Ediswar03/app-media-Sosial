<x-app-layout>
    {{-- Header Section --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 max-w-lg mx-auto">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Profile') }}
            </h2>
            
            <a href="{{ route('profile.index', Auth::user()->username ?? Auth::user()->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                {{ __('Lihat Profil') }} &rarr;
            </a>
        </div>
    </x-slot>

    {{-- Main Background: Terang (Gray-100) --}}
    <div class="py-12 bg-gray-100 min-h-screen text-gray-900">
        
        {{-- Container: Tetap max-w-lg (Ramping) --}}
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- BAGIAN 2: Edit Informasi Pribadi --}}
            {{-- Card Background: Putih --}}
            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-xl border border-gray-200">
                <div class="w-full">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Informasi Pribadi') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Perbarui data diri Anda.") }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
                        @csrf
                        @method('patch')

                        {{-- 1. Nama --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700" />
                            <x-text-input id="name" name="name" type="text" 
                                class="mt-1 block w-full bg-white border-gray-300 text-gray-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- 2. Alamat --}}
                        <div>
                            <x-input-label for="address" :value="__('Alamat')" class="text-gray-700" />
                            <textarea id="address" name="address" rows="2" 
                                class="mt-1 block w-full bg-white border-gray-300 text-gray-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400 sm:text-sm" 
                                placeholder="Alamat lengkap...">{{ old('address', $user->address) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        {{-- 3. No HP --}}
                        <div>
                            <x-input-label for="phone" :value="__('No Handphone')" class="text-gray-700" />
                            <x-text-input id="phone" name="phone" type="text" 
                                class="mt-1 block w-full bg-white border-gray-300 text-gray-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400 sm:text-sm" 
                                :value="old('phone', $user->phone)" placeholder="08xxxxxxxxxx" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        {{-- 4. Pekerjaan --}}
                        <div>
                            <x-input-label for="pekerjaan" :value="__('Pekerjaan')" class="text-gray-700" />
                            <x-text-input id="pekerjaan" name="pekerjaan" type="text" 
                                class="mt-1 block w-full bg-white border-gray-300 text-gray-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400 sm:text-sm" 
                                :value="old('pekerjaan', $user->pekerjaan)" placeholder="Pekerjaan saat ini" />
                            <x-input-error class="mt-2" :messages="$errors->get('pekerjaan')" />
                        </div>

                        {{-- 5. Pendidikan --}}
                        <div>
                            <x-input-label for="education" :value="__('Pendidikan')" class="text-gray-700" />
                            <x-text-input id="education" name="education" type="text" 
                                class="mt-1 block w-full bg-white border-gray-300 text-gray-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400 sm:text-sm" 
                                :value="old('education', $user->education)" placeholder="Pendidikan terakhir" />
                            <x-input-error class="mt-2" :messages="$errors->get('education')" />
                        </div>

                        {{-- 6. Bio --}}
                        <div>
                            <x-input-label for="bio" :value="__('Bio')" class="text-gray-700" />
                            <textarea id="bio" name="bio" rows="3" 
                                class="mt-1 block w-full bg-white border-gray-300 text-gray-900 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400 sm:text-sm" 
                                placeholder="Tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 border-none text-white font-bold py-2 rounded-lg">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                        
                        @if (session('status') === 'profile-updated')
                             <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-green-600 font-medium text-center">{{ __('Data berhasil disimpan.') }}</p>
                        @endif
                    </form>
                </div>
            </div>

            {{-- BAGIAN 3: Update Password --}}
            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-xl border border-gray-200">
                <div class="w-full">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Update Password') }}</h3>
                    <div class="text-gray-900">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- BAGIAN 4: Hapus Akun --}}
            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-xl border border-gray-200">
                <div class="w-full">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Hapus Akun') }}</h3>
                    <div class="text-gray-900">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>