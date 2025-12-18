<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Foto Profil & Sampul') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui foto profil (avatar) dan foto sampul akun Anda.") }}
        </p>
    </header>

    {{-- Form mengarah ke route 'profile.updateImages' dengan enctype multipart --}}
    <form method="post" action="{{ route('profile.updateImages') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('post')

        @if(Auth::user()->avatar)
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Avatar Saat Ini:</p>
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-20 h-20 rounded-full object-cover border border-gray-300">
            </div>
        @endif

        <div>
            <x-input-label for="avatar" :value="__('Upload Avatar Baru')" />
            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="cover_photo" :value="__('Upload Cover Photo Baru')" />
            <input id="cover_photo" name="cover_photo" type="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('cover_photo')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Gambar') }}</x-primary-button>

            @if (session('status') === 'images-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>