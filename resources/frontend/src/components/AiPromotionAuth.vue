<script setup>
import { computed, ref, watch } from 'vue';
import { useStore } from 'vuex';
import { CheckCircleIcon, CreditCardIcon } from '@heroicons/vue/24/solid';

import AuthButton from '../components/Buttons/AuthButton.vue';
import PillButton from './Buttons/PillButton.vue';
import PolicyModal from './PolicyModal.vue';
import Alert from './Alert.vue';
import SearchSelect from './SearchSelect.vue';
import Checkbox from './Checkbox.vue';
import TagInput from './TagInput.vue';
import SearchMultipleSelectSuggestions from './SearchMultipleSelectSuggestions.vue';
import SearchSelectSuggestions from './SearchSelectSuggestions.vue';
import InputText from './InputText.vue';
import Radio from "./Radio.vue";
import Textarea from './Textarea.vue';
import RangeInput from "./RangeInput.vue";
import ListSkeleton from "./ListSkeleton.vue";
import Tooltip from "./Tooltip.vue";
import axios from "axios";

const policyAgree = ref(false);
const policyModal = ref(false);
const vacancyAlert = ref(false);
const step = ref(0);

const store = useStore();
const isAuthenticated = computed(() => store.getters.isAuthenticated);
const user = computed(() => store.getters.getUser);

const jobSearchConfig = ref({
    job_title: null,
    keywords: null,
    search_field: {
        name: false,
        company_name: true,
        description: true,
    },
    words_to_exclude: [],
    professional_role: [],
    industry: [],
    area: [],
    districts: null,
    metro: null,
    salary: null,
    only_with_salary: false,
    currency: {
        RUR: true,
        EUR: false,
        USD: false,
    },
    education: {
        not_needed: true,
        middle: false,
        higher: false,
    },
    experience: {
        doesntMatter: false,
        noExperience: false,
        between1And3: false,
        between3And6: false,
        moreThan6: false,
    },
    selectedExperience: null,
    employment: {
        full: true,
        part: true,
        project: false,
        volunteer: false,
        probation: false,
    },
    schedule: {
        fullDay: true,
        shift: false,
        flexible: false,
        remote: true,
        flyInFlyOut: false,
    },
    part_time: {
        project: true,
        part: true,
        from_four_to_six_hours_in_a_day: false,
        only_saturday_and_sunday: false,
        start_after_sixteen: false,
    },
    vacancy_label: {
        with_address: true,
        accept_handicapped: false,
        not_from_agency: false,
        accept_kids: false,
        accredited_it: true,
        low_performance: false,
    },
    order_by: {
        relevance: true,
        publication_time: false,
        salary_desc: false,
        salary_asc: false,
    },
    selectedOrderBy: 'relevance',
    period: {
        all_time: false,
        month: true,
        week: false,
        three_days: false,
        one_day: false,
    },
    selectedPeriod: 'month',
    job_blacklist: null,
    cover_letter: null,
    apply_once_at_company: true,
    skip_companies_with_test: false,
    max_applies_num: 100,
    number_of_days: 15,
});

const test = () => {
    console.log(jobSearchConfig.value);
};

const sendSearch = async () => {
    try {
        const response = await axios.post('/api/handleSearch', jobSearchConfig.value, {
            headers: {
                'Content-Type': 'application/json'
            },
        });
        console.log('Ответ от сервера:', response.data);
    } catch (error) {
        console.error('Ошибка при отправке поиска:', error.response ? error.response.data : error.message);
    }
};

const handleAgreePolicy = () => {
    policyAgree.value = true;
    policyModal.value = false;
};

const handleDisagreePolicy = () => {
    policyAgree.value = false;
    policyModal.value = false;
};

