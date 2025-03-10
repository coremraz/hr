<script setup>
import PhoneInput from "./phoneInput.vue";
import AuthButton from "../components/Buttons/AuthButton.vue";
import {useStore} from "vuex";
import {computed, ref, watch, onMounted} from "vue";
import PillButton from "./Buttons/PillButton.vue";
import {CreditCardIcon} from "@heroicons/vue/24/solid";
import PolicyModal from "./PolicyModal.vue";
import { CheckCircleIcon } from "@heroicons/vue/20/solid";
import Alert from "./Alert.vue";
import axios from "axios";

const policyAgree = ref(false)
const policyModal = ref(false)
const phoneAlert = ref(false)
const type = ref("Улучшение резюме")

const step = ref(0);
const parentPhone = ref('');

const addEntry = async () => {
    try {
        const response = await axios.post(
            '/api/addEntry',
            {
                phone: parentPhone.value,
                type: type.value,
            },
            {
                withCredentials: true
            }
        );
        console.log('Успешный ответ:', response.data);
    } catch (error) {
        console.error('Ошибка при отправке запроса:', error);
    }
}


const handleAgreePolicy = () => {
    policyAgree.value = true;
}

const handleDisagreePolicy = () => {
    policyAgree.value = false;
    policyModal.value = false;
}

const handlePhoneChange = (newPhoneValue) => {
    parentPhone.value = newPhoneValue;
    console.log('Значение phone в родительском компоненте:', parentPhone.value);
};
const nextStep = () => {
    phoneAlert.value = false;

    if (parentPhone.value.length !== 10) {
        phoneAlert.value = true;
        return;
    }

    if (policyAgree.value) {
        step.value++;
        policyModal.value = false;
    } else {
        policyModal.value = true;
    }

    addEntry()
}

const store = useStore();
const isAuthenticated = computed(() => store.getters.isAuthenticated);
const user = computed(() => store.getters.getUser);

// Watch for changes in isAuthenticated and user to set parentPhone
watch(
    () => [isAuthenticated.value, user.value],
    ([newIsAuthenticated, newUser]) => {
        if (newIsAuthenticated && newUser && newUser.phone) {
            parentPhone.value = newUser.phone.slice(1);
        } else if (!newIsAuthenticated) {
            parentPhone.value = ''; // Reset parentPhone if user logs out, optional
        }
    },
    { immediate: true } // Run the watcher immediately on component creation
);


</script>

<template>
    <alert v-if="phoneAlert"
           :message="'Проверьте правильность номера'"
           @closed="phoneAlert = false">
    </alert>
    <div
        class="relative flex items-center justify-center flex-col min-w-[350px] min-h-[350px] my-6 bg-white shadow-sm border border-slate-200 rounded-lg sm:min-w-[500px]">
        <div class="absolute flex justify-center items-center w-full" style="top:1%">
            <div class="mb-4 flex border-slate-200 pt-3 pb-2 min-w-[250px] sm:min-w-[400px]">
                <ol class="flex items-center justify-between w-full">
                    <li v-if="step === 1 || step === 2 || step === 3"
                        class="flex w-full items-center text-blue-600 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block">
            <span class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                <svg class="w-3.5 h-3.5 text-blue-600 lg:w-4 lg:h-4" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 5.917 5.724 10.5 15 1.5"></path>
                </svg>
            </span>
                    </li>

                    <li v-else
                        class="flex w-full items-center text-blue-600 after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block">
                        <span
                            class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
    <svg class="w-4 h-4 text-gray-500 lg:w-5 lg:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
         fill="currentColor" viewBox="0 0 20 16">
                    <path
                        d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"></path>
                </svg>
            </span>
                    </li>

                    <li v-if="step === 0 || step === 1"
                        class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block">
            <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                <CreditCardIcon class="h-7 w-7 text-gray-500"/>
            </span>
                    </li>

                    <li v-else
                        class="flex w-full items-center text-blue-600 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block">
        <span class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                <svg class="w-3.5 h-3.5 text-blue-600 lg:w-4 lg:h-4" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 5.917 5.724 10.5 15 1.5"></path>
                </svg>
            </span>
                    </li>
                    <span v-if="step === 2"
                          class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                <svg class="w-3.5 h-3.5 text-blue-600 lg:w-4 lg:h-4" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 5.917 5.724 10.5 15 1.5"></path>
                </svg>
            </span>
                    <span v-else
                          class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                <svg class="w-4 h-4 text-gray-500 lg:w-5 lg:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 18 20">
                    <path
                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"></path>
                </svg>
            </span>

                </ol>
            </div>
        </div>
        <div v-if="!isAuthenticated && step === 0"
             class="max-w-5xl mt-10 min-w-[300px] flex flex-col justify-center items-center sm:min-w-[500px]">
            <phone-input @update:phone="handlePhoneChange"/>
            <div class="min-w-[300px] mt-4 mb-4 sm:min-w-[500px]">
            <span class="relative flex justify-center mt-2">
            <div
                class="absolute m inset-x-0 top-1/2 h-px -translate-y-1/2 bg-transparent bg-gradient-to-r from-transparent via-gray-500 to-transparent opacity-75"
            ></div>
            <span class="relative z-10 bg-white px-6">Или</span>
            </span>
            </div>
            <AuthButton :text="'Войти через hh.ru'"></AuthButton>
            <PillButton v-if="parentPhone.length === 10" class="mt-3" @click="nextStep" :text="'Продолжить'"/>
        </div>

        <div v-if="isAuthenticated && step === 0"
             class="max-w-5xl mt-12 min-w-[300px] flex flex-col justify-center items-center sm:min-w-[500px]">
            <span>{{ user.name }}, ваш номер <span class="text-indigo-500">{{ user.phone }}</span>?</span>
            <div class="min-w-[300px] mt-4 mb-4 sm:min-w-[500px]">
            <span class="relative flex justify-center mt-2">
            <div
                class="absolute m inset-x-0 top-1/2 h-px -translate-y-1/2 bg-transparent bg-gradient-to-r from-transparent via-gray-500 to-transparent opacity-75"
            ></div>
            <span class="relative z-10 bg-white px-6">Или</span>
            </span>
            </div>
            <phone-input @update:phone="handlePhoneChange"/>
            <PillButton class="mt-6" @click="nextStep" :text="'Продолжить'"/>
        </div>

        <policy-modal
            v-if="policyModal"
            @agree="handleAgreePolicy"
            @disAgree="handleDisagreePolicy"
        ></policy-modal>

        <div v-if="step === 1" class="flex flex-col">
            <span class="text-3xl mb-10">Сумма к оплате: <span class="font-bold text-indigo-600">4999</span>₽</span>
            <button @click="nextStep" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Оплатить через Юкассу
            </button>
        </div>


        <div v-if="step === 2" class="flex flex-col items-center">
            <CheckCircleIcon class="mt-5 h-24 w-24 text-green-500"/>
            <span class="text-3xl font-bold mt-2">Успешно!</span>
            <span class="text-xl text-gray-400 mt-1">Скоро с вами свяжемся</span>
        </div>

    </div>

</template>

<style scoped>

</style>
