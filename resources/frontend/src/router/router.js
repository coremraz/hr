import { createRouter, createWebHistory } from 'vue-router';
import HelloWorld from '../components/HelloWorld.vue';
import AuthRedirect from '../views/AuthRedirect.vue';
import { useAuth } from '../composables/useAuth.jsx';
import MyAccount from "../views/MyAccount.vue";
import improveResume from "../views/ImproveResume.vue";
import Faq from "../views/Faq.vue";
import AdminPanel from "../views/AdminPanel.vue";
import AiPromotion from "../views/AiPromotion.vue";
import Training from "../views/Training.vue";

const routes = [
    {
        path: '/',
        name: 'App',
        component: HelloWorld,
    },
    {
        path: '/hhAuthSuccess', // Route for successful HH.ru auth callback
        name: 'AuthRedirect',
        component: AuthRedirect
    },
    {
        path: '/account',
        name: 'account',
        component: MyAccount,
        meta: { requiresAuth: true }
    },
    {
        path: '/improve',
        name: 'improve',
        component: improveResume,
        meta: { requiresAuth: false }
    },
    {
        path: '/promote',
        name: 'promote',
        component: AiPromotion,
        meta: { requiresAuth: false }
    },
    {
        path: '/training',
        name: 'training',
        component: Training,
        meta: { requiresAuth: false }
    },
    {
        path: '/faq',
        name: 'faq',
        component: Faq,
        meta: { requiresAuth: false }
    },
    {
        path: '/logout',
        name: 'logout',
        beforeEnter: async (to, from, next) => {
            const auth = useAuth();
            await auth.logout(); // Perform the logout operation
            next('/'); // Redirect to the home page after logout
        },
        meta: { requiresAuth: true }
    },

    // admin

    {
        path: '/admin',
        name: 'admin',
        component: AdminPanel,
        meta: { requiresAuth: false }
    },


];

const router = createRouter({
    history: createWebHistory("/"),
    routes
});


router.beforeEach(async (to) => {
    const auth = useAuth();
    await auth.checkAuth(); // Проверяем аутентификацию перед каждым переходом
    console.log('isAuthenticated:', auth.isAuthenticated.value); // Логируем состояние аутентификации

    if (to.meta.requiresAuth && !auth.isAuthenticated.value) {
        console.log('Перенаправление на логин'); // Логируем перенаправление
        return { name: 'login' };
    }

    if (to.name === 'login' && auth.isAuthenticated.value) {
        return { name: 'home' };
    }

    return true; // Разрешаем переход
});
export default router;
