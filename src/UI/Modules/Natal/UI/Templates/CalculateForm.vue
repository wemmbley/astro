<script setup lang="ts">
import {useDateSelect} from "@/Modules/Natal/UI/Components/Hooks/useDateSelect";
import CitySelector from "@/Modules/Geo/UI/Organisms/CitySelector.vue";
import ArrowIcon from "@/Resources/Icons/Other/ArrowIcon.vue";
import {useForm} from "@inertiajs/vue3";

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

const form = useForm({
    lat: '',
    lon: '',
    cityName: '',
});
</script>

<template>
    <div class="max-w-150 m-auto mt-20 rounded-xl border border-surface-500 bg-surface-700 px-15 pt-5 pb-10">
        <h1 class="text-[19px] text-center mt-2">Расчёт натальной карты</h1>
        <label class="block mb-3 text-md mt-5 text-gray-400">
            Город рождения
        </label>
        <CitySelector />
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
        <label class="block mb-3 text-md mt-5 text-gray-400">
            Время рождения
        </label>
        <div class="w-full flex justify-between gap-2">
            <div class="relative w-full">
                <select v-model="selectedHour" class="surface-ui scrollbar-surface w-full appearance-none px-4 py-2.5 pr-10">
                    <option v-for="hour in hours" :key="hour" :value="hour" class="bg-surface-900 text-surface-100">
                        {{ hour }}
                    </option>
                </select>
                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
                    <ArrowIcon to="down" class="w-4 h-4 text-surface-400" />
                </div>
            </div>
            <div class="relative w-full">
                <select v-model="selectedMinute" class="surface-ui scrollbar-surface w-full appearance-none px-4 py-2.5 pr-10">
                    <option v-for="minute in minutes" :key="minute" :value="minute" class="bg-surface-900 text-surface-100">
                        {{ minute }}
                    </option>
                </select>
                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
                    <ArrowIcon to="down" class="w-4 h-4 text-surface-400" />
                </div>
            </div>
        </div>
        <div class="w-full pt-4">
            <button class="pl-5 pr-5 pt-2 pb-2 mt-5 bg-accent rounded-md w-full
                                hover:bg-accent/50 transition cursor-pointer"
            >
                Произвести расчёт
            </button>
        </div>
    </div>
</template>
