<x-app-layout>
    {{-- Header Section --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 max-w-lg mx-auto">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('Settings') }}
            </h2>

            <a href="{{ route('profile.index', Auth::user()->username ?? Auth::user()->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                {{ __('Lihat Profil') }} &rarr;
            </a>
        </div>
    </x-slot>

    {{-- Main Background --}}
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-white">

        {{-- Container --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Update Password Section --}}
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
                <div class="w-full">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Update Password') }}</h3>
                    <div class="text-gray-900 dark:text-white">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Delete Account Section --}}
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="w-full">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Hapus Akun') }}</h3>
                    <div class="text-gray-900 dark:text-white">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>