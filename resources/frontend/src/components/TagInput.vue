<template>
    <div class="relative">
        <!-- Поле ввода для тегов -->
        <input
            type="text"
            v-model="inputValue"
            @keydown="handleKeyDown"
            placeholder="Введите слово и нажмите Enter или ,"
            class="w-full py-2 pl-2 pr-4 rounded-lg block appearance-none border border-gray-300 shadow-sm leading-normal sm:text-sm sm:leading-5 focus:outline-none"
        />

        <!-- Блок для отображения выбранных тегов -->
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
                    &times;
                </button>
            </span>
        </div>
    </div>
</template>

<script setup>
import { watch, ref, defineEmits, defineProps, onMounted } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue'])

const inputValue = ref('')
const selectedOptions = ref([])

// Инициализация при монтировании
onMounted(() => {
    updateSelectedOptions(props.modelValue)
})

// Следим за изменениями modelValue извне
watch(() => props.modelValue, (newValue) => {
    updateSelectedOptions(newValue)
})

// Обновление списка тегов при изменении входного значения
function updateSelectedOptions(value) {
    selectedOptions.value = value
        ? value.split(', ')
            .map(tag => ({ value: tag.trim(), label: tag.trim() }))
            .filter(tag => tag.label !== '')
        : []
}

// Обновление модели при изменении тегов
function updateModel() {
    const tagsString = selectedOptions.value.map(opt => opt.label).join(', ')
    emit('update:modelValue', tagsString)
}

// Добавление нового тега
function addTag() {
    const tag = inputValue.value.trim()
    if (tag && !selectedOptions.value.some(option =>
        option.label.toLowerCase() === tag.toLowerCase()
    )) {
        selectedOptions.value.push({
            value: tag,
            label: tag
        })
        inputValue.value = ''
        updateModel()
    }
}

// Обработчик клавиш
function handleKeyDown(event) {
    if (event.key === 'Enter' || event.key === ',') {
        event.preventDefault()
        addTag()
    }
}

// Удаление тега
function removeOption(option) {
    selectedOptions.value = selectedOptions.value.filter(o => o.value !== option.value)
    updateModel()
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
