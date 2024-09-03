import './bootstrap';

import { createApp } from 'vue'
import App from  './src/App.vue'
import router from './router/index'


import ToastPlugin from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-bootstrap.css';
const app = createApp(App)

app.use(ToastPlugin);

app.use(router)

app.mount('#app')
