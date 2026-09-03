import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/style1.css',
                'resources/css/styles.css',
                'resources/js/app.js',
                'resources/js/message.js',
            ],
            refresh: true,
        }),
    ],
});
