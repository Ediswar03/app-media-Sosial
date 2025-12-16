@props(['size' => 'w-20 h-20']) {{-- Default ukuran (jika tidak di-set di view lain) --}}

@php
    // --- PENGATURAN MANUAL ---
    // Pastikan nama file ini SAMA PERSIS dengan file yang Anda taruh di folder storage
    $pathGambar = 'logo.jpg'; 
@endphp

<img 
    src="{{ asset('storage/' . $pathGambar) }}" 
    alt="Application Logo"
    {{ $attributes->merge(['class' => 'object-cover rounded-full ' . $size]) }}
    onerror="this.style.display='none'" {{-- Opsional: Sembunyikan jika gambar gagal dimuat --}}
>