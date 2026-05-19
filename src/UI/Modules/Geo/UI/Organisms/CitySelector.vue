<script setup lang="ts">
import {onMounted, ref} from "vue";
import Modal from "@/Utils/Modal.vue";
import {MapPinIcon, MapIcon, CircleOffIcon} from "lucide-vue-next";
import ArrowIcon from "@/Icons/ArrowIcon.vue";
import { onClickOutside } from '@vueuse/core'
import { useTemplateRef } from 'vue'
import { useQuery } from '@tanstack/vue-query'
import { api } from '@/Helpers/Fetcher'

const cityDropdownTarget = useTemplateRef('city-dropdown')

const open = ref(false);
const nothingFoundOpen = ref(false);
const resultsOpen = ref(false);
const loading = ref(false);
const manualMode = ref(false);
const manualLat = ref('');
const manualLon = ref('');
const query = ref('');

function applyManual() {
    open.value = false;
}

onMounted(() => {
    useQuery({
        queryKey: ['planets'],
        queryFn: () => api('city/find/test'),
    })
})

onClickOutside(cityDropdownTarget, event => open.value = false)
</script>

<template>
    <Modal title="Ручной ввод координат" v-model:show="manualMode" @confirm="applyManual">
        <div class="flex flex-col gap-3 pt-1">
            <input v-model="manualLat" placeholder="Широта (55.75)"
                   class="bg-surface-700 border border-surface-600 rounded-md px-3 py-2 text-sm outline-none focus:border-primary-400" />
            <input v-model="manualLon" placeholder="Долгота (37.61)"
                   class="bg-surface-700 border border-surface-600 rounded-md px-3 py-2 text-sm outline-none focus:border-primary-400" />
        </div>
    </Modal>

    <div class="relative w-full" ref="city-dropdown">
        <button
            @click="open = !open"
            class="surface-ui flex items-center gap-2 w-full px-4 py-2 text-left">
            <span class="text-primary-400"><MapIcon /></span>
            <span class="flex-1">Выберите город</span>
            <ArrowIcon to="down" class="w-4 h-4 text-surface-400" />
        </button>

        <transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
        >
            <div v-if="open"
                 class="absolute z-50 w-full rounded-md border border-surface-600
                 bg-surface-800 shadow-xl overflow-hidden"
            >
                <div class="p-2 border-b border-surface-600">
                    <input
                        v-model="query"
                        placeholder="Поиск города..."
                        class="w-full bg-surface-800 border border-surface-600 rounded
                        px-3 py-1.5 text-sm outline-none focus:border-primary-400 transition"
                    />
                </div>
                <button
                    @click="manualMode = true; open = false"
                    class="cursor-pointer flex items-center gap-2 w-full px-4
                    py-2.5 text-sm text-primary-300 hover:bg-surface-700 transition border-b
                    border-surface-600"
                >
                    <MapPinIcon size="16" /> Ввести координаты вручную
                </button>
                <ul v-if="resultsOpen" class="max-h-52 overflow-y-auto">
                    <li class="flex justify-between items-center px-4 py-2.5 text-sm
                    hover:bg-surface-700 cursor-pointer transition">
                        <span>Мерчик</span>
                        <span class="text-xs text-surface-400">Харьк. Обл</span>
                    </li>

                    <!-- Sentinel для lazy load -->
                    <li ref="sentinel" class="h-1" />
                </ul>
                <div v-if="loading" class="flex items-center gap-2 px-4 py-2.5 text-xs text-surface-400">
                    <span class="animate-spin w-3 h-3 border border-surface-500
                    border-t-primary-400 rounded-full" />
                    Загрузка…
                </div>
                <p v-if="nothingFoundOpen" class="px-4 py-3 text-md text-surface-300 flex cursor-default">
                    <CircleOffIcon size="16" class="mt-1" />
                    <span class="ml-2">Ничего не найдено...</span>
                </p>
            </div>
        </transition>
    </div>
</template>
