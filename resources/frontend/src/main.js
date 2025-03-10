import { createApp } from 'vue';
import App from './App.vue';
import router from './router/router.js';  // Путь может быть скорректирован
import store from './store.js';  // Путь может быть скорректирован
import axios from 'axios'; // Просто 'axios', node_modules разрешится
import './assets/index.css';
import {LoadingPlugin} from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';


const app = createApp(App);

// Подключение Axios как глобального свойства
app.config.globalProperties.$axios = axios;
axios.defaults.baseURL = 'http://localhost:8081'; // Или ваш URL backend
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

// Подключение маршрутизатора
app.use(router);

app.use(LoadingPlugin);

// Подключение Vuex хранилища
app.use(store);

// Монтирование приложения
app.mount('#app');
