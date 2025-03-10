<template>
    <div class="bg-gray-50 py-24 sm:py-32">
        <div class="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
            <h2 class="text-center text-base/7 font-semibold text-red-800">Автоматический отклик</h2>
            <p class="mx-auto mt-2 max-w-lg text-center text-4xl font-semibold tracking-tight text-balance text-gray-950 sm:text-5xl">Ультимативный способ найти работу</p>
            <div class="mt-10 grid gap-4 sm:mt-16 lg:grid-cols-3 lg:grid-rows-2">
                <div class="relative lg:row-span-2">
                    <div class="absolute inset-px rounded-lg bg-white lg:rounded-l-[2rem]" />
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] lg:rounded-l-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 pb-3 sm:px-10 sm:pt-10 sm:pb-0">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">Эффективность</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">Шансы на трудоустройство увеличиваются в разы</p>
                        </div>
                        <div class="@container relative min-h-[30rem] w-full grow max-lg:mx-auto max-lg:max-w-sm">
                            <div class="absolute inset-x-10 top-10 bottom-0 overflow-hidden rounded-t-[12cqw] border-x-[3cqw] border-t-[3cqw] border-gray-700 bg-white shadow-2xl flex items-center">
                                <img :src="'/images/accepted.png'" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5 lg:rounded-l-[2rem]" />
                </div>
                <div class="relative max-lg:row-start-1">
                    <div class="absolute inset-px rounded-lg bg-white max-lg:rounded-t-[2rem]" />
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-t-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center flex items-center">Экономия времени</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">Зачем тратить часы на отклики и составление писем, когда это время можно потратить на саморазвитие?</p>
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5 max-lg:rounded-t-[2rem]" />
                </div>
                <div class="relative max-lg:row-start-3 lg:col-start-2 lg:row-start-2">
                    <div class="absolute inset-px rounded-lg bg-white" />
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">Безопасность</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">Мы работаем через официальный API hh.ru</p>
                        </div>
                        <div class="@container flex flex-1 items-center max-lg:py-6 lg:pb-2">
                            <img class="h-[min(152px,40cqw)] object-cover" src="https://tailwindui.com/plus/img/component-images/bento-03-security.png" alt="" />
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5" />
                </div>
                <div class="relative lg:row-span-2">
                    <div class="absolute inset-px rounded-lg bg-white max-lg:rounded-b-[2rem] lg:rounded-r-[2rem]" />
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-b-[calc(2rem+1px)] lg:rounded-r-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 pb-3 sm:px-10 sm:pt-10 sm:pb-0">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">Собственная нейросеть</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">Мы используем LLM нейросеть для анализа вакансии, составления сопроводительного письма</p>
                        </div>
                        <div class="relative min-h-[30rem] w-full grow">
                            <div class="absolute top-10 right-0 bottom-0 left-10 overflow-hidden rounded-tl-xl bg-gray-900 shadow-2xl">
                                <div class="flex bg-gray-800/40 ring-1 ring-white/5">
                                    <div class="-mb-px flex text-sm/6 font-medium text-gray-400">
                                        <div class="border-r border-b border-r-white/10 border-b-white/20 bg-white/5 px-4 py-2 text-white">ai.py</div>
                                        <div class="border-r border-gray-600/10 px-4 py-2">app.py</div>
                                    </div>
                                </div>
                                <div class="px-6 pt-6 pb-14 text-gray-500">
                                    import tensorflow as tf
                                    from tensorflow.keras import layers, models
                                    <br>
                                    <br>
                                    model = models.Sequential()
                                    <br>
                                    <br>
                                    model.add(layers.Conv2D(32, (3, 3), activation='relu', input_shape=(64, 64, 3)))
                                    model.add(layers.MaxPooling2D(pool_size=(2, 2)))
                                    <br>
                                    <br>
                                    model.add(layers.Conv2D(64, (3, 3), activation='relu'))
                                    model.add(layers.MaxPooling2D(pool_size=(2, 2)))
                                    <br>
                                    model.add(layers.Conv2D(128, (3, 3), activation='relu'))
                                    model.add(layers.MaxPooling2D(pool_size=(2, 2)))

                                    # Преобразование данных для полносвязного слоя
                                    model.add(layers.Flatten())
                                    model.add(layers.Dense(128, activation='relu'))

                                    # Выходной слой для классификации
                                    model.add(layers.Dense(10, activation='softmax'))

                                    # Компиляция модели
                                    model.compile(optimizer='adam', loss='sparse_categorical_crossentropy', metrics=['accuracy'])

                                    # Обучение модели на данных
                                    # model.fit(train_images, train_labels, epochs=10)
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5 max-lg:rounded-b-[2rem] lg:rounded-r-[2rem]" />
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">

</script>
