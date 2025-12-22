@props(['size' => 'w-50 h-50']) {{-- Default ukuran (jika tidak di-set di view lain) --}}

@php
    // --- PENGATURAN MANUAL ---
    // Pastikan nama file ini SAMA PERSIS dengan file yang Anda taruh di folder storage
    $pathGambar = '3.png'; 
@endphp

<div class="flex flex-col items-center justify-center gap-2">
    {{-- Gambar --}}
    <img 
        src="{{ route('app.logo') }}" 
        alt="Application Logo"
        {{ $attributes->merge(['class' => 'object-cover rounded-full ' . $size]) }}
        onerror="this.style.display='none'"
    >
    <span class="text-sm font-medium text-gray-700 text-center">
    </span>
</div>