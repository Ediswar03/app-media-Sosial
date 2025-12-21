<div class="relative w-full" x-data="{ isOpen: true }" @click.away="isOpen = false">
    
    {{-- FORM PENCARIAN --}}
    <form wire:submit.prevent="search" class="relative group">
        
        {{-- 1. ICON KACA PEMBESAR (Absolute Kiri) --}}
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>

        {{-- 2. INPUT FIELD --}}
        <input 
            type="search" 
            wire:model="query"
            class="block w-full py-2.5 pl-10 pr-16 text-[15px] text-gray-900 bg-[#F0F2F5] border-transparent rounded-full focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all placeholder-gray-500 placeholder:font-normal" 
            placeholder="Cari di Social Feed" 
            autocomplete="off"
        >

        {{-- 3. TOMBOL CARI (Absolute Kanan) --}}
        <button 
            type="submit" 
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-blue-600 hover:text-blue-800 transition-colors"
            :class="{ 'opacity-50 cursor-not-allowed': !@this.query.trim() }"
            :disabled="!@this.query.trim()"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>

        {{-- 4. LOADING SPINNER --}}
        <div wire:loading class="absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </form>

    {{-- DROPDOWN HASIL --}}
    @if($results && count($results) > 0)
        <div 
            class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.1)] overflow-hidden origin-top"
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            style="display: none;"
        >
            @if($results->count() > 0)
                <ul class="py-2">
                    @foreach($results as $result)
                    <li>
                        <a href="{{ $result['url'] }}" class="flex items-center px-4 py-2.5 hover:bg-gray-100 transition-colors">
                            {{-- Icon/Gambar --}}
                            <div class="mr-3">
                                @if($result['image'])
                                    <img src="{{ $result['image'] }}" class="h-9 w-9 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                @endif
                            </div>
                            {{-- Teks --}}
                            <div>
                                <div class="text-[15px] font-medium text-gray-900">{{ $result['title'] }}</div>
                                <div class="text-[13px] text-gray-500">{{ $result['subtitle'] }}</div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada hasil untuk "{{ $query }}"</div>
            @endif
        </div>
    @elseif($query && trim($query) !== '' && count($results) === 0)
        <div class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.1)] overflow-hidden origin-top">
            <div class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada hasil untuk "{{ $query }}"</div>
        </div>
    @endif
</div>