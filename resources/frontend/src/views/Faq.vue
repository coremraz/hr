<template>
    <div class="flex flex-col items-center justify-center">
        <h1 class="font-bold text-gray-700 mt-2 text-3xl mb-5 sm:text-6xl mb-10 mt-5">Часто задаваемые вопросы</h1>
        <div class="divide-y divide-gray-100 rounded-xl border border-gray-100 bg-white">
            <details v-for="(item, index) in faq" :key="index"
                     class="group p-6 [&_summary::-webkit-details-marker]:hidden" :open="index === 0">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 text-gray-900">
                    <h2 class="text-lg font-medium">{{ item.question }}</h2>

                    <span class="relative size-5 shrink-0">
          <svg
              xmlns="http://www.w3.org/2000/svg"
              class="absolute inset-0 size-5 opacity-100 group-open:opacity-0"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
          >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>

          <svg
              xmlns="http://www.w3.org/2000/svg"
              class="absolute inset-0 size-5 opacity-0 group-open:opacity-100"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
          >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
        </span>
                </summary>

                <p class="mt-4 leading-relaxed text-gray-700">
                    {{ item.answer }}
                </p>
            </details>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            faq: [
                {
                    question: "Видят ли работодатели, что отклик отправлял(а) не я, а ваш сайт?",
                    answer: "Нет, с точки зрения работодателя не видно никакой разницы, как был отправлен отклик - вами вручную или через наш сайт."
                },
                {
                    question: "Вы храните, обрабатываете или передаете куда-нибудь мои персональные данные?",
                    answer: "Ваши персональные данные нигде не хранятся и никуда не передаются, при работе с ИИ любые персональные данные заменяются на данные-пустышки (т.е. выдуманное ФИО, несуществующий номер телефона и т.д.)."
                },
                {
                    question: "Как работает продвижение резюме?",
                    answer: "Приложение запускает поиск на hh.ru с вашими настройками поиска. Далее для каждой вакансии приложение оценивает при помощи ИИ, насколько данная вакансия релевантна вашему резюме, навыкам и опыту. Если степень релевантности достаточна  - приложение формирует сопроводительное письмо с учетом специфики вашего резюме и вакансии, откликается на вакансию и прикладывает сопроводительное письмо. В случае возникновения дополнительных вопросов от работодателя приложение использует ИИ и информацию из резюме для ответа на данные вопросы. Если информации из резюме недостаточно для ответа на тот или иной вопрос - приложение пропускает данную вакансию. По окончанию рассылки список ссылок на все пропущенные вакансии и вопросы, на которые приложение затруднилось ответить, будет направлен вам на email."
                },
                {
                    question: "А с моим аккаунтом ничего не случится? Вдруг его забанят?",
                    answer: "Наше приложение является официально зарегистрированным приложением hh.ru, мы работаем через их официальный API и никак не нарушаем условия политики безопасности. Следовательно бан вашего аккаунта за использование нашего приложения невозможен."
                },
                {
                    question: "Сколько в среднем по времени занимает поиск работы?",
                    answer: "Это зависит от качества вашего резюме и того, как часто вы ходите на собеседования, но обычно не больше месяца."
                },
                {
                    question: "На каких сайтах вы осуществляете продвижение резюме?",
                    answer: "на данный момент на сайте hh.ru, в планах также добавить superjob и работа.ру, но даже одного hh.ru более чем достаточно, т.к. это крупнейший сайт по поиску работы на территории РФ, на котором публикуются 90%(?) всех вакансий"
                },
                {
                    question: "А что если программа откликнется на вакансию, на которую я бы не откликнулся(лась)?",
                    answer: "Благодаря использованию ИИ такие ситуации случаются гораздо реже, чем при обычной рассылке. Но если такое произошло, просто напишите HR-у, что откликнулись случайно (например случайно нажали на кнопку отклика) или передумали или уже нашли подходящую работу или вообще ничего не отвечайте :) В этом нет ничего криминального, никто вас за это не забанит и ни в какие черные списки не внесет."
                },
                {
                    question: "Почему ваша услуга стоит дороже обычной рассылки, которую предлагают другие сайты?",
                    answer: "Мы используем ИИ для интеллектуального поиска и отклика на вакансии, к сожалению, каждый запрос к ИИ стоит денег, поэтому мы вынуждены включить эти расходы в стоимость наших услуг. Взамен резко повышается качество откликов, а следовательно и вероятность того, что вас пригласят на собеседование."
                },
                {
                    question: "На сколько вакансий в день откликается?",
                    answer: "Максимальное число откликов на сайте hh.ru равно 200, соответственно программа может делать до 200 откликов в день, точное количество зависит от наличия релевантных вакансий, на которые программа еще не откликалась."
                },
                {
                    question: "Почему мне приходят одни отказы?",
                    answer: "Возможно, дело в качестве вашего резюме или настройках поиска вакансий (подбираются нерелевантные вакансии). Советуем обратиться в наш Карьерный центр, где опытные эксперты помогут вам улучшить качество резюме и увеличить конверсию ваших откликов."
                },
                {
                    question: "Какие фильтры используются при поиске?",
                    answer: "Ровно те же самые, что используются на hh.ru + вы можете задать дополнительные фильтры (например список компаний, на вакансии которых не откликаться)"
                },
                {
                    question: "Через сколько времени после запуска начнутся первые отклики?",
                    answer: "Обычно 3-4 минуты"
                },
                {
                    question: "Считается ли это спамом?",
                    answer: "Нет, не считается, рассылка не нарушает никаких правил использования. Вы бы и сами могли провести точно такую же рассылку вручную, также ничего при этом не нарушив, но затратив при этом значительно больше времени."
                },
                {
                    question: "Для чего вам нужен мой логин и пароль от сайта? Я же уже и так авторизовался через hh.",
                    answer: "К сожалению, в API сайта hh.ru не реализована функция отклика на вакансии с тестовыми вопросами. Для отклика на такие вакансии необходимо переходить на сайт hh.ru и откликаться уже там, а для этого необходимо авторизоваться на сайте классическим способом (через логин и пароль). На самом деле предоставлять логин/пароль от сайта совсем не обязательно - в конце каждого дня после завершения рассылки мы можем рассылать вам список вакансий, которые требуют прохождения теста для отклика, и вы уже будете откликаться на них вручную. Таких вакансий примерно 1 из 10-20. Но если вы хотите, чтобы и эти вакансии обрабатывались нами в автоматическом режиме, а на вопросы отвечал ИИ - нам понадобится ваш логин и пароль."
                }
            ]
        }
    }
}
</script>
