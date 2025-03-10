<script setup>
import { ref, watch, computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Number,
        default: 1,
    },
    min: {
        type: Number,
        default: 1,
    },
    max: {
        type: Number,
        default: 30,
    },
    step: {
        type: Number,
        default: 1,
    },
});

const emit = defineEmits(['update:modelValue']);

const inputValue = ref(props.modelValue);

// Обновляем inputValue при изменении modelValue (извне)
watch(() => props.modelValue, (newValue) => {
    inputValue.value = newValue;
});

// Обновляем modelValue при изменении inputValue (внутри компонента)
watch(inputValue, (newValue) => {
    emit('update:modelValue', newValue);
});


// Вычисляем процент заполнения для стилизации
const progressPercent = computed(() => {
    return ((inputValue.value - props.min) / (props.max - props.min)) * 100;
});


</script>

<template>
    <div class="flex items-center space-x-4">
        <div class="relative w-full">
            <input
                id="steps-range"
                type="range"
                :min="min"
                :max="max"
                v-model.number="inputValue"
                :step="step"
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                style="background-image: linear-gradient(to right, #3b82f6 0%, #3b82f6 0%);"
            :style="{ backgroundImage: `linear-gradient(to right, #3b82f6 0%, #3b82f6 ${progressPercent}%, #d1d5db ${progressPercent}%, #d1d5db 100%)` }"
            >

        </div>
        <span class="text-sm text-blue-500 font-bold">{{ inputValue }}</span>
    </div>
</template>

<style scoped>
/* Стили для скрытия стандартного thumb (кружка) */
input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none; /* Для Chrome, Safari, Opera */
    appearance: none;
}

input[type="range"]::-moz-range-thumb {
    width: 0; /* Для Firefox */
    height: 0;
    border: none;
    background: transparent;
}

/* Дополнительные стили (если нужны) */
</style>
