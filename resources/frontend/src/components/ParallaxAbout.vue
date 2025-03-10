<script setup>

</script>

<template>
    <header
        class="bg-center sm:bg-[60%_30%] bg-cover bg-no-repeat bg-hero-img bg-fixed flex items-center justify-center w-screen h-screen pb-12 relative rounded-b-2xl"
        style="background-image: url('/images/natMain.webp');">

        <div class="absolute inset-0 bg-black opacity-50 rounded-b-2xl"></div> <!-- Затемняющий слой -->

        <section>
            <div class="py-10 px-4 mx-auto max-w-screen-xl text-center relative z-10 lg:py-16">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Наталья Пенькова</h1>
                <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">HR менеджер с большим стажем. Улучшу Ваше резюме, помогу пройти собеседование и найти работу с помощью современных технологий</p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                    <a href="#start" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                        Начать
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </header>
</template>

<style scoped>

</style>
