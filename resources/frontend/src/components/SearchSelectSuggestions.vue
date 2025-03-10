<template>
    <div class="relative w-64">
        <!-- Интегрированное поле ввода для поиска/выбора -->
        <input
            type="text"
            v-model="searchTerm"
            @focus="openDropdown"
            placeholder="Начните вводить..."
            class="w-full py-2 pl-2 pr-4 rounded-lg block appearance-none border border-gray-300 shadow-sm leading-normal sm:text-sm sm:leading-5 focus:outline-none"
        />
        <!-- Выпадающий список с плавным появлением -->
        <transition name="fade">
            <div
                v-if="dropdownOpen && options.length > 0"
                class="absolute left-0 right-0 mt-1 border border-gray-300 bg-white rounded shadow-lg z-10"
            >
                <div class="max-h-60 overflow-y-auto">
                    <div
                        v-for="option in options"
                        :key="option.value"
                        @click="selectOption(option)"
                        class="p-2 hover:bg-gray-100 cursor-pointer"
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
import {ref, onMounted, onBeforeUnmount, watch} from 'vue'
import axios from 'axios'

// Принимаем пропсы: fetchUrl - адрес API для получения опций,
// queryParam - имя параметра запроса (по умолчанию 'q')
const props = defineProps({
    fetchUrl: {
        type: String,
        required: true
    },
    queryParam: {
        type: String,
        default: 'text'
    },
    modelValue: { // Добавляем prop для v-model
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue']) // Добавляем emit для v-model

// Состояния компонента
const dropdownOpen = ref(false)
const searchTerm = ref(props.modelValue) // Инициализируем searchTerm из modelValue
const options = ref([])       // Опции, полученные от API
const loading = ref(false)
const selectedOption = ref(null)

watch(() => props.modelValue, (newValue) => {
    searchTerm.value = newValue; // Обновляем searchTerm, когда modelValue меняется извне
})

// Открытие выпадающего списка и первоначальная загрузка опций
function openDropdown() {
    dropdownOpen.value = true
    loadOptions()
}

// Выбор опции из списка: устанавливаем выбранное значение и закрываем список
function selectOption(option) {
    selectedOption.value = option
    searchTerm.value = option.label
    emit('update:modelValue', option.label) // Испускаем событие для обновления v-model
    dropdownOpen.value = false; // Закрываем дропдаун сразу после выбора
    options.value = []; // Очищаем опции
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
            params: {[props.queryParam]: searchTerm.value}
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
