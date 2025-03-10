<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
// icons
import { StopIcon } from "@heroicons/vue/24/outline";
import { PlayIcon } from "@heroicons/vue/24/outline";
import SearchSelect from "../components/SearchSelect.vue";
import SearchSelectBase from "../components/SearchSelectBase.vue";


const entries = ref([]);
const deletedEntries = ref([]);
const isArchived = ref(false);

// Virtual machines

const machines = ref([
    { value: 1, label: 'машина 1' },
    { value: 2, label: 'машина 2' },
    { value: 3, label: 'машина 3' }
])

const getEntries = async () => {
    try {
        const response = await axios.get('/api/getEntries');
        entries.value = response.data.entries;
        deletedEntries.value = response.data.deletedEntries;
        console.log(entries.value);
    } catch (error) {
        console.error('Ошибка при отправке запроса:', error);
    }
};

const formatDate = (dateString) => {
    const date = new Date(dateString);

    if (isNaN(date)) {
        return 'Неверная дата';
    }

    const options = {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
    };
    return date.toLocaleString('ru-RU', options);
};

const deleteEntry = async (entryId) => {
    try {
        const response = await axios.post(
            '/api/deleteEntry',
            { entryId },
            { withCredentials: true }
        );
        await getEntries();
        console.log('Успешный ответ:', response.data);
    } catch (error) {
        console.error('Ошибка при отправке запроса:', error);
    }
};

const showActive = () => {
    isArchived.value = false;
};

const showArchived = () => {
    isArchived.value = true;
};

onMounted(async () => {
    await getEntries();
});
</script>

<template>
    <div class="space-y-2">
        <div class="flex flex-col items-center justify-center mb-10 mt-10">
            <h1 class="text-2xl mb-5">Управление Виртуальными машинами</h1>
            <div class="shadow-md rounded p-4 w-full flex items-center justify-center mb-5">
                <h3 class="text-gray-700 text-md bg-gray-100 p-2 rounded">Запустить или остановить все машины:</h3>
                <div class="flex">
                    <PlayIcon class="h-12 w-12 text-gray-500 hover:text-blue-500 cursor-pointer" fill="currentColor" />
                    <StopIcon class="h-12 w-12 text-gray-500 hover:text-blue-500 cursor-pointer" fill="currentColor" />
                </div>
            </div>

            <div class="flex flex-col">
                <div class="shadow-md rounded p-4 w-full">
                <h3 class="text-gray-700 text-md bg-gray-100 p-2 rounded mb-2">Запустить или остановить конкретную машину:</h3>
                <div class="flex space-x-2">
                    <SearchSelectBase :options="machines"/>
                    <PlayIcon class="m-l-2 h-10 w-10 text-gray-500 hover:text-blue-500 cursor-pointer" fill="currentColor" />
                    <StopIcon class="h-10 w-10 text-gray-500 hover:text-blue-500 cursor-pointer" fill="currentColor" />
                </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-2xl mb-5">Управление Виртуальными машинами</h1>
    <div class="inline-flex rounded-md shadow-xs mb-2 cursor-pointer">
        <a
            @click="showActive"
            :class="[
        'px-4 py-2 text-sm font-medium border border-gray-200 focus:z-10 focus:ring-2 focus:ring-blue-700 rounded-s-lg',
        !isArchived ? 'text-blue-700 bg-blue-50' : 'text-gray-900 hover:text-blue-700 hover:bg-gray-100',
      ]"
        >
            Активные
        </a>
        <a
            @click="showArchived"
            :class="[
        'px-4 py-2 text-sm font-medium border border-gray-200 focus:z-10 focus:ring-2 focus:ring-blue-700 rounded-e-lg',
        isArchived ? 'text-blue-700 bg-blue-50' : 'text-gray-900 hover:text-blue-700 hover:bg-gray-100',
      ]"
        >
            Архив
        </a>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">Номер</th>
                <th scope="col" class="px-6 py-3">Услуга</th>
                <th scope="col" class="px-6 py-3">Дата создания</th>
                <th v-if="isArchived" scope="col" class="px-6 py-3">Завершён</th>
                <th v-else scope="col" class="px-6 py-3">Действия</th>
            </tr>
            </thead>
            <tbody>
            <template v-if="(isArchived ? deletedEntries.length : entries.length) > 0">
                <tr
                    v-for="entry in isArchived ? deletedEntries : entries"
                    :key="entry.id"
                    class="bg-white border-b border-gray-200"
                >
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ entry.phone }}
                    </th>
                    <td class="px-6 py-4">
                        {{ entry.type }}
                    </td>
                    <td class="px-6 py-4">
                        {{ formatDate(entry.created_at) }}
                    </td>
                    <td class="px-6 py-4">
                        <template v-if="isArchived">
                            {{ formatDate(entry.updated_at) }}
                        </template>
                        <template v-else>
                            <a
                                @click="deleteEntry(entry.id)"
                                class="font-medium text-blue-600 hover:underline cursor-pointer"
                            >
                                Удалить
                            </a>
                        </template>
                    </td>
                </tr>
            </template>
            <tr v-else>
                <td colspan="4" class="text-center py-4">
                    Нет записей для отображения.
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
/* Ваши стили */
</style>