const nextStep = () => {
    console.log(jobSearchConfig.value.job_title);

    if (!jobSearchConfig.value.job_title) {
        vacancyAlert.value = true;
        return;
    }

    vacancyAlert.value = false;

    if (policyAgree.value) {
        step.value++;
        console.log(step.value)
        if (step.value >= 2) {
            sendSearch();
        }
    } else {
        policyModal.value = true;
    }
};

const stepIndicator = (stepCompleted, icon, completedIcon) => {
    return {
        class: [
            'flex w-full items-center',
            stepCompleted ? 'text-blue-600 after:border-blue-100' : 'after:border-gray-100',
            "after:content-[''] after:w-full after:h-1 after:border-b after:border-4 after:inline-block",
        ],
        iconClass: [
            stepCompleted ? 'w-3.5 h-3.5 text-blue-600 lg:w-4 lg:h-4' : 'w-4 h-4 text-gray-500 lg:w-5 lg:h-5',
        ],
        icon: stepCompleted ? completedIcon : icon,
        bgClass: stepCompleted ? 'bg-blue-100' : 'bg-gray-100',
    };
};

// Watcher for experience
watch(() => jobSearchConfig.value.selectedExperience, (newValue) => {
    if (newValue) {
        for (const key in jobSearchConfig.value.experience) {
            jobSearchConfig.value.experience[key] = (key === newValue);
        }
    }
});

// Watcher for order_by
watch(() => jobSearchConfig.value.selectedOrderBy, (newValue) => {
    if (newValue) {
        for (const key in jobSearchConfig.value.order_by) {
            jobSearchConfig.value.order_by[key] = (key === newValue);
        }
    }
});

// Watcher for period
watch(() => jobSearchConfig.value.selectedPeriod, (newValue) => {
    if (newValue) {
        for (const key in jobSearchConfig.value.period) {
            jobSearchConfig.value.period[key] = (key === newValue);
        }
    }
});

// Function to handle currency button clicks
const handleCurrencyClick = (selectedCurrency) => {
    for (const key in jobSearchConfig.value.currency) {
        jobSearchConfig.value.currency[key] = (key === selectedCurrency);
    }
};
</script>

