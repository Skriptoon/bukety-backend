import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import postcss from 'postcss';

export default defineConfig({
    server: {
        host: true,
        hmr: {
            host: 'bukety.localhost',
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        postcss(),
    ],
    css: {
        preprocessorOptions: {
            scss: {
            },
        },
    },
    build: {
        manifest: 'manifest.json',
    },
});
