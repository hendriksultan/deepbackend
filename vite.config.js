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
    server: {
        // Tambahkan blok ini agar bisa diakses via tunnel
        host: '0.0.0.0',
        hmr: {
            host: 'app.kelolawarga.my.id', // Domain tunnel Anda
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});