<template>
    <Alert v-if="vacancyAlert" :message="'Укажите название вакансии'" @closed="vacancyAlert = false" />

    <div
        class="relative flex items-center justify-center flex-col min-w-[350px] min-h-[350px] my-6 bg-white shadow-sm border border-slate-200 rounded-lg sm:min-w-[500px]">
        <!-- Step Indicators -->
        <div v-if="isAuthenticated && step === 0"class="absolute flex flex-col justify-center items-center w-full" style="top:1%">
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

                    <li v-if="isAuthenticated && step === 0 || step === 1"
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
                    <span v-if="isAuthenticated && step === 2"
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

            <span v-if="isAuthenticated && step === 0" class="mt-3 text-center text-2xl font-semibold">
        <span class="text-indigo-500">{{ user.name }}</span>, уточните детали поиска
      </span>
        </div>

        <!-- Step Content -->
        <div
            v-if="!isAuthenticated && step === 0"
            class="mt-10 flex min-w-[200px] flex-col items-center justify-center sm:max-w-[300px]"
        >
            <div class="relative w-full h-30">
                <!-- Common Centering Container -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <ListSkeleton class="absolute z-0 blur-xs"/>
                    <AuthButton :text="'Войти через hh.ru'" class="z-999" />
                </div>
            </div>
        </div>


        <div
            v-if="isAuthenticated && step === 0"
            class="mx-auto mt-44 w-full max-w-2xl flex-col items-center justify-center sm:px-0"
        >

            <div class="flex w-full w flex-col space-y-6 p-6">
                <!-- Job Title -->
                <div>
                    <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="job-title"
                    >Вакансия <span class="text-red-500 font-bold">*</span></label
                    >
                    <SearchSelectSuggestions
                        id="job-title"
                        class="w-full"
                        v-model="jobSearchConfig.job_title"
                        :fetch-url="'https://api.hh.ru/suggests/resume_search_keyword'"
                    />
                </div>

                <!-- Search Fields -->
                <div>
                     <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700">Искать только</label>
                    <div class="flex flex-col space-y-2">
                        <Checkbox v-model="jobSearchConfig.search_field.name" id="vacancy-name" label="В названии вакансии" />
                        <Checkbox v-model="jobSearchConfig.search_field.company_name" id="company-name" label="В названии компании" />
                        <Checkbox
                            v-model="jobSearchConfig.search_field.description"
                            id="vacancy-description"
                            label="В описании вакансии"
                        />
                    </div>
                </div>

                <!-- Key Words -->
                <div>
                    <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="key-words"
                    >Ключевые слова</label
                    >
                    <TagInput id="exclude-words" class="w-full" v-model="jobSearchConfig.keywords" />
                </div>

                <!-- Exclude Words -->
                <div>
                    <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="exclude-words"
                    >Исключить слова</label
                    >
                    <TagInput id="exclude-words" class="w-full" v-model="jobSearchConfig.words_to_exclude" />
                </div>

                <!-- Industry -->
                <div>
                    <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="industry"
                    >Отрасль компании</label
                    >
                    <SearchSelect
                        id="industry"
                        class="w-full"
                        v-model="jobSearchConfig.industry"
                        :fetch-url="'https://api.hh.ru/industries'"
                        :placeholder="'Оставьте пустым или начните вводить...'"
                    />
                </div>

                <!-- Specialization -->
                <div>
                    <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="specialization"
                    >Специализация</label
                    >
                    <SearchMultipleSelectSuggestions
                        id="specialization"
                        class="w-full"
                        v-model="jobSearchConfig.professional_role"
                        fetch-url="https://api.hh.ru/suggests/professional_roles"
                        :placeholder="'Оставьте пустым или начните вводить...'"
                    />
                </div>

                <!-- Area -->
                <div>
                    <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="area">Регион</label>
                    <SearchMultipleSelectSuggestions
                        id="area"
                        class="w-full"
                        v-model="jobSearchConfig.area"
                        :fetch-url="'https://api.hh.ru/suggests/areas'"
                        :placeholder="'Оставьте пустым или начните вводить...'"
                    />
                </div>

                <!-- Salary -->
                <div class="space-y-2">
                    <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="salary"
                    >Уровень дохода</label
                    >
                    <InputText :placeholder="'Уровень дохода от...'" v-model="jobSearchConfig.salary" />

                    <div class="space-x-2">
                        <PillButton
                            :text="'RUB'"
                            @click="handleCurrencyClick('RUR')"
                            :selected="jobSearchConfig.currency.RUR"
                        />
                        <PillButton
                            :text="'USD'"
                            @click="handleCurrencyClick('USD')"
                            :selected="jobSearchConfig.currency.USD"
                        />
                        <PillButton
                            :text="'EUR'"
                            @click="handleCurrencyClick('EUR')"
                            :selected="jobSearchConfig.currency.EUR"
                        />
                    </div>
                    <Checkbox v-model="jobSearchConfig.only_with_salary" id="only-with-salary" label="Только с указанным доходом" />
                </div>

                <!-- Education -->
                <div>
                    <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700">Образование</label>
                    <div class="flex flex-col space-y-2">
                        <Checkbox v-model="jobSearchConfig.education.not_needed" id="education-not-needed" label="Не требуется или не указано" />
                        <Checkbox v-model="jobSearchConfig.education.middle" id="education-middle" label="Среднее профессиональное" />
                        <Checkbox v-model="jobSearchConfig.education.higher" id="education-higher" label="Высшее" />
                    </div>
                </div>

                <!-- Experience -->
                <div>
                     <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700">Требуемый опыт</label>
                    <div class="flex flex-col space-y-1">
                        <Radio
                            v-model="jobSearchConfig.selectedExperience"
                            name="experience"
                            value="doesntMatter"
                            label="Не имеет значения"
                        />
                        <Radio v-model="jobSearchConfig.selectedExperience" name="experience" value="noExperience" label="Нет опыта" />
                        <Radio
                            v-model="jobSearchConfig.selectedExperience"
                            name="experience"
                            value="between1And3"
                            label="От 1 года до 3 лет"
                        />
                        <Radio
                            v-model="jobSearchConfig.selectedExperience"
                            name="experience"
                            value="between3And6"
                            label="От 3 до 6 лет"
                        />
                        <Radio v-model="jobSearchConfig.selectedExperience" name="experience" value="moreThan6" label="Более 6 лет" />
                    </div>
                </div>

                <!-- Employment Type -->
                <div>
                     <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700">Тип занятости</label>
                    <div class="flex flex-col space-y-2">
                        <Checkbox v-model="jobSearchConfig.employment.full" id="full-employment" label="Полная занятость" />
                        <Checkbox v-model="jobSearchConfig.employment.part" id="part-employment" label="Частичная занятость" />
                        <Checkbox v-model="jobSearchConfig.employment.project" id="project-employment" label="Проектная занятость" />
                        <Checkbox v-model="jobSearchConfig.employment.volunteer" id="volunteer-employment" label="Волонтёрство" />
                        <Checkbox v-model="jobSearchConfig.employment.probation" id="probation-employment" label="Стажировка" />
                    </div>
                </div>

                <!-- Schedule -->
                <div>
                     <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700">График работы</label>
                    <div class="flex flex-col space-y-2">
                        <Checkbox v-model="jobSearchConfig.schedule.fullDay" id="full-day-schedule" label="Полный день" />
                        <Checkbox v-model="jobSearchConfig.schedule.shift" id="shift-schedule" label="Сменный график" />
                        <Checkbox v-model="jobSearchConfig.schedule.flexible" id="flexible-schedule" label="Гибкий график" />
                        <Checkbox v-model="jobSearchConfig.schedule.remote" id="remote-schedule" label="Удалённая работа" />
                        <Checkbox v-model="jobSearchConfig.schedule.flyInFlyOut" id="flyInFlyOut-schedule" label="Вахтовый метод" />
                    </div>
                </div>

                <!-- Order By (Radio Buttons) -->
                <div>
                     <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700">Сортировать по</label>
                    <div class="flex flex-col space-y-1">
                        <Radio v-model="jobSearchConfig.selectedOrderBy" name="order_by" value="relevance" label="Соответствию" />
                        <Radio
                            v-model="jobSearchConfig.selectedOrderBy"
                            name="order_by"
                            value="publication_time"
                            label="Дате изменения"
                        />
                        <Radio v-model="jobSearchConfig.selectedOrderBy" name="order_by" value="salary_desc" label="Убыванию зарплаты" />
                        <Radio v-model="jobSearchConfig.selectedOrderBy" name="order_by" value="salary_asc" label="Возрастанию зарплаты" />
                    </div>
                </div>

                <!-- Period (Radio Buttons) -->
                <div>
                     <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700">Период</label>
                    <div class="flex flex-col space-y-1">
                        <Radio v-model="jobSearchConfig.selectedPeriod" name="period" value="all_time" label="За всё время" />
                        <Radio v-model="jobSearchConfig.selectedPeriod" name="period" value="month" label="За месяц" />
                        <Radio v-model="jobSearchConfig.selectedPeriod" name="period" value="week" label="За неделю" />
                        <Radio v-model="jobSearchConfig.selectedPeriod" name="period" value="three_days" label="За последние три дня" />
                        <Radio v-model="jobSearchConfig.selectedPeriod" name="period" value="one_day" label="За сутки" />
                    </div>
                </div>

                <!-- Other Parameters -->
                <div>
                     <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700">Другие параметры</label>
                    <div class="flex flex-col space-y-2">
                        <Checkbox v-model="jobSearchConfig.vacancy_label.with_address" id="other-address" label="С адресом" />
                        <Checkbox
                            v-model="jobSearchConfig.vacancy_label.accept_handicapped"
                            id="other-handicapped"
                            label="Доступно людям с инвалидностью"
                        />
                        <Checkbox
                            v-model="jobSearchConfig.vacancy_label.not_from_agency"
                            id="other-agency"
                            label="Без вакансий от кадровых агентств"
                        />
                        <Checkbox v-model="jobSearchConfig.vacancy_label.accept_kids" id="other-kids" label="Доступные с 14 лет" />
                        <Checkbox
                            v-model="jobSearchConfig.vacancy_label.accredited_it"
                            id="other-accredited"
                            label="От аккредитованных ИТ-компаний"
                        />
                        <Checkbox
                            v-model="jobSearchConfig.vacancy_label.low_performance"
                            id="other-low-performance"
                            label="Меньше 10 откликов"
                        />
                    </div>
                </div>

                <!-- Additional Fields -->
                <div class="space-y-3">
                    <div>
                        <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="job_blacklist">
                            Черный список компаний
                        </label>
                        <TagInput id="job_blacklist" v-model="jobSearchConfig.job_blacklist" placeholder="Google, Meta, ..." />
                    </div>

                    <div>
                        <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="cover_letter">
                            Сопроводительное письмо
                        </label>
                        <Textarea id="cover_letter" placeholder="Оставьте пустым, если хотите, чтобы ИИ писал его сам под каждую вакансию" v-model="jobSearchConfig.cover_letter" rows="8" />
                    </div>

                    <div>
                        <Checkbox
                            v-model="jobSearchConfig.apply_once_at_company"
                            id="apply_once"
                            label="Откликаться только один раз в каждой компании"
                        />
                        <Checkbox
                            v-model="jobSearchConfig.skip_companies_with_test"
                            id="skip_test"
                            label="Пропускать компании с тестовыми заданиями"
                        />
                    </div>

                    <div>
                        <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="salary"
                        >Пароль от аккаунта hh.ru <Tooltip buttonText="Зачем?" tooltipText="Для отклика на вакансии с тестовыми вопросами. Для этого необходимо авторизоваться через логин и пароль." />
                        </label>
                        <InputText :placeholder="'*********'" v-model="jobSearchConfig.salary" />
                    </div>

                    <div>
                        <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="max_applies">
                            Максимальное количество откликов
                        </label>
                        <RangeInput v-model="jobSearchConfig.max_applies_num" :max="300"/>
                    </div>

                    <div>
                        <label class="mb-3 block text-lg font-semibold leading-5 text-gray-700" for="num_days">
                            Количество дней для поиска
                        </label>
                        <RangeInput v-model="jobSearchConfig.number_of_days"/>
                    </div>
                </div>

                <PillButton class="mt-8 px-4" @click="nextStep" :text="'Продолжить'" />
            </div>
        </div>

        <PolicyModal v-if="policyModal" @agree="handleAgreePolicy" @disAgree="handleDisagreePolicy" />

        <div v-if="step === 1" class="flex flex-col">
            <span class="mb-10 text-3xl">Сумма к оплате: <span class="font-bold text-indigo-600">4999</span>₽</span>
            <button @click="nextStep" class="rounded bg-blue-500 py-2 px-4 font-bold text-white hover:bg-blue-700">
                Оплатить через Юкассу
            </button>
        </div>

        <div v-if="step === 2" class="flex flex-col items-center">
            <CheckCircleIcon class="mt-5 h-24 w-24 text-green-500" />
            <span class="mt-2 text-3xl font-bold">Успешно!</span>
            <span class="mt-1 text-xl text-gray-400">Скоро с вами свяжемся</span>
        </div>
    </div>
</template>

<style scoped>
.blur-container {
    filter: blur(8px); /* Adjust blur amount as needed */
    -webkit-filter: blur(8px); /* For Safari */
}
</style>
