<script setup>
import { ref } from 'vue'
import PhoneOrAuth from "../components/phoneOrAuth.vue";
import AiPromotionAuth from "../components/AiPromotionAuth.vue";

const featuresItems = ref([
    {
        icon: `<svg data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>`,
        title: 'Интеллектуальный подбор вакансий',
        details: 'Нейросетевой анализ для поиска наиболее подходящих вакансий, а не просто рассылка.'
    },
    {
        icon: `<svg data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>`,
        title: 'Персонализированные сопроводительные письма',
        details: 'Сопроводительное письмо под каждую вакансию, учитывающее ваше резюме и специфику позиции.'
    },
    {
        icon: `<svg data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>`,
        title: 'Автоматическое решение тестовых заданий',
        details: 'ИИ отвечает на тестовые вопросы вакансии, используя ваше резюме. В случае затруднений уведомляет вас.'
    },
    {
        icon: `<svg data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>`,
        title: 'Автоматический подъем резюме',
        details: 'Подъем резюме каждые 4 часа для максимальной видимости.'
    },
    {
        icon: `<svg data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>`,
        title: 'Статистика востребованных навыков',
        details: 'Ежедневная статистика по самым востребованным навыкам в интересующих вас вакансиях.'
    },
    {
        icon: `<svg data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-.1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>`,
        title: 'Рекомендации по улучшению резюме',
        details: 'Регулярные рекомендации по улучшению вашего резюме для повышения эффективности.'
    },
])
</script>

<template>
    <div class="bg-gray-100 py-16">
        <div class="container mx-auto px-4 space-y-12">
            <!-- Hero Section -->
            <section class="text-center bg-white rounded-3xl shadow-xl p-6 md:p-12">
                <h1 class="font-extrabold text-2xl sm:text-3xl md:text-5xl leading-tight mb-4 text-gray-900">
                    <span class="bg-blue-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded-full shadow-md">AI</span> для поиска работы
                </h1>
                <h2 class="font-semibold text-gray-700 text-lg sm:text-xl md:text-2xl">
                    Потратьте часы на саморазвитие, а не рутину!
                </h2>
            </section>

            <!-- Features Section -->
            <section class="bg-white rounded-3xl shadow-xl p-6 md:p-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    <div v-for="(item, index) in featuresItems" :key="index" class="rounded-xl p-4 md:p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                        <div class="flex items-start md:items-center space-x-2 md:space-x-4">
                            <div class="flex-shrink-0 h-8 w-8 md:h-10 md:w-10 flex p-1 md:p-2 items-center justify-center rounded-xl bg-blue-500 text-white" v-html="item.icon"></div>
                            <div>
                                <h4 class="text-base md:text-lg font-semibold text-gray-800">{{ item.title }}</h4>
                            </div>
                        </div>
                        <p class="mt-2 md:mt-3 text-sm md:text-base text-gray-600 leading-relaxed">
                            {{ item.details }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- Call to Action Section -->
            <section class="text-center bg-white rounded-3xl shadow-xl p-6 flex items-center justify-center flex-col md:p-12">
                <h2 class="font-bold text-2xl sm:text-3xl md:text-4xl text-gray-800 mb-4 md:mb-6">
                    <span class="bg-blue-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded-full shadow-md">Начинаем?</span>
                </h2>
                <div class="font-semibold text-gray-500 text-xs sm:text-sm md:text-2xs mb-5 md:mb-8">Остались вопросы? Взгляните в наш <a href="/faq" class="text-blue-500 underline cursor-pointer">FAQ</a></div>
                <AiPromotionAuth/>
            </section>
        </div>
    </div>
</template>

<style scoped>

</style>
