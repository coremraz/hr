import { useStore } from 'vuex';
import { ref } from "vue";
import axios from "axios";

export function useAuth() {
    const store = useStore(); // Получите доступ к Vuex Store
    const isAuthenticated = ref(false);
    const loginError = ref(null);
    const loading = ref(true);

    const checkAuth = async () => {
        loading.value = true; // Устанавливаем состояние загрузки в true
        let res = await store.dispatch('checkAuthStatus');
        if (res) {
            isAuthenticated.value = true;
        } else {
            isAuthenticated.value = false; // Устанавливаем в false, если не аутентифицирован
        }
        loading.value = false; // Устанавливаем состояние загрузки в false после проверки
    };
    const login = async (userData) => {
        loginError.value = null;
        try {
            const response = await axios.post('/api/auth', userData);
            if (response.status === 200) {
                store.commit('setUser ', response.data.user); // Устанавливаем пользователя в Vuex
                isAuthenticated.value = true;
                await router.push('/');
                return true;
            } else {
                loginError.value = { general: ['Ошибка логина.'] };
                return false;
            }
        } catch (error) {
            isAuthenticated.value = false;
            // Обработка ошибок
            return false;
        }
    };

    const logout = async () => {
        try {
            await axios.post('/api/logout', { withCredentials: true });
            store.commit('setUser', null);
            isAuthenticated.value = false;
            await router.push('/');
            return true;
        } catch (error) {
            return false;
        }
    };

    return {
        isAuthenticated,
        loginError,
        loading,
        checkAuth,
        login,
        logout
    };
}
