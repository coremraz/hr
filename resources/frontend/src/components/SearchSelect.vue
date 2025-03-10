<template>
    <div class="relative w-64">
        <input
            type="text"
            v-model="searchTerm"
            @focus="openDropdown"
            @input="filterOptions"
            class="w-full py-2 pl-2 pr-4 rounded-lg block appearance-none border border-gray-300 shadow-sm leading-normal sm:text-sm sm:leading-5 focus:outline-none"
            :placeholder="placeholder"
        />
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
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
    fetchUrl: {
        type: String,
        required: true
    },
    modelValue: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'Начните вводить...'
    },
})

const emit = defineEmits(['update:modelValue']) // Define emit for v-model

const dropdownOpen = ref(false)
const searchTerm = ref(props.modelValue) // Initialize searchTerm with modelValue
const allOptions = ref([])
const filteredOptions = ref([])
const loading = ref(false)

watch(() => props.modelValue, (newValue) => {
    searchTerm.value = newValue; // Update searchTerm when modelValue changes from outside
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
    searchTerm.value = option.label // Update searchTerm to show selected label in input
    emit('update:modelValue', option.label) // Emit event to update v-model in parent
    dropdownOpen.value = false
}

function filterOptions() {
    const searchText = searchTerm.value.toLowerCase()
    filteredOptions.value = allOptions.value.filter(option =>
        option.label.toLowerCase().includes(searchText)
    )
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
