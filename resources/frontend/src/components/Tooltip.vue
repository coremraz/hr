<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { CursorArrowRippleIcon } from "@heroicons/vue/24/outline";


// Принимаем текст для кнопки и tooltip через props
const { buttonText, tooltipText } = defineProps({
    buttonText: {
        type: String,
        default: 'Default tooltip'
    },
    tooltipText: {
        type: String,
        default: 'Tooltip content'
    }
})

// Реф для контейнера компонента (нужен для определения клика вне компонента)
const containerRef = ref(null)

// Флаг видимости tooltip
const isTooltipVisible = ref(false)

// Функции управления tooltip
function showTooltip() {
    isTooltipVisible.value = true
}

function hideTooltip() {
    isTooltipVisible.value = false
}

function toggleTooltip() {
    isTooltipVisible.value = !isTooltipVisible.value
}

// Обработчик кликов вне компонента для закрытия tooltip на мобильных устройствах
function handleClickOutside(event) {
    if (containerRef.value && !containerRef.value.contains(event.target)) {
        hideTooltip()
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
    <div ref="containerRef" class="relative inline-block">
        <!-- Кнопка-триггер tooltip -->
        <button
            type="button"
            class="text-blue-500 underline cursor-pointer text-sm flex hover:font-bold"
            @mouseenter="showTooltip"
            @mouseleave="hideTooltip"
            @click.stop="toggleTooltip"
        >
            {{ buttonText }}
            <CursorArrowRippleIcon class="h-5 w-5 text-blue-500 hover:font-bold" />
        </button>

        <!-- Tooltip, расположенный сверху кнопки -->
        <div
            id="tooltip-no-arrow"
            role="tooltip"
            class="absolute z-9999 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs dark:bg-gray-700 transition-opacity duration-300 sm:w-64"
            :class="{ 'opacity-0 invisible': !isTooltipVisible, 'opacity-100 visible': isTooltipVisible }"
            style="bottom: 100%; left: 50%; transform: translateX(-50%); margin-bottom: 8px;"
        >
            {{ tooltipText }}
        </div>
    </div>
</template>

<style scoped>
/* Дополнительные стили можно добавить при необходимости */
</style>
