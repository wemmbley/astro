<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import {useDateSelect} from "@/Modules/Natal/UI/Components/Hooks/useDateSelect";
import {House, Flame, Sun, Quote} from "lucide-vue-next";
import {
    Anahata, Ajna, Manipura, Muladhara, Sahasrara, Svadhistana, Vishudha
} from "@/Modules/Matrix/Domain/ChakraImages"

const {
    selectedYear,
    selectedMonth,
    selectedDay,
    selectedHour,
    selectedMinute,

    years,
    months,
    days,
    hours,
    minutes
} = useDateSelect()

</script>

<template>
    <MainLayout :hasContainer="false">
        <div class="max-w-xl m-auto w-auto mt-12">
            <form>
                <div class="bg-surface-700 border border-surface-600 p-5">
                    <h2 class="font-medium">Введите дату рождения</h2>
                    <input type="text" name="day" placeholder="День" class="bg-surface-600 border border-surface-500 focus-accent">
                    <input type="text" name="month">
                    <input type="text" name="year">
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
                <div class="bg-surface-700 px-8 py-6 space-y-4 mt-10 rounded-xl text-surface-100
                            border border-surface-600 relative">
                    <Quote class="absolute -top-5 -left-5 text-surface-500" :size="46" />
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
                </div>
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
                <h2 class="text-xl font-bold">Семь чакр в Матрице Судьбы</h2>
                <div class="border border-[#E53935]/70 bg-[#E53935]/10 p-5 rounded-t-lg mt-6 flex mb-[0.4px]">
                    <img :src="Muladhara" alt="Muladhara" class="w-48 h-48" />
                    <div>
                        <h3 class="mb-2 text-[#E53935] font-medium">Муладхара — корень</h3>
                        <p><strong>Тема:</strong> выживание, безопасность, род, материальная опора.</p>
                        <p class="mt-2">
                            Аркан показывает базовую родовую программу, полученные от предков
                            установки и фундамент жизненной устойчивости.
                        </p>
                    </div>
                </div>
                <div class="border border-[#FB8C00]/70 bg-[#FB8C00]/10 p-5 flex mb-[0.4px]">
                    <img :src="Svadhistana" alt="Svadhistana" class="w-48 h-48" />
                    <div>
                        <h3 class="mb-2 text-[#FB8C00] font-medium">Свадхистхана — крестец</h3>
                        <p><strong>Тема:</strong> удовольствие, сексуальность, творчество, отношения.</p>
                        <p class="mt-2">
                            Показывает сценарии близости, взаимодействия с партнёром
                            и способность принимать радость жизни.
                        </p>
                    </div>
                </div>
                <div class="border border-[#FDD835]/70 bg-[#FDD835]/10 p-5 flex mb-[0.4px]">
                    <img :src="Manipura" alt="Manipura" class="w-48 h-48" />
                    <div>
                        <h3 class="mb-2 text-[#FDD835] font-medium">Манипура — солнечное сплетение</h3>
                        <p><strong>Тема:</strong> сила воли, самооценка, лидерство, социальная реализация.</p>
                        <p class="mt-2">
                            Отражает отношение человека к власти, ответственности,
                            личным границам и достижению целей.
                        </p>
                    </div>
                </div>
                <div class="border border-[#43A047]/70 bg-[#43A047]/10 p-5 flex mb-[0.4px]">
                    <img :src="Anahata" alt="Anahata" class="w-48 h-48" />
                    <div>
                        <h3 class="mb-2 text-[#43A047] font-medium">Анахата — сердце</h3>
                        <p><strong>Тема:</strong> любовь, принятие, сострадание, связь с собой и окружающими.</p>
                        <p class="mt-2">
                            Часто именно здесь раскрывается главный жизненный урок,
                            связанный с любовью и гармонией.
                        </p>
                    </div>
                </div>
                <div class="border border-[#29B6F6]/70 bg-[#29B6F6]/10 p-5 flex mb-[0.4px]">
                    <img :src="Vishudha" alt="Anahata" class="w-48 h-48" />
                    <div>
                        <h3 class="mb-2 text-[#29B6F6] font-medium">Вишудха — горло</h3>
                        <p><strong>Тема:</strong> речь, самовыражение, творчество, коммуникация.</p>
                        <p class="mt-2">
                            Показывает, насколько свободно человек выражает свои мысли,
                            идеи и внутреннюю истину.
                        </p>
                    </div>
                </div>
                <div class="border border-[#8000FF]/70 bg-[#8000FF]/10 p-5 flex mb-[0.4px]">
                    <img :src="Ajna" alt="Ajna" class="w-48 h-48" />
                    <div>
                        <h3 class="mb-2 text-[#8000FF] font-medium">Аджна — третий глаз</h3>
                        <p><strong>Тема:</strong> интуиция, мировоззрение, убеждения и восприятие реальности.</p>
                        <p class="mt-2">
                            Показывает фильтры восприятия, через которые человек
                            интерпретирует происходящее вокруг.
                        </p>
                    </div>
                </div>
                <div class="border border-[#C827F5]/70 bg-[#C827F5]/10 p-5 rounded-b-lg flex">
                    <img :src="Sahasrara" alt="Sahasrara" class="w-48 h-48" />
                    <div>
                        <h3 class="mb-2 text-[#C827F5] font-medium">Сахасрара — корона</h3>
                        <p><strong>Тема:</strong> предназначение, смысл жизни, связь с высшими уровнями бытия.</p>
                        <p class="mt-2">
                            Отражает глобальное направление пути и задачи,
                            которые раскрываются через жизненный опыт.
                        </p>
                    </div>
                </div>
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
</template>
