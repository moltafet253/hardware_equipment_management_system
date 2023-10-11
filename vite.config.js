import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from 'tailwindcss';
export default defineConfig({
    base: '/hib.ismc.ir/',
    server: {
        https: true,
    },
    plugins: [
        laravel({
            input: ['resources/css/login.css','resources/js/login.js','resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    css: {
        postcss: {
            plugins: [
                tailwindcss('./tailwind.config.js'),
            ],
        },
    },
});
