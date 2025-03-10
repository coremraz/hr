<template>
    <button @click="redirectToHHAuth" class="d-flex items-center font-bold text-danger long-button w-[200px] h-[50px]">{{text}}</button>
</template>

<script setup>
import router from "../../router/router.js";

const props = defineProps({
    text: {
        type: String,
        default: "Login",
    },
});

const redirectToHHAuth = () => {
    const currentPath = router.currentRoute.value.fullPath;
    localStorage.setItem('authRedirectRef', currentPath);
    const hhAuthUrl = `https://hh.ru/oauth/authorize?client_id=${import.meta.env.VITE_HH_CLIENT_ID}&response_type=code&redirect_uri=${encodeURIComponent(import.meta.env.VITE_HH_REDIRECT_URI)}`;
    window.location.href = hhAuthUrl;
};

</script>

<style scoped>

</style>
