<script setup>
import PhoneOrAuth from "../components/phoneOrAuth.vue";
</script>

<template>
    <div class="bg-gray-100 py-8 sm:py-16">
        <div class="container mx-auto px-4 space-y-8 sm:space-y-12">
            <!-- Hero Section -->
            <section class="text-center bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-8 md:p-12">
                <h1 class="font-extrabold text-2xl sm:text-3xl md:text-4xl lg:text-5xl leading-tight mb-4 sm:mb-6 text-gray-900">
                    РЕЗЮМЕ, <span class="block md:inline bg-blue-500 text-white px-1 py-1.5 sm:px-4 sm:py-2 rounded-full shadow-lg mt-2 md:mt-0"> КОТОРОЕ ЗАМЕТЯТ </span>
                </h1>
                <h2 class="font-semibold text-gray-700 text-lg sm:text-xl md:text-2xl mb-3 sm:mb-4">
                    Ваше резюме не получает ответов? <br class="sm:hidden">
                    <span class="font-bold text-blue-500">Я это исправлю!</span>
                </h2>
                <p class="text-gray-500 mb-10 text-sm sm:text-base max-w-lg mx-auto">
                    Проблема может быть не в вашем опыте, а в том, как вы его представляете.
                </p>

                <a href="#entry" class="mt-4 cursor-pointer sm:mt-5 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2.5 px-6 sm:py-3 sm:px-8 rounded-full text-base sm:text-lg shadow-md transition-transform duration-300 ">
                    Улучшить резюме
                </a>
            </section>

            <!-- Услуга "Улучшение резюме" Section -->
            <section class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-8 md:p-12">
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-4 sm:mb-6 text-center">
                        Услуга <span class="text-blue-500">«Улучшение резюме»</span> <br class="sm:hidden">
                    поможет вам выделиться среди сотен других кандидатов.
                </h3>

                <div>
                    <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Что вы получите:</h4>
                    <ul class="list-disc list-inside space-y-1 sm:space-y-2 text-sm sm:text-base text-gray-700">
                        <li>✅ Профессиональный анализ вашего текущего резюме</li>
                        <li>✅ Переработку структуры и содержания для наилучшего результата</li>
                        <li>✅ Выделение ваших ключевых достижений и навыков</li>
                        <li>✅ Оптимизацию под ATS-системы (которые отсеивают до 75% резюме!)</li>
                        <li>✅ Современный, читаемый дизайн документа</li>
                    </ul>
                </div>

                <div class="mt-6 sm:mt-8">
                    <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Почему это работает:</h4>
                    <p class="text-sm sm:text-base text-gray-700 mb-3 sm:mb-4">
                        У рекрутеров есть всего <span class="font-bold text-blue-500">7 секунд</span> на первичный просмотр резюме.
                        Я знаю, как сделать эти секунды решающими в вашу пользу.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700">
                        Я 10 лет работала на стороне HR и знаю, что именно ищут работодатели в разных отраслях.
                    </p>
                </div>
            </section>

            <!-- PhoneOrAuth Component -->
            <section id="entry" class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-8 md:p-12">
                <PhoneOrAuth />
            </section>
        </div>
    </div>
</template>

<style scoped>

</style>
