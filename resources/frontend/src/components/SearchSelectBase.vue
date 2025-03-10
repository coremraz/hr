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
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    // Вместо fetchUrl передаем массив опций напрямую
    options: {
        type: Array,
        default: () => []
    },
    modelValue: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue'])

const dropdownOpen = ref(false)
const searchTerm = ref(props.modelValue)
const allOptions = ref([])
const filteredOptions = ref([])

// Обновляем searchTerm при изменении modelValue извне
watch(() => props.modelValue, (newValue) => {
    searchTerm.value = newValue;
})

// Сразу при инициализации (и при изменении props.options) задаем все опции
watch(() => props.options, (newOptions) => {
    allOptions.value = newOptions;
    filteredOptions.value = [...newOptions];
}, { immediate: true });

function openDropdown() {
    dropdownOpen.value = true;
}

function selectOption(option) {
    searchTerm.value = option.label;
    emit('update:modelValue', option.label);
    dropdownOpen.value = false;
}

function filterOptions() {
    const searchText = searchTerm.value.toLowerCase();
    filteredOptions.value = allOptions.value.filter(option =>
        option.label.toLowerCase().includes(searchText)
    );
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
