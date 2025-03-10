<script setup>
import {ChevronDownIcon} from "@heroicons/vue/16/solid/index.js";
import {computed, ref, defineEmits} from 'vue'; // Добавлен ref

const phone = ref(''); // Используем ref для реактивности

const emit = defineEmits(['update:phone']);
const onPhoneChange = () => {
    emit('update:phone', phone.value)
}

const props = defineProps({
    name: {
        type: String,
        default: "Телефон",
    },
    code: {
        type: String,
        default: "+7",
    },
    placeholder: {
        type: String,
        default: "(999)-888-77-66",
    },
});

// Условие исправлено: красный, если длина не 0 и не 10
const phoneClass = computed(() => {
    return phone.value.length !== 0 && phone.value.length !== 10
        ? 'outline-red-500'
        : 'outline-gray-300';
});
</script>

<template>
    <div class="flex flex-col items-center">
        <label v-if="phoneClass === 'outline-red-500'" class="text-red-300 block text-sm/6 font-medium">номер должен состоять из 10 цифр</label>
        <label v-else for="price" class="block text-sm/6 font-medium text-gray-900">{{ name }}</label>
        <div>
            <div
                class="flex items-center max-w-[170px] mt-2 rounded-md bg-white pl-3 outline outline-1 outline-offset-2"
                :class="phoneClass">
                <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6">{{ code }}</div>
                <input v-model="phone" @input="onPhoneChange" type="tel" name="price" id="price"
                       class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                       :placeholder="placeholder"/>
                <div class="grid shrink-0 grid-cols-1 focus-within:relative">
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Обновлены стили для outline */
.outline-red-500 {
    outline-color: #ef4444; /* Цвет для red-500 */
}

.outline-gray-300 {
    outline-color: #d1d5db; /* Цвет для gray-300 */
}
</style>
