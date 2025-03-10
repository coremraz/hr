<template>
    <div class="flex items-center">
        <label :for="id" class="relative flex items-center cursor-pointer">
            <input
                :id="id"
                type="checkbox"
                :checked="modelValue"
                @change="toggleCheckbox"
                class="sr-only peer"
            aria-hidden="true"
            />
            <!-- Контейнер для стилизации -->
            <div
                class="w-4 h-4 bg-gray-100 border border-gray-300 rounded-sm flex items-center justify-center peer-checked:bg-blue-500 peer-checked:border-blue-500"
            >
            <!-- SVG галочки (показываем, когда чекбокс checked) -->
            <svg
                v-if="modelValue"
                class="w-3 h-3 text-white"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="3"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
    </div>
    <!-- Текст чекбокса -->
    <span class="ms-2 text-sm font-medium text-gray-900">{{ label }}</span>
    </label>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        default: 'Checkbox',
    },
    modelValue: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['update:modelValue'])

function toggleCheckbox(event) {
    emit('update:modelValue', event.target.checked)
}
</script>
