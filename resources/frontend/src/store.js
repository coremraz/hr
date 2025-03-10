// store.js
import {createStore} from 'vuex';
import axios from "axios";

const store = createStore({
    state: {
        user: null,
    },
    mutations: {
        setUser(state, user) {
            state.user = user; // Устанавливаем пользователя
        },
        setIsAuthenticated(state, isAuthenticated) {
            state.isAuthenticated = isAuthenticated; // Устанавливаем статус аутентификации
        },
    },

    actions: {
        checkAuthStatus: async () => {
            try {
                const response = await axios.get('/api/me', {withCredentials: true});
                if (response.data) {
                    store.commit('setUser', response.data);
                    store.commit('setIsAuthenticated', true);

                    return true;
                } else {
                    store.commit('setIsAuthenticated', false);
                    return false;
                }
            } catch (err) {
                store.commit('setIsAuthenticated', false);
                console.error('Error checking auth status:', err);
                return false;
            }
        },
        async login({commit}, credentials) {
            try {
                // Здесь вы можете выполнить асинхронный запрос для входа
                // Например, с использованием axios:
                const response = await axios.post('https://api.example.com/login', credentials);
                commit('setUser ', response.data.user); // Обновление состояния с данными пользователя
            } catch (error) {
                console.error('Ошибка при входе:', error);
                // Обработка ошибок (например, уведомление пользователя)
            }
        }
        ,
        logout({commit}) {
            commit('setUser ', null); // Сброс состояния
            // Здесь вы можете также выполнить запрос на выход, если это необходимо
        }
        ,
    },
    getters: {
        getUser(state) {
            return state.user; // Возвращает объект пользователя или null
        },
        isAuthenticated(state) {
            return !!state.user; // Проверка, залогинен ли пользователь
        },
    },
});

export default store;
