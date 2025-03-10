<template>
    <div class="d-flex align-items-center">
        <div v-if="success" class="flex flex-col items-center">
            <PulseLoader></PulseLoader>
           <span class="font-bold text-xl">Подождите, входим...</span>
        </div>
    </div>
</template>

<script>
import { useRoute, useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useStore } from 'vuex';
import PulseLoader from "../components/PulseLoader.vue"; // Import useStore

export default {
    name: 'AuthRedirect',
    components: {PulseLoader},
    setup() {
        const route = useRoute();
        const router = useRouter();
        const store = useStore(); // Use useStore to access the Vuex store
        const success = ref(false);
        const error = ref('');
        const user = ref(null);

        const isAuthenticated = ref(store.getters.isAuthenticated); // Reactive isAuthenticated
        const loggedInUser = ref(store.getters.getUser); // Reactive user

        const checkAuthStatus = async () => {
            try {
                const response = await axios.get('/api/me', { withCredentials: true });
                if (response.data) {
                    user.value = response.data;
                    store.commit('setUser', response.data); // Используйте commit вместо dispatch
                    store.commit('setIsAuthenticated', true); // Обновите Vuex store
                    isAuthenticated.value = true; // Обновите реактивную переменную
                    loggedInUser.value = response.data; // Обновите реактивную переменную
                    success.value = true; // Установите успех
                    console.log('Текущий пользователь:', store.getters.getUser );
                    console.log('Статус аутентификации:', store.getters.isAuthenticated);
                    // Получаем сохраненный путь или используем корневой
                    const redirectPath = localStorage.getItem('authRedirectRef') || '/';
                    localStorage.removeItem('authRedirectRef'); // Очищаем хранилище

                    console.log('Перенаправление на:', redirectPath);
                    router.push(redirectPath); // Используем сохраненный путь
                } else {
                    isAuthenticated.value = false; // Обновите реактивную переменную
                    store.commit('setIsAuthenticated', false); // Обновите Vuex store
                }
            } catch (err) {
                error.value = err.message || 'Failed to check authentication status.';
                isAuthenticated.value = false; // Обновите реактивную переменную
                store.commit('setIsAuthenticated', false); // Обновите Vuex store
                console.error('Error checking auth status:', err);
            }
        };
        const redirectToHHAuth = () => {
            const hhAuthUrl = `https://hh.ru/oauth/authorize?client_id=${import.meta.env.VITE_HH_CLIENT_ID}&response_type=code&redirect_uri=${encodeURIComponent(import.meta.env.VITE_HH_REDIRECT_URI)}`;
            window.location.href = hhAuthUrl;
        };

        onMounted(async () => {
            if (route.query.success === 'true') {
                success.value = true;
                await checkAuthStatus();
            } else if (route.query.success === 'false' || route.query.error) {
                success.value = false;
                error.value = route.query.error || 'Authentication failed.';
            } else {
                await checkAuthStatus(); // Check auth status on component mount if not coming from redirect
            }
        });

        return {
            success,
            error,
            user,
            isAuthenticated,
            loggedInUser,
            redirectToHHAuth
        };
    },
    watch: {
        loggedInUser(newUser) {
            if (newUser) {
                console.log('User logged in (reactive watch):', newUser);
            } else {
                console.log('User logged out (reactive watch)');
            }
        },
        isAuthenticated(newValue) {
            console.log('isAuthenticated changed (reactive watch):', newValue);
        }
    }
};
</script>
