import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/vibenet-theme.css', 
                'resources/js/app.jsx', // KEMBALIKAN KE .jsx (Standar React)
            ],
            refresh: true,
        }),
        react(),
    ],
    // HAPUS bagian esbuild manual. Plugin 'react()' di atas sudah menangani ini otomatis.
});