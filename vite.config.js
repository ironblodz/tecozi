import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

// Definindo a configuração do Vite
export default defineConfig({
    server: {
    cors: true,
  },
  optimizeDeps: {
        include: ['vue-meta'],
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js', // JavaScript principal
                'resources/css/app.css', // CSS principal
            ],
            refresh: true, // Habilita o refresh automático do navegador
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
