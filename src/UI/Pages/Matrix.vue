<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import {useDateSelect} from "@/Modules/Natal/UI/Components/Hooks/useDateSelect";
import {House, Flame, Sun} from "lucide-vue-next";
import ArrowIcon from "@/Resources/Icons/Other/ArrowIcon.vue";
import ChakraList from "@/Modules/Matrix/UI/ChakraList.vue";
import {computed} from "vue";
import Footer from "@/Modules/Shared/Components/Footer.vue";
import Quote from "@/Modules/Shared/Components/Quote.vue";

const {
    selectedYear,
    selectedMonth,
    selectedDay,

    years,
    months,
    days,
} = useDateSelect()

const matrixUrl = computed(() =>
    `/matrix/${selectedDay.value}-${selectedMonth.value}-${selectedYear.value}`
);
</script>

<template>
    <MainLayout :hasContainer="false">
        <div class="max-w-xl m-auto w-auto mt-12">
            <form>
                <div class="max-w-150 m-auto mt-20 rounded-2xl border border-surface-600 bg-surface-700
                px-15 pt-5 pb-10 mb-20 glow-10 glow-accent/30">
                    <h1 class="text-[19px] text-center mt-2">Расчёт Матрицы Судьбы</h1>
                    <label class="block mb-3 text-md mt-5 text-gray-400">
                        Дата рождения
                    </label>
                    <div class="w-full flex justify-between gap-2">
                        <div class="relative w-[33%]">
                            <select v-model="selectedYear" class="surface-ui scrollbar-surface w-full appearance-none px-4 py-2.5 pr-10">
                                <option v-for="year in years" :key="year" :value="year" class="bg-surface-900 text-surface-100">
                                    {{ year }}
                                </option>
                            </select>
                            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
                                <ArrowIcon to="down" class="w-4 h-4 text-surface-400" />
                            </div>
                        </div>
                        <div class="relative w-[33%]">
                            <select v-model="selectedMonth" class="surface-ui scrollbar-surface w-full appearance-none px-4 py-2.5 pr-10">
                                <option v-for="month in months" :key="month" :value="month" class="bg-surface-900 text-surface-100">
                                    {{ month }}
                                </option>
                            </select>
                            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
                                <ArrowIcon to="down" class="w-4 h-4 text-surface-400" />
                            </div>
                        </div>
                        <div class="relative w-[33%]">
                            <select v-model="selectedDay" class="surface-ui scrollbar-surface w-full appearance-none px-4 py-2.5 pr-10">
                                <option v-for="day in days" :key="day" :value="day" class="bg-surface-900 text-surface-100">
                                    {{ day }}
                                </option>
                            </select>
                            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
                                <ArrowIcon to="down" class="w-4 h-4 text-surface-400" />
                            </div>
                        </div>
                    </div>
                    <div class="w-full pt-4">
                        <a :href="matrixUrl" class="flex justify-center pl-5 pr-5 pt-2 pb-2 mt-5
                                bg-accent rounded-md w-full
                                hover:bg-accent/50 transition cursor-pointer">
                            Произвести расчёт
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="max-w-3xl space-y-8 m-auto w-full mt-12">
            <header class="space-y-4">
                <h1 class="text-4xl font-bold tracking-tight">
                    Матрица Судьбы. Расчёт онлайн.
                </h1>
                <p class="text-lg text-muted-foreground">
                    На нашем сайте Вы можете бесплатно произвести расчёт своей Матрицы Судьбы бесплатно.
                    Система интерпретации личности и жизненных сценариев через числа, архетипы и
                    энергетические центры человека.
                </p>
            </header>
            <section class="space-y-4">
                <h2 class="text-xl font-bold">Что такое Матрица Судьбы</h2>
                <p>
                    Матрица Судьбы — это нумерологическая система, основанная на квадрате
                    Пифагора и 22 старших арканах Таро. Система распределяется в индуистическом
                    символизме, на основании 7 Чакр.
                </p>
                <Quote>
                    <p>
                        Дата рождения переводится в числа от 1 до 22, где каждое число
                        соответствует определённому архетипу. Из этих значений строится
                        схема (матрица), в которой каждая позиция отвечает за отдельную
                        сферу жизни человека.
                    </p>
                    <p>
                        Арканы здесь рассматриваются не как инструмент гадания, а как
                        универсальные архетипы и жизненные сценарии. Двадцать два старших
                        аркана символизируют двадцать два базовых состояния и урока,
                        через которые проходит человек на протяжении своего пути.
                    </p>
                    <p>
                        Чакры используются как визуальная карта распределения энергий в теле.
                        Семь основных центров соотносятся с семью цветами спектра и помогают
                        наглядно отображать различные уровни проявления энергии —
                        от материального до духовного.
                    </p>
                </Quote>
            </section>
            <section class="space-y-4 mb-15 mt-10">
                <h2 class="text-xl font-bold">Три уровня каждой точки матрицы</h2>
                <p>
                    Каждая позиция матрицы рассматривается одновременно в трёх слоях.
                    Это позволяет увидеть не только внешние события, но и внутренние
                    причины их возникновения.
                </p>
                <div class="overflow-hidden rounded-xl border border-surface-500">
                    <table class="w-full">
                        <thead class="bg-accent/5 text-surface-100/90">
                        <tr>
                            <th class="border-b px-4 py-3 text-left border-surface-500">Слой</th>
                            <th class="border-b px-4 py-3 text-left border-surface-500">Значение</th>
                            <th class="border-b px-4 py-3 text-left border-surface-500">Стиль</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border-b px-4 py-3 font-medium border-surface-500 text-surface-200">
                                <div class="flex">
                                    <House />
                                    <span class="ml-2">Материя</span>
                                </div>
                            </td>
                            <td class="border-b px-4 py-3 border-surface-500 text-surface-50/90">
                                Внешний мир. Материальный план, тело, действия, ресурсы,
                                здоровье и деньги
                            </td>
                            <td class="border-b px-4 py-3 border-surface-500 text-surface-50/90">
                                Как чакрально-арканная энергия реализуется в реальной жизни
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b px-4 py-3 font-medium border-surface-500 text-surface-200">
                                <div class="flex">
                                    <Flame />
                                    <span class="ml-2">Чувства</span>
                                </div>
                            </td>
                            <td class="border-b px-4 py-3 border-surface-500 text-surface-50/90">
                                Внутренний мир. Эмоции, отношения, инстинкты, реакции и внутренние состояния
                            </td>
                            <td class="border-b px-4 py-3 border-surface-500 text-surface-50/90">
                                Как человек проживает и переживает чакрально-арканную энергию
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 font-medium text-surface-200">
                                <div class="flex">
                                    <Sun />
                                    <span class="ml-2">Духовность</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-surface-50/90">
                                Трансперсональный мир. Миссия, Высший замысел, предназначение и направление пути
                            </td>
                            <td class="px-4 py-3 text-surface-50/90">
                                Как проявляется Верховный Замысел Бога через конкретную чакрально-арканную энергию.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <section>
                <h2 class="text-xl font-bold mb-4">Семь чакр в Матрице Судьбы</h2>
                <ChakraList />
            </section>
            <section class="mb-12">
                <h2 class="text-xl font-bold mb-4">Коротко</h2>
                <p>
                    Матрица Судьбы показывает не неизменный сценарий жизни,
                    а набор врождённых программ, талантов и уроков.
                </p>
                <p class="mt-2">
                    Осознавая эти программы, человек получает возможность
                    взаимодействовать с ними более осмысленно и использовать
                    их как инструмент развития.
                </p>
            </section>
            <section class="mb-12">
                <h2 class="text-xl font-bold mb-4 flex">
                    <span class="m-auto ">О сайте</span>
                </h2>
                <p class="mt-2">
                    На нашем сайте Вы можете произвести расчёт своей Матрицы
                    Судьбы абсолютно бесплатно. В самой вершине текущей страницы
                    находится калькулятор - введите дату Вашего рождения, и
                    жмите кнопку "рассчитать".
                </p>
            </section>
        </div>
    </MainLayout>
    <Footer />
</template>
