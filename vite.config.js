import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [        
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/mobile.css',
                'resources/css/header-carousel.css',
                'resources/js/home.js',
                'resources/js/mobile.js',
                'resources/js/header-carousel.js',
                'resources/js/app.js',
                'resources/js/instagram-api-feed.js',],
            refresh: true,
        }),
    ],
});
