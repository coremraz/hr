<script setup>
import {computed} from 'vue';

const props = defineProps({
    text: {
        type: String,
        default: "Клик",
    },
    selected: { // Add the 'selected' prop
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['click']); // IMPORTANT:  Emit the click event

const buttonClasses = computed(() => {
    return [
        'font-bold',
        'py-2',
        'px-4',
        'rounded-full',
        'cursor-pointer',
        'transition-colors',  // Add transitions for smoother changes
        'duration-200',       // ...and a duration
        'focus:outline-none', // Remove default focus outline
        'focus:ring-2',       // Add a focus ring
        'focus:ring-blue-500', // ...with a blue color
        'focus:ring-offset-2', // ...and an offset
        props.selected
            ? 'bg-white text-gray-900 border border-gray-900' // Selected styles
            : 'bg-blue-500 text-white hover:bg-blue-700',   // Default (unselected) styles
    ];
});
</script>

<template>
    <button :class="buttonClasses" @click="$emit('click')">
        {{ props.text }}
    </button>
</template>
