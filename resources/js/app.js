import { createApp } from '/vue';
import App from '../frontend/src/App.vue'; // Убедитесь, что путь правильный
import router from '../frontend/src/router/router.js'; // Убедитесь, что путь правильный
import axios from '/axios';
import '../frontend/src/assets/index.css'; // Убедитесь, что путь правильный

const app = createApp(App);

// Добавление Axios в глобальные свойства
app.config.globalProperties.$axios = axios;

// Использование маршрутизатора
app.use(router).mount('#app');
