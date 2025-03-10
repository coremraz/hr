<!-- Textarea.vue (if you create a component) -->
<template>
      <textarea
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          :rows="rows"
          :placeholder="placeholder"
          class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
      ></textarea>
</template>

<script setup>
defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    rows: {
        type: Number,
        default: 4,
    },
    placeholder: {
        type: String,
        default: '',
    },
});

defineEmits(['update:modelValue']);
</script>
