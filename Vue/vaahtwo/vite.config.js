import path from 'path'
import { resolve } from 'path'
import {fileURLToPath, URL} from 'url'

import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components'
import {PrimeVueResolver} from '@openvue/auto-import-resolver'

const pathSrc = path.resolve(__dirname, 'Vue')

// https://vitejs.dev/config/
export default defineConfig({
    /* M3-T5-03 (F10) — the admin is served from a sub-path (the Blade head
       loads the build via vh_get_backend_assets('build/index.css', 'vaahtwo'),
       e.g. /vaahcms/backend/vaahtwo/build/). The default base '/' rewrites
       every CSS url() to a root-absolute path (url(/Inter-*.woff2),
       url(/openicons.*)) which 404s because the font files live beside the
       CSS under the sub-path. Emitting a relative base makes the url()s
       relative to the stylesheet's own directory so they resolve correctly
       regardless of the deployment path. (The built index.html is a standalone
       artifact — Laravel serves the SPA through a Blade template, so its
       relative script/link rewrites are harmless.) */
    base: './',
    /* M5-T3 (F18) recorded a dev-server defect: Vite 3's dependency optimizer
       hard-codes ESBUILD_MODULES_TARGET (es2020/chrome87/edge88/firefox78/safari13)
       in dev regardless of build.target, and OpenVue 1.1.1's InputNumber uses
       BigInt literals (0n) for exact decimal arithmetic — es2020 predates BigInt,
       so `vite optimize` failed and the dev server could not pre-bundle openvue.
       The production build already ships the same code at "esnext" (below), so
       aligning the dev optimizer with it changes nothing that is emitted and
       un-files the recorded dev-server defect. (esbuildOptions is spread after
       the optimizer's hard-coded target, so this override wins.) */
    optimizeDeps: {
        esbuildOptions: {
            target: 'esnext',
        },
    },
    plugins: [
        vue(),
        // M3-T3 (F11): OpenVue auto-import is now the sole resolution path
        // (ADR-004). PrimeVueResolver (@openvue/auto-import-resolver)
        // resolves every OpenVue component and directive from
        // @openvue/metadata — the PrimeVue 3 manual registry in
        // main.js / main-extended.js was retired in F11, so no coexist
        // shim (openvue-coexist.js) remains.
        Components.vite({
            dts: false,
            resolvers: [PrimeVueResolver()],
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
        /* M3-T2 (F10) — the admin serves exactly one stylesheet
           (build/index.css, R4.9). With per-chunk CSS splitting the two
           SPA entries each emit their own css asset, and a shared-chunk
           css asset can silently overwrite an entry css asset (same
           [name].css output name). Disabling CSS code splitting routes
           every style in the graph (the converged build.scss, the xterm
           css, the scoped component css) into a single emitted
           stylesheet. */
        cssCodeSplit: false,
        /*lib: {
            entry: resolve(__dirname, 'Vue/main.js'),
            name: 'MyApp',

        },*/
        outDir: './../../Resources/assets/backend/vaahtwo/build/',
        rollupOptions: {
            input: {
                main: fileURLToPath(new URL('./index.html', import.meta.url)),
                mainExtended: fileURLToPath(new URL('./index-extended.html', import.meta.url)),
            },
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                /* M3-T2 (F10) — with cssCodeSplit disabled, Vite 3 emits the
                   merged stylesheet under its internal bundle name
                   (style.css). The admin head links build/index.css (R4.9 —
                   the single canonical stylesheet), so map that asset to
                   index.css and leave every other asset (fonts, images)
                   named after itself. */
                assetFileNames: (assetInfo) =>
                    assetInfo.name === 'style.css'
                        ? 'index.css'
                        : '[name].[ext]',
            },
            //external: ['vue', /primevue-3.20.0\/.+/],
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
