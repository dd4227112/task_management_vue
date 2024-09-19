import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/assets/vendors/mdi/css/materialdesignicons.min.css',
                'resources/assets/vendors/css/vendor.bundle.base.css',
                'resources/assets/css/style.css',
                'resources/assets/vendors/js/vendor.bundle.base.js',
                'resources/assets/js/jquery.cookie.js',
                'resources/assets/js/off-canvas.js',
                'resources/assets/js/hoverable-collapse.js',
                'resources/assets/js/misc.js',
                'resources/js/app.ts',
            ],
            refresh: true,
        }),
    ],
});
// install vitejs plugin as a development dependencies  >>>> npm install --save-dev @vitejs/plugin-vue

// install vuejs >>> npm install vue@latest
// install vue router for vue routes (links)>>>> npm install vue-router@4


// integrate vue js into laravel appliaction by importing the vue plugin as done below
//  import vue from '@vitejs/plugin-vue'
// vue(),

// initialize typescript app, to generate typescript configuration, >>>>> tsc --init 
// change typescript configuration in tsconfig.json
//  {
//     "compilerOptions": {
//       "allowJs": true,
//       "module": "ESNext",
//       "lib": ["ES2020", "DOM", "DOM.Iterable"],
//       "moduleResolution": "Node",
//       "target": "esnext",
//       "jsx": "preserve",
//       "strict": true,
//       "esModuleInterop": true,
//       "skipLibCheck": true,
//       "forceConsistentCasingInFileNames": true,
//       "noEmit": true,
//       "isolatedModules": true,
//       "types": ["vite/client"]
//     },
//     "exclude": ["node_modules", "public"],
//     "include": [
//       "resources/js/**/*.ts",
//       "resources/js/**/*.d.ts",
//       "resources/js/**/*.vue",
//       "resources/js/app.ts",
//       "resources/js/bootstrap.js",
//       // "resources/js/router/routes/route.ts"
//     ]
//   }

// change build configuration in package.json to compile typscript file on app building replace  "build": "vite build" with "build": "vue-ts --noEmit && vite build"

// rename app.js to app.ts since we are going to use typescript and not javascript (resource/js/app.js)

