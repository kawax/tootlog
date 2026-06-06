import {defineConfig} from 'vite'
import laravel from 'laravel-vite-plugin'
import {bunny} from 'laravel-vite-plugin/fonts';
import tailwindcss from "@tailwindcss/vite";
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.ts',
                'resources/css/welcome.css',
                'resources/js/welcome.ts',
            ],
            fonts: [
                bunny('instrument-sans', {
                    alias: 'sans',
                    weights: [400, 500, 600],
                })
            ],
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    server: {
        cors: true,
    },
})
