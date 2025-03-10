<template>
    <div class="relative w-64">

        <!-- Интегрированное поле ввода для поиска/выбора -->
        <input
            type="text"
            v-model="searchTerm"
            @focus="openDropdown"
            :placeholder="placeholder"
            class="w-full py-2 pl-2 pr-4 rounded-lg block appearance-none border border-gray-300 shadow-sm leading-normal sm:text-sm sm:leading-5 focus:outline-none"
        />

        <!-- Блок для отображения выбранных опций -->
        <div class="flex flex-wrap gap-1 mb-1 mt-2">
            <span
                v-for="option in selectedOptions"
                :key="option.value"
                class="bg-blue-100 text-blue-800 px-2 py-1 rounded flex items-center"
            >
                {{ option.label }}
                <button
                    type="button"
                    @click="removeOption(option)"
                    class="ml-1 text-blue-500 hover:text-blue-700 focus:outline-none"
                >
                    ×
                </button>
            </span>
        </div>

        <!-- Выпадающий список с плавным появлением -->
        <transition name="fade">
            <div
                v-if="dropdownOpen && (options.length > 0 || loading)"
                class="absolute left-0 right-0 mt-1 border border-gray-300 bg-white rounded shadow-lg z-10"
            >
                <div class="max-h-60 overflow-y-auto">
                    <div
                        v-for="option in options"
                        :key="option.value"
                        @click="selectOption(option)"
                        class="p-2 hover:bg-gray-100 cursor-pointer"
                        :class="{ 'bg-gray-200': isSelected(option) }"
                    >
                        {{ option.label }}
                    </div>
                    <div v-if="loading" class="p-2 text-center text-gray-500">
                        Загрузка...
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue'
import axios from 'axios'

// Принимаем пропсы: fetchUrl - адрес API для получения опций,
// queryParam - имя параметра запроса (по умолчанию 'text')
const props = defineProps({
    fetchUrl: {
        type: String,
        required: true
    },
    queryParam: {
        type: String,
        default: 'text'
    },
    modelValue: { // v-model для выбранных значений
        type: Array,
        default: () => []
    },
    placeholder: {
        type: String,
        default: 'Начните вводить...'
    },
})

const emit = defineEmits(['update:modelValue'])

// Состояния компонента
const dropdownOpen = ref(false)
const searchTerm = ref('')
const options = ref([])       // Опции, полученные от API
const loading = ref(false)
const selectedOptions = ref(props.modelValue) // Массив выбранных опций, синхронизированный с v-model

watch(() => props.modelValue, (newValue) => {
    selectedOptions.value = newValue; // Синхронизация при изменении v-model извне
})

// Открытие выпадающего списка и первоначальная загрузка опций
function openDropdown() {
    dropdownOpen.value = true
    loadOptions()
}

// Выбор опции из списка: если опция ещё не выбрана, добавляем её в массив
function selectOption(option) {
    const exists = selectedOptions.value.find(selected => selected.value === option.value)
    if (!exists) {
        selectedOptions.value = [...selectedOptions.value, option];
        emit('update:modelValue', selectedOptions.value); // Обновляем v-model
    }
    // Очищаем поле ввода для возможности ввода следующего запроса
    searchTerm.value = '';

    nextTick(() => {
        dropdownOpen.value = false; // Закрываем дропдаун через nextTick
        options.value = []; // Очищаем опции
    });
}

// Удаление выбранной опции
function removeOption(option) {
    selectedOptions.value = selectedOptions.value.filter(
        selected => selected.value !== option.value
    )
    emit('update:modelValue', selectedOptions.value); // Обновляем v-model
}

// Функция для загрузки опций через axios GET-запрос по переданному URL
function loadOptions() {
    // Если значение инпута пустое, очищаем опции
    if (!searchTerm.value) {
        options.value = []
        return
    }
    loading.value = true
    axios
        .get(props.fetchUrl, {
            params: { [props.queryParam]: searchTerm.value }
        })
        .then(response => {
            // Преобразуем ответ API в формат [{ value, label }, ...]
            // Предполагается, что response.data имеет структуру:
            // { items: [ { text: 'Программист' }, { text: 'Программист 1с' }, ... ] }
            options.value = response.data.items.map((item, index) => ({
                value: index,
                label: item.text
            }))
            loading.value = false
        })
        .catch(error => {
            console.error('Ошибка загрузки опций:', error)
            loading.value = false
        })
}

function isSelected(option) {
    return selectedOptions.value.some(selected => selected.value === option.value);
}


// Debounce‑логика для запроса при изменении значения инпута
let debounceTimeout = null
watch(searchTerm, () => {
    if (!dropdownOpen.value) return
    if (debounceTimeout) clearTimeout(debounceTimeout)
    debounceTimeout = setTimeout(() => {
        loadOptions()
    }, 300)
})

// Закрытие выпадающего списка при клике вне компонента
function handleClickOutside(event) {
    if (!event.target.closest('.relative')) {
        dropdownOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
/* Плавное появление/исчезновение выпадающего списка */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
