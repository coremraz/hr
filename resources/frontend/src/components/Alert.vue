<script setup>
import { BellAlertIcon, XMarkIcon } from "@heroicons/vue/20/solid";
import { ref, onMounted, onBeforeUnmount } from 'vue';

const isVisible = ref(false);
let timeoutId = null;

const emit = defineEmits(['close', 'closed']);

const props = defineProps({
    message: {
        type: String,
        required: true,
        default: 'Стандартное сообщение алерта'
    },
    autoCloseDelay: {
        type: Number,
        default: 5000
    }
});

onMounted(() => {
    isVisible.value = true;

    timeoutId = setTimeout(() => {
        closeAlert();
    }, props.autoCloseDelay);
});

onBeforeUnmount(() => {
    clearTimeout(timeoutId);
});

const closeAlert = () => {
    isVisible.value = false;
    clearTimeout(timeoutId);
    emit('close');
};

</script>

<template>
    <Transition name="fade" @after-leave="$emit('closed')">
        <div v-if="isVisible" role="alert"
             class="mt-3 min-w-[200px] max-w-[350px] w-full blured fixed top-4 right-4 z-9999 flex flex-col p-4 text-sm text-white rounded-md shadow-lg">

            <div class="flex items-center">
                <BellAlertIcon class="h-8 w-8 text-yellow-500"/>
                <p class="ml-4 p-2 text-lg text-gray-600 font-bold">
                    {{ message }}
                </p>
            </div>

            <button @click="closeAlert"
                    class="flex cursor-pointer items-center justify-center transition-all w-8 h-8 rounded-md text-white hover:bg-white/10 active:bg-white/10 absolute top-1.5 right-1.5"
                    type="button">
                <XMarkIcon class="h-6 w-6 text-gray-800 hover:text-red-500"/>
            </button>
        </div>
    </Transition>
</template>

<style>

.blured {

    background-color: rgba(255, 255, 255, 0.8);

    backdrop-filter: blur(10px);

}

.fade-enter-active {
    animation: fade-in 0.3s;
}
.fade-leave-active {
    animation: fade-out 0.3s;
}

@keyframes fade-in {
    from { opacity: 0 }
    to { opacity: 1 }
}

@keyframes fade-out {
    from { opacity: 1 }
    to { opacity: 0 }
}

</style>
