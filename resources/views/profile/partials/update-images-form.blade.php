<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Avatar and Cover Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Ensure your account is using a long, random password to stay secure.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateImages') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Avatar Image --}}
        <div>
            <x-input-label for="avatar" :value="__('Avatar')" />
            <div class="mt-2 flex items-center gap-x-3">
                <img class="h-16 w-16 rounded-full" src="{{ auth()->user()->avatar_url }}" alt="Current avatar">
                <input id="avatar" name="avatar" type="file" class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-violet-50 file:text-violet-700
                    hover:file:bg-violet-100
                "/>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        {{-- Cover Image --}}
        <div>
            <x-input-label for="cover_image" :value="__('Cover Photo')" />
            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 dark:border-gray-100/25">
                <div class="text-center">
                    <img id="cover_preview" src="{{ auth()->user()->cover_url }}" alt="Cover image preview" class="mx-auto h-48 w-full rounded-md object-cover {{ auth()->user()->cover_image ? '' : 'hidden' }}">
                    <div id="cover_placeholder" class="{{ auth()->user()->cover_image ? 'hidden' : '' }}">
                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                        <label for="cover_image" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500 dark:bg-transparent dark:text-indigo-400 dark:hover:text-indigo-300">
                            <span>Upload a file</span>
                            <input id="cover_image" name="cover_image" type="file" class="sr-only">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'images-updated')
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
<script>
    document.getElementById('cover_image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('cover_preview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            document.getElementById('cover_placeholder').classList.add('hidden');
        }
    });
</script>
