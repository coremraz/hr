<template>
    <div class="relative w-64">
        <input
            type="text"
            v-model="searchTerm"
            @focus="openDropdown"
            @input="filterOptions"
            placeholder="Начните вводить..."
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

        <transition name="fade">
            <div
                v-if="dropdownOpen && filteredOptions.length > 0"
                class="absolute left-0 right-0 mt-1 border border-gray-300 bg-white rounded shadow-lg z-10"
            >
                <div class="max-h-60 overflow-y-auto">
                    <div
                        v-for="option in filteredOptions"
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
import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    fetchUrl: {
        type: String,
        required: true
    },
    modelValue: { // v-model для выбранных значений
        type: Array,
        default: () => []
    },
    queryParam: {
        type: String, // Not used in this version as we load all data upfront
        default: 'text'
    }
})

const emit = defineEmits(['update:modelValue'])

const dropdownOpen = ref(false)
const searchTerm = ref('')
const allOptions = ref([])
const filteredOptions = ref([])
const loading = ref(false)

// Используем computed для синхронизации с v-model
const selectedOptions = ref(props.modelValue)

watch(() => props.modelValue, (newValue) => {
    selectedOptions.value = newValue;
})

// Загрузка данных при монтировании
onMounted(async () => {
    try {
        loading.value = true
        const response = await axios.get(props.fetchUrl)

        // Преобразование структуры данных
        allOptions.value = response.data.flatMap(category => [
            {
                value: category.id,
                label: category.name,
                type: 'category'
            },
            ...category.industries.map(industry => ({
                value: industry.id,
                label: industry.name,
                type: 'industry',
                parentId: category.id
            }))
        ])

        filteredOptions.value = [...allOptions.value]
    } catch (error) {
        console.error('Ошибка загрузки данных:', error)
    } finally {
        loading.value = false
    }
})

function openDropdown() {
    dropdownOpen.value = true
}

function selectOption(option) {
    if (!isSelected(option)) {
        selectedOptions.value = [...selectedOptions.value, option];
        emit('update:modelValue', selectedOptions.value); // Обновляем v-model
    }
    searchTerm.value = ''; // Очищаем поле ввода после выбора, чтобы начать новый поиск
    filterOptions(); // Обновляем filteredOptions с пустым searchTerm, чтобы показать все опции или можно скрыть дропдаун: dropdownOpen.value = false;
}

function removeOption(option) {
    selectedOptions.value = selectedOptions.value.filter(selected => selected.value !== option.value);
    emit('update:modelValue', selectedOptions.value); // Обновляем v-model
}

function filterOptions() {
    const searchText = searchTerm.value.toLowerCase()
    filteredOptions.value = allOptions.value.filter(option =>
        option.label.toLowerCase().includes(searchText)
    )
}

function isSelected(option) {
    return selectedOptions.value.some(selected => selected.value === option.value);
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
