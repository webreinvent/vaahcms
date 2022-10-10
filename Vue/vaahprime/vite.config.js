import path from 'path'
import { resolve } from 'path'
import {fileURLToPath, URL} from 'url'

import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'

const pathSrc = path.resolve(__dirname, './')

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        vue(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./', import.meta.url))
        }
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "./../../Resources/assets/backend/common/fontawesome-6.2.0/css/all.css";`
            }
        }
    },
    build: {
        chunkSizeWarningLimit: 1600,
        target: "esnext",
        /*lib: {
            entry: resolve(__dirname, 'Vue/main.js'),
            name: 'MyApp',

        },*/
        outDir: './../../Resources/assets/backend/vaahprime/builds/',
        rollupOptions: {
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`
            },
            //external: ['vue', /primevue\/.+/],
        }
    },
    server: {
        watch: { usePolling: true, },
        port: 2323,
        hmr:{
            protocol: 'ws',
            host: 'localhost',

        }
    }
})
