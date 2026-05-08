<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import CitySelector from "@/Components/Natal/CitySelector.vue";
import {computed, onMounted, ref} from "vue";
import womanImage from "@/../img/Natal/night-woman.jpg"
import ArrowIcon from "@/Icons/ArrowIcon.vue";

const selectedYear = ref(null)
const selectedMonth = ref(null)
const selectedDay = ref(null)
const selectedHour = ref(null)
const selectedMinute = ref(null)

const years = computed(() => {
    const arr: number[] = []
    for (let y = 1900; y <= 2100; y++) arr.push(y)
    return arr
})
const months = computed(() => {
    const arr: number[] = []
    for (let y = 1; y <= 12; y++) arr.push(y)
    return arr
})
const days = computed(() => {
    const arr: number[] = []
    for (let y = 1; y <= 31; y++) arr.push(y)
    return arr
})
const hours = computed(() => {
    const arr: number[] = []
    for (let y = 1; y <= 23; y++) arr.push(y)
    return arr
})
const minutes = computed(() => {
    const arr: number[] = []
    for (let y = 1; y <= 59; y++) arr.push(y)
    return arr
})

onMounted(() => {
    selectedYear.value = 2000
    selectedMonth.value = 12
    selectedDay.value = 31
    selectedHour.value = 23
    selectedMinute.value = 59
})

defineProps<{
    navbar?: Array<any>
}>()
</script>

<template>
    <MainLayout :navbar="navbar" :background="womanImage">
        <div class="max-w-xl m-auto mt-20 rounded-xl border border-surface-500 bg-surface-700 p-5">
            <h1 class="text-[19px] text-center">Расчёт натальной карты</h1>
            <label class="block mb-3 text-md mt-5 text-gray-400">
                Город рождения
            </label>
            <CitySelector />
            <label class="block mb-3 text-md mt-5 text-gray-400">
                Дата рождения
            </label>
            <div class="w-full flex">
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
            <div class="w-full flex">
                <div class="relative w-[50%]">
                    <select v-model="selectedHour" class="surface-ui scrollbar-surface w-full appearance-none px-4 py-2.5 pr-10">
                        <option v-for="hour in hours" :key="hour" :value="hour" class="bg-surface-900 text-surface-100">
                            {{ hour }}
                        </option>
                    </select>
                    <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
                        <ArrowIcon to="down" class="w-4 h-4 text-surface-400" />
                    </div>
                </div>
                <div class="relative w-[50%]">
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
            <div class="w-full">
                <button class="pl-5 pr-5 pt-2 pb-2 mt-5 bg-accent rounded-md w-full
                                hover:bg-accent/50 transition cursor-pointer"
                >
                    Произвести расчёт
                </button>
            </div>
        </div>
    </MainLayout>
</template>
