<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import CitySelector from "@/Components/Natal/CitySelector.vue";
import {computed, onMounted, ref} from "vue";
import womanImage from "@/../img/Natal/night-woman.jpg"
import ArrowIcon from "@/Icons/ArrowIcon.vue";

const selectedYear = ref(null)

const years = computed(() => {
    const arr: number[] = []
    for (let y = 1900; y <= 2100; y++) arr.push(y)
    return arr
})

onMounted(() => {
    selectedYear.value = 2000
})

defineProps<{
    navbar?: Array<any>
}>()
</script>

<template>
    <MainLayout :navbar="navbar" :background="womanImage">
        <div class="max-w-xl m-auto mt-20">
            <CitySelector />
            <div class="w-56">
                <label class="block mb-2 text-md mt-3 text-gray-400">
                    Year
                </label>

                <div class="relative">
                    <select
                        v-model="selectedYear"
                        class="surface-ui scrollbar-surface w-full appearance-none px-4 py-2.5 pr-10
                                ">
                        <option
                            v-for="year in years"
                            :key="year"
                            :value="year"
                            class="bg-surface-900 text-surface-100"
                        >
                            {{ year }}
                        </option>
                    </select>

                    <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
                        <ArrowIcon to="down" class="w-4 h-4 text-surface-400" />
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
