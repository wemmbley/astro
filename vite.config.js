import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import solid from 'vite-plugin-solid'
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['src/UI/Bootstrap/App.css', 'src/UI/Bootstrap/Bootstrap.js'],
            refresh: true,
        }),
        tailwindcss(),
        solid({
            include: /\.tsx$/,
        }),
        vue(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'src/UI'),
        },
    },
});
