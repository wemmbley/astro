<script setup lang="ts">
import CalculateForm from "@/Modules/Natal/UI/Templates/CalculateForm.vue";
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import Footer from "@/Modules/Shared/Components/Footer.vue";
import PlanetIcon from "@/Resources/Icons/Zodiac/PlanetIcon.vue";
import {ZodiacCapricorn} from "lucide-vue-next";
import StelliumIcon from "@/Resources/Icons/Zodiac/StelliumIcon.vue";
import Quote from "@/Modules/Shared/Components/Quote.vue";

defineProps({
    navbar: Array,
})
</script>

<template>
    <MainLayout :navbar="navbar">
        <CalculateForm class="glow-accent/30 glow-10" />
        <div class="max-w-3xl m-auto w-full">
            <div class="mt-25 mb-15 relative">
                <h1 class="font-medium text-2xl mb-5">
                    Расчёт Натальной Карты онлайн — бесплатно с расшифровкой по дате рождения
                </h1>
                <div class="absolute text-accent/60 -top-15 -right-55">
                    <StelliumIcon stellium="bigBear" />
                </div>
                <p>
                    Натальная карта — это астрологический портрет личности,
                    составленный на основе точного положения Солнца, Луны и
                    планет в момент Вашего рождения. Она позволяет обрести контур
                    Вашей собственной Судьбы: раскрыть сильные стороны характера,
                    таланты, скрытые ресурсы, а также понять ключевые жизненные
                    задачи и возможные испытания.
                </p>
                <p class="mt-3">
                    Рассчитайте натальную карту онлайн бесплатно — введите дату,
                    время и место рождения, и вы получите подробную расшифровку:
                    положение планет по знакам Зодиака и домам гороскопа, аспекты
                    между планетами, восходящий знак (Асцендент) и многое другое.
                </p>
                <div class="text-accent/80 mt-6 -translate-x-16">
                    <StelliumIcon stellium="sagittarius" />
                </div>
                <h2 class="font-medium text-xl mt-8 mb-4 flex">
                    <ZodiacCapricorn class="text-accent" size="32" />
                    <span class="ml-2">Что такое Натальная Карта</span>
                </h2>
                <p>
                    Натальная карта (или гороскоп рождения) — это снимок неба в момент,
                    когда Вы появились на свет. Астрология рассматривает расположение
                    планет как символический язык, описывающий врождённые качества,
                    внутренние противоречия и потенциал человека.
                </p>
                <p class="mt-3">
                    В основе карты лежит разделение неба на 12 домов и 12 знаков Зодиака.
                    Каждая планета занимает определённый знак и дом — и это сочетание
                    формирует уникальный астрологический код личности.
                </p>
                <Quote class="pb-12 pt-10">
                    <h2 class="font-medium text-xl flex">
                        <span class="ml-6">Из чего состоит Натальная Карта</span>
                    </h2>
                    <div class="absolute text-accent/80 mt-6 -right-50 translate-y-30">
                        <StelliumIcon stellium="sagittarius" />
                    </div>
                    <div class="ml-6">
                        <h3 class="font-bold text-lg mt-5 mb-2">Планеты</h3>
                        <p>
                            Планеты — это действующие силы карты. Солнце отвечает за самовыражение
                            и жизненный путь, Луна — за эмоции и подсознание, Меркурий — за мышление
                            и коммуникацию, Венера — за любовь и ценности, Марс — за энергию и действие.
                            Юпитер, Сатурн, Уран, Нептун и Плутон описывают более глубокие и долгосрочные
                            жизненные темы.
                        </p>
                        <h3 class="font-bold text-lg mt-5 mb-2">Знаки Зодиака</h3>
                        <p>
                            Знак, в котором находится планета, показывает стиль и способ её проявления.
                            Солнце в Овне и Солнце в Весах — это кардинально разные сценарии самовыражения,
                            хотя оба относятся к одной планете.
                        </p>
                        <h3 class="font-bold text-lg mt-5 mb-2">Дома гороскопа</h3>
                        <p>
                            12 домов натальной карты соответствуют 12 сферам жизни: личность, финансы,
                            коммуникации, семья, творчество, здоровье, партнёрство, трансформации,
                            мировоззрение, карьера, социальное окружение, духовность. Планета в доме
                            указывает, в какой сфере жизни её энергия проявляется наиболее активно.
                        </p>
                        <h3 class="font-bold text-lg mt-5 mb-2">Аспекты</h3>
                        <p>
                            Аспекты — это угловые расстояния между планетами. Они показывают, как
                            планеты взаимодействуют между собой: гармонично усиливают друг друга
                            (трин, секстиль) или создают напряжение, которое становится источником
                            роста (квадрат, оппозиция).
                        </p>
                    </div>
                </Quote>
                <h2 class="font-medium text-xl mt-18 mb-2">Что показывает расшифровка Натальной Карты</h2>
                <div class="mt-6 overflow-hidden rounded-xl border border-surface-600 bg-surface-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                            <tr class="bg-surface-800 text-surface-100 border-b border-surface-700">
                                <th class="px-4 py-3 text-left font-semibold">Элемент</th>
                                <th class="px-4 py-3 text-left font-semibold">Сфера жизни</th>
                                <th class="px-4 py-3 text-left font-semibold">Что раскрывает</th>
                            </tr>
                            </thead>
                            <tbody class="text-surface-300">
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="sun" width="24" height="24" />
                                            <span class="ml-1">Солнце</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Личность и путь</td>
                                    <td class="px-4 py-3">Главный вектор жизни, самореализация и ядро личности</td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="moon" width="24" height="24" />
                                            <span class="ml-1">Луна</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Эмоции и внутренний мир</td>
                                    <td class="px-4 py-3">Подсознательные реакции, потребности и чувство безопасности</td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="mercury" width="24" height="24" />
                                            <span class="ml-1">Меркурий</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Мышление и общение</td>
                                    <td class="px-4 py-3">Способ восприятия информации, речь и интеллект</td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="venus" width="24" height="24" />
                                            <span class="ml-1">Венера</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Любовь и ценности</td>
                                    <td class="px-4 py-3">Привязанности, симпатии, отношения и эстетические вкусы</td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="mars" width="24" height="24" />
                                            <span class="ml-1">Марс</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Энергия и действие</td>
                                    <td class="px-4 py-3">Мотивация, воля, борьба и способ достижения целей</td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="jupiter" width="24" height="24" />
                                            <span class="ml-1">Юпитер</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Рост и возможности</td>
                                    <td class="px-4 py-3">Точки расширения, удачи и мировоззрения</td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="saturn" width="24" height="24" />
                                            <span class="ml-1">Сатурн</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Структура и испытания</td>
                                    <td class="px-4 py-3">Ограничения, дисциплина, ответственность и зрелость</td>
                                </tr>
                                <tr>
                                    <td><hr class="mt-2 text-surface-600"></td>
                                    <td><hr class="mt-2 text-surface-600"></td>
                                    <td><hr class="mt-2 text-surface-600"></td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="uranus" width="24" height="24" />
                                            <span class="ml-1">Уран</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Свобода и перемены</td>
                                    <td class="px-4 py-3">Стремление к независимости, обновлению и нестандартности</td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="neptune" width="24" height="24" />
                                            <span class="ml-1">Нептун</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Мечты и вдохновение</td>
                                    <td class="px-4 py-3">Воображение, идеалы, интуитивное восприятие мира</td>
                                </tr>
                                <tr class="border-b border-surface-800 hover:bg-surface-800/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-surface-100">
                                        <div class="flex items-center justify-center">
                                            <PlanetIcon planet="pluto" width="24" height="24" />
                                            <span class="ml-1">Плутон</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">Трансформация</td>
                                    <td class="px-4 py-3">Глубинные изменения, кризисы и внутренняя сила</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <h2 class="font-medium text-xl mt-8 mb-2">Коротко</h2>
                <p>
                    Натальная карта — это не приговор и не предсказание. Это карта
                    врождённых программ, талантов и жизненных уроков. Осознавая своё
                    астрологическое устройство, человек получает возможность взаимодействовать
                    с судьбой более осознанно — опираясь на сильные стороны и понимая природу
                    своих испытаний.
                </p>
            </div>
        </div>
    </MainLayout>
    <Footer />
</template>
