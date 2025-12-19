import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // 1. PENTING: Mengaktifkan dark mode berbasis class agar tombol toggle berfungsi
    darkMode: 'class',

    // 2. Content: Menambahkan path JS agar class di dalam file Alpine/Vue/React terbaca
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js', 
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // 3. Optional: Menambahkan warna custom jika ingin konsisten (opsional)
            colors: {
                // Contoh jika ingin warna primary sendiri:
                // primary: {
                //   50: '#eff6ff',
                //   100: '#dbeafe',
                //   500: '#3b82f6',
                //   600: '#2563eb',
                //   900: '#1e3a8a',
                // }
            }
        },
    },

    plugins: [
        forms,
        require('@tailwindcss/typography'),
    ],
};