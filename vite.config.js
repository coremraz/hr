import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'; // Импортируйте модуль path
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    publicDir: 'public',
    root: path.resolve(__dirname), // Явно указываем корневую директорию проекта
    plugins: [
        vue(),
        laravel({
            input: ['resources/frontend/src/main.js',
                    'resources/frontend/src/assets/index.css'],
            refresh: true,
            manifest: 'public/build/manifest.json' // Явно указываем путь к манифесту
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': '/resources/frontend/src',
            '~': '/node_modules',
        },
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: true,
        origin: '*'
    },
    build: {
        outDir: 'public/build',
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
            }
        }
    },
});
