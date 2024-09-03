import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/materialdesignicons.min.css',
                'resources/css/base.css',
                'resources/css/style.css',
                'resources/js/base.js',
                'resources/js/of-canvas.js',
                'resources/js/collapse.js',
                'resources/js/misc.js',
                'resources/js/app.ts',
            ],
            refresh: true,
        }),
    ],
});


// integrate vue js into laravel appliaction by importing the vue plugin as done above import vue from '@vitejs/plugin-vue'

// initialize typescript app, to generate typescript configuration, run: tsc --init 

// change build configuration in package.json to compile typscript file on app building replace  "build": "vite build" with "build": "vue-ts --noEmit && vite build"

// rename app.js to app.ts since we are going to use typescript and not javascript (resource/js/app.js)

