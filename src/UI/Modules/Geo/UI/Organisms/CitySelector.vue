<script setup lang="ts">
import { ref, useTemplateRef, computed } from "vue";
import { MapPinIcon, MapIcon, CircleOffIcon } from "lucide-vue-next";
import { onClickOutside, watchDebounced, useIntersectionObserver } from '@vueuse/core'
import { useInfiniteQuery } from '@tanstack/vue-query'
import { api } from '@/Helpers/Fetcher'
import Modal from "@/Modules/Shared/Components/Modal.vue";
import ArrowIcon from "@/Resources/Icons/Other/ArrowIcon.vue";

const emit = defineEmits(['select'])

const cityDropdownTarget = useTemplateRef('city-dropdown')
const sentinelTarget = useTemplateRef('sentinel')

const open = ref(false);
const manualMode = ref(false);
const searchQuery = ref('');
const debouncedQuery = ref('');
const selectedCity = ref<{ name: string; lat: string | number; lon: string | number } | null>(null);
const manualLat = ref('');
const manualLon = ref('');

watchDebounced(searchQuery, (newVal) => {
    if (newVal.trim().length >= 3) {
        debouncedQuery.value = newVal.trim();
    } else {
        debouncedQuery.value = '';
    }
}, { debounce: 500 });

interface CityResponse {
    ok: boolean;
    current_page: number;
    last_page: number;
    data: Array<{
        id?: number;
        name: string;
        lat: number | string;
        lon: number | string;
        terms?: string;
    }>;
}

const {
    data,
    fetchNextPage,
    hasNextPage,
    isFetching,
    isFetchingNextPage,
    status
} = useInfiniteQuery({
    queryKey: ['cities', debouncedQuery] as const,
    queryFn: ({ pageParam }) => {
        return api(`city/find/${encodeURIComponent(debouncedQuery.value)}/${pageParam}`) as Promise<CityResponse>;
    },
    initialPageParam: 1,
    getNextPageParam: (lastPage) => {
        return lastPage?.next_page_url ? lastPage.current_page + 1 : undefined;
    },
    enabled: computed(() => debouncedQuery.value.length >= 3),
});

const cities = computed(() => {
    if (!data.value) return [];

    return data.value.pages.flatMap(page => page?.data || []);
});

const showResults = computed(() => debouncedQuery.value.length >= 3 && cities.value.length > 0);
const showNotFound = computed(() => status.value === 'success' && cities.value.length === 0 && !isFetching.value);
const showLoading = computed(() => isFetching.value || isFetchingNextPage.value);

useIntersectionObserver(sentinelTarget, ([entry]) => {
    if (entry.isIntersecting && hasNextPage.value && !isFetchingNextPage.value) {
        fetchNextPage();
    }
});

function selectCity(city: any) {
    selectedCity.value = {
        name: city.name,
        lat: city.lat,
        lon: city.lon
    };
    emit('select', selectedCity.value);
    open.value = false;
    searchQuery.value = '';
}

function applyManual() {
    if (manualLat.value && manualLon.value) {
        selectedCity.value = {
            name: `Вручную (${manualLat.value}, ${manualLon.value})`,
            lat: manualLat.value,
            lon: manualLon.value
        };
        emit('select', selectedCity.value);
    }
    manualMode.value = false;
}

onClickOutside(cityDropdownTarget, () => open.value = false)
</script>

<template>
    <Modal title="Ручной ввод координат" v-model:show="manualMode" @confirm="applyManual">
        <div class="flex flex-col gap-3 pt-1">
            <input v-model="manualLat" placeholder="Широта (49.82107)"
                   class="bg-surface-700 border border-surface-600 rounded-md px-3
                   py-2 text-sm outline-none focus:border-primary-400 text-white" />
            <input v-model="manualLon" placeholder="Долгота (36.0567)"
                   class="bg-surface-700 border border-surface-600 rounded-md px-3
                   py-2 text-sm outline-none focus:border-primary-400 text-white" />
        </div>
    </Modal>

    <div class="relative w-full" ref="city-dropdown">
        <button
            @click="open = !open"
            type="button"
            class="surface-ui flex items-center gap-2 w-full px-4 py-2 text-left bg-surface-700 text-white border border-surface-600 rounded-md">
            <span class="text-primary-400"><MapIcon class="w-5 h-5" /></span>
            <span class="flex-1 text-sm">
                {{ selectedCity ? `${selectedCity.name} (${selectedCity.lat}, ${selectedCity.lon})` : 'Выберите город' }}
            </span>
            <ArrowIcon :to="open ? 'up' : 'down'" class="w-4 h-4 text-surface-400" />
        </button>
        <transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1">
            <div v-if="open"
                 class="absolute z-50 w-full rounded-md border border-surface-600
                 bg-surface-800 shadow-xl overflow-hidden mt-1">
                <div class="p-2 border-b border-surface-600">
                    <input
                        v-model="searchQuery"
                        placeholder="Поиск города (минимум 3 буквы)..."
                        class="w-full bg-surface-900 border border-surface-600 rounded
                        px-3 py-1.5 text-sm text-white outline-none focus:border-primary-400 transition"
                    />
                </div>
                <button
                    @click="manualMode = true; open = false"
                    type="button"
                    class="cursor-pointer flex items-center gap-2 w-full px-4
                    py-2.5 text-sm text-primary-300 hover:bg-surface-700 transition border-b
                    border-surface-600 text-left bg-transparent">
                    <MapPinIcon size="16" /> Ввести координаты вручную
                </button>
                <ul v-if="showResults" class="max-h-52 overflow-y-auto divide-y divide-surface-700">
                    <li v-for="city in cities"
                        :key="city.id || city.lat + city.lon"
                        @click="selectCity(city)"
                        class="flex justify-between items-center px-4 py-2.5 text-sm
                        text-white hover:bg-surface-700 cursor-pointer transition">
                        <div class="flex flex-col">
                            <span>{{ city.name }}</span>
                            <!-- Обрезаем длинную строку альтернативных имен (terms) -->
                            <span class="text-xs text-surface-400 truncate max-w-xs">
                                {{ city.terms }}
                            </span>
                        </div>
                        <span class="text-xs text-surface-500 font-mono">
                            {{ city.lat }}, {{ city.lon }}
                        </span>
                    </li>
                    <li ref="sentinel" class="h-2 bg-transparent" />
                </ul>
                <div v-if="showLoading" class="flex items-center gap-2 px-4 py-2.5 text-xs text-surface-400 bg-surface-800">
                    <span class="animate-spin w-3 h-3 border border-surface-500
                    border-t-primary-400 rounded-full" />
                    Загрузка городов...
                </div>
                <p v-if="showNotFound" class="px-4 py-3 text-sm text-surface-400 flex cursor-default bg-surface-800 items-center">
                    <CircleOffIcon size="16" class="text-red-400 mr-2" />
                    <span>Ничего не найдено...</span>
                </p>
            </div>
        </transition>
    </div>
</template>
