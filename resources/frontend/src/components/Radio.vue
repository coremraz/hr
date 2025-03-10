<template>
    <div :class="['flex items-center', wrapperClass]">
        <label :for="uuid" class="relative flex items-center cursor-pointer">
            <input
                :id="uuid"
                type="radio"
                :value="value"
                :name="name"
                :checked="modelValue === value"
                @change="$emit('update:modelValue', value)"
                class="sr-only peer"
            />
            <!-- Контейнер для стилизации (внешний круг) -->
            <div
                class="w-5 h-5 border border-gray-300 rounded-full flex items-center justify-center peer-checked:border-blue-500"
            >
                <!-- Внутренний круг (точка) -->
                <div
                    class="w-2 h-2 rounded-full bg-blue-500 peer-checked:bg-blue-500"
                    :class="{ 'scale-0': modelValue !== value, 'transition-transform duration-200': true }"
                ></div>
            </div>
            <!-- Текст -->
            <span class="ms-2 text-sm font-medium text-gray-900">{{ label }}</span>
        </label>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean],
        default: '',
    },
    value: {
        type: [String, Number, Boolean],
        required: true,
    },
    label: {
        type: String,
        default: '',
    },
    name: {
        type: String,
        required: true,
    },
    wrapperClass: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

// Генерируем уникальный ID для связки input-label
const uuid = ref(`radio-${Math.random().toString(36).slice(2, 11)}`)
</script>
