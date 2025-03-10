<template>
    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0" style="background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(10px);" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <DialogTitle as="h3" class="text-base font-semibold text-gray-900">Соглашение о обработке данных</DialogTitle>
                                        <div class="mt-2">
                                            <div class="text-sm text-gray-500 max-h-96 overflow-y-auto pr-4">
                                                <h1>Соглашение о обработке данных</h1>

                                                <h2>1. Стороны соглашения</h2>
                                                <p>Настоящее Соглашение о обработке данных (далее – <strong>"Соглашение"</strong>) заключено между:</p>

                                                <p><strong>[Название компании]</strong>, зарегистрированной по адресу: [адрес компании], в лице [должность, ФИО представителя], действующего на основании [документ, подтверждающий полномочия] (далее – <strong>"Оператор"</strong>),</p>

                                                <p>и</p>

                                                <p><strong>[ФИО или название субъекта данных]</strong>, зарегистрированным по адресу: [адрес субъекта данных] (далее – <strong>"Субъект данных"</strong>).</p>

                                                <h2>2. Цели обработки данных</h2>
                                                <p>Оператор обязуется обрабатывать персональные данные Субъекта данных для следующих целей:</p>
                                                <ul>
                                                    <li>[Указать цели, например: предоставление услуг, выполнение обязательств по договору, маркетинговые исследования и т.д.]</li>
                                                </ul>

                                                <h2>3. Типы обрабатываемых данных</h2>
                                                <p>Оператор обрабатывает следующие категории персональных данных:</p>
                                                <ul>
                                                    <li>[Указать типы данных, например: ФИО, контактные данные, дата рождения и т.д.]</li>
                                                </ul>

                                                <h2>4. Права Субъекта данных</h2>
                                                <p>Субъект данных имеет право:</p>
                                                <ul>
                                                    <li>Запрашивать доступ к своим персональным данным.</li>
                                                    <li>Требовать исправления неточных данных.</li>
                                                    <li>Запрашивать удаление своих данных.</li>
                                                    <li>Ограничивать обработку своих данных.</li>
                                                    <li>Отзывать согласие на обработку данных в любое время.</li>
                                                </ul>

                                                <h2>5. Условия обработки данных</h2>
                                                <p>Оператор обязуется:</p>
                                                <ul>
                                                    <li>Обрабатывать персональные данные в соответствии с действующим законодательством.</li>
                                                    <li>Обеспечивать безопасность персональных данных.</li>
                                                    <li>Не передавать персональные данные третьим лицам без согласия Субъекта данных, за исключением случаев, предусмотренных законом.</li>
                                                </ul>

                                                <h2>6. Срок хранения данных</h2>
                                                <p>Персональные данные будут храниться в течение [указать срок хранения] или до тех пор, пока это необходимо для достижения целей обработки.</p>

                                                <h2>7. Заключительные положения</h2>
                                                <p>Настоящее Соглашение вступает в силу с момента его подписания и действует до полного выполнения обязательств сторонами.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button"  class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto" @click="handleAgree">Согласен</button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="handleDisagree"  ref="cancelButtonRef">Отмена</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const open = ref(true)

// Объявляем эмиттер
const emit = defineEmits(['agree'])

// Функция для обработки согласия
const handleAgree = () => {
    open.value = false
    emit('agree')
}

const handleDisagree = () => {
    open.value = false
    emit('disAgree')
}
</script>
