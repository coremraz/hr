<template>
    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-900 fixed top-0 w-full z-999" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a v-for="item in navigation" :key="item.name" :href="item.href"
                                   :class="[route.path === item.href ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                   :aria-current="route.path === item.href ? 'page' : undefined">{{ item.name }}</a>
                                <a v-if="isAuthenticated && user.admin" href="/admin"
                                   :class="[active ? 'bg-white-100 outline-hidden' : '', 'block px-4 py-2 text-sm text-blue-400']">Админ панель</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">

                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div v-if="isAuthenticated">
                                    <MenuButton
                                        class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                                        <span class="absolute -inset-1.5"/>
                                        <span class="sr-only">Open user menu</span>
                                        <span class="text-gray-300 p-1 pl-2">{{ user.name }}</span>
                                        <UserCircleIcon class="h-10 w-10 text-gray-500" />
                                    </MenuButton>
                                </div>

                                <div v-else>
                                    <AuthButton :text="'войти через hh.ru'"></AuthButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100"
                                            enter-from-class="transform opacity-0 scale-95"
                                            enter-to-class="transform opacity-100 scale-100"
                                            leave-active-class="transition ease-in duration-75"
                                            leave-from-class="transform opacity-100 scale-100"
                                            leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden">
                                        <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                            <a :href="item.href"
                                               :class="[active ? 'bg-gray-100 outline-hidden' : '', 'block px-4 py-2 text-sm text-gray-700']">{{
                                                    item.name
                                                }}</a>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton
                            class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                            <span class="absolute -inset-0.5"/>
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true"/>
                            <XMarkIcon v-else class="block size-6" aria-hidden="true"/>
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="md:hidden">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href"
                                      :class="[route.path === item.href ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                                      :aria-current="route.path === item.href ? 'page' : undefined">{{ item.name }}
                    </DisclosureButton>
                </div>
                <div class="border-t border-gray-700 pt-4 pb-3">
                    <div v-if="isAuthenticated" class="flex items-center px-5">
                        <UserCircleIcon class="h-10 w-10 text-gray-500" />
                        <div class="ml-3">
                            <div class="text-base/5 font-medium text-white">{{ user.name }}</div>
                            <div class="text-sm font-medium text-gray-400">{{ user.email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <DisclosureButton v-if="isAuthenticated" v-for="item in userNavigation" :key="item.name" as="a" :href="item.href"
                                          class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                            {{ item.name }}
                        </DisclosureButton>
                        <DisclosureButton v-else @click="redirectToHHAuth" class="block rounded-md px-3 py-2 text-base font-medium bg-red-800 text-white hover:bg-gray-700 hover:text-white">Войти через hh.ru</DisclosureButton>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
        <main>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-center flex-col pt-16"> <!-- Добавлено pt-16 для компенсации высоты Navbar -->
                <!-- In your App.vue or layout component -->
                <router-view></router-view>
            </div>
        </main>
    </div>

    <footer class="bg-white rounded-lg shadow-sm m-4">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
      <span class="text-sm text-gray-500 sm:text-center">Наталья Пенькова. Все права защищены.
    </span>
            <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                <li v-for="item in navigation">
                    <a :href="item.href" class="hover:underline me-4 md:me-6">{{item.name}}</a>
                </li>
            </ul>
        </div>
    </footer>
</template>


<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {Bars3Icon, XMarkIcon} from '@heroicons/vue/24/outline'
import {useStore} from 'vuex';
import {useAuth} from "./composables/useAuth.jsx";
import {computed, ref, onMounted} from 'vue';
import AuthButton from "./components/Buttons/AuthButton.vue";
import { UserCircleIcon } from "@heroicons/vue/24/solid";
import {useLoading} from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import {useRoute} from "vue-router";



const navigation = [
    {name: 'Главная', href: '/'},
    {name: 'AI поиск работы', href: '/promote'},
    {name: 'Улучшение резюме', href: '/improve'},
    {name: 'Тренинг собеседование', href: '/training'},
    {name: 'FAQ', href: '/faq'},
]
const userNavigation = [
    {name: 'Профиль', href: '/account'},
    {name: 'Выйти', href: '/logout'},
]

const store = useStore();
const isAuthenticated = computed(() => store.getters.isAuthenticated);
const user = computed(() => store.getters.getUser);
console.log(user.admin)

const logout = () => {
    auth.logout(); // Вызываем действие для выхода
};

const auth = useAuth(); // Получаем useAuth composable

const $loading = useLoading({
    loader: 'spinner',
    width: 100,
    height: 100,
    isFullPage: true,
    zIndex: 9999,
    container: document.body,
    lockScroll: true,
    enforceFocus: true,
});

const route = useRoute(); // Get current route

onMounted(async () => {
    const loader = $loading.show();
    try {
        await auth.checkAuth();
    } finally {
        loader.hide();
    }
});

</script>
