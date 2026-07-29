import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['swiper', 'alpinejs'],
                },
            },
        },
    },
    server: {
        host: '0.0.0.0',
        origin: 'http://10.137.134.27:5173',
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
