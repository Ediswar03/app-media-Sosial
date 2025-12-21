<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Card 1: Update Profile Images --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-images-form')
                </div>
            </div>

            {{-- Card 2: Profile Information --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Informasi Profil') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
                            </p>
                        </header>
                    
                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                    
                            {{-- Grid Layout for Form --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                    
                                <div>
                                    <x-input-label for="username" :value="__('Username')" />
                                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
                                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                                </div>
                    
                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    
                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                {{ __('Your email address is unverified.') }}
                                                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>
                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                    
                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="bio" :value="__('Bio')" />
                                    <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('bio', $user->bio) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                                </div>
                    
                                <div>
                                    <x-input-label for="location" :value="__('Lokasi')" />
                                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->location)" placeholder="e.g., Jakarta, Indonesia" />
                                    <x-input-error class="mt-2" :messages="$errors->get('location')" />
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('No Handphone')" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" placeholder="e.g., 08123456789" />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>

                                <div>
                                    <x-input-label for="job_title" :value="__('Pekerjaan')" />
                                    <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full" :value="old('job_title', $user->job_title)" placeholder="e.g., Web Developer" />
                                    <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
                                </div>
                    
                                <div>
                                    <x-input-label for="company" :value="__('Perusahaan')" />
                                    <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company', $user->company)" placeholder="e.g., VibeNet Inc." />
                                    <x-input-error class="mt-2" :messages="$errors->get('company')" />
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="education" :value="__('Pendidikan')" />
                                    <x-text-input id="education" name="education" type="text" class="mt-1 block w-full" :value="old('education', $user->education)" placeholder="e.g., Universitas Gadjah Mada" />
                                    <x-input-error class="mt-2" :messages="$errors->get('education')" />
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="address" :value="__('Alamat')" />
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" placeholder="e.g., Jl. Jenderal Sudirman No. 52-53" />
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>
                            </div>
                    
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                    
                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>