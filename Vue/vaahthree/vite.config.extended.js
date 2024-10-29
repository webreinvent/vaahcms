import path from 'path'
import { resolve } from 'path'
import {fileURLToPath, URL} from 'url'

import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import { viteStaticCopy } from 'vite-plugin-static-copy'

const pathSrc = path.resolve(__dirname, 'Vue')


// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        vue(),
        viteStaticCopy({
            targets: [
                {
                    src: './../../Resources/assets/backend',
                    dest: './../../../../../../../public/vaahcms/',
                }
            ]
        }),
    ],
    resolve: {
        alias: {
            //'@': fileURLToPath(new URL('./', import.meta.url))
        }
    },
    build: {
        chunkSizeWarningLimit: 1600,
        target: "esnext",
        cssCodeSplit: true,
        outDir: './../../Resources/assets/backend/vaahthree/build/',
        rollupOptions: {
            input: {
                mainExtended: path.resolve(__dirname, './main-extended.js'),
            },
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`
            },
        }
    },
    server: {
        watch: { usePolling: true, },
        port: 9087,
        hmr:{
            protocol: 'ws',
            host: 'localhost',

        }
    }
})
