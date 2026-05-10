<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query'
import {api} from '@/Libs/Fetcher'
import marked from "@/Libs/Marked";
import {parseInterpretation} from "@/Libs/Marked";
import sunImage from "@/../img/Astro/PlanetArts/Sun.jpg"

const props = defineProps({
    planet: Object,
});

const { data: planetInterpret, isLoading: planetInterpretLoading } = useQuery({
    queryKey: ['natal-svg', props.coordinates],
    queryFn: () => api(`natal/interpret/planet/${props.planet.name}`, {
        method: 'GET',
    }),
})
</script>

<template>
    <div class="mb-5">
        <div v-if="planetInterpretLoading" class="h-20 mb-20 w-full aspect-square bg-surface-500 animate-pulse rounded-md"/>
        <div v-else class="flex">
            <img :src="sunImage" alt="sun" class="w-40" />
            {{ parseInterpretation(marked.parse(planetInterpret.interpret)) }}
<!--            <div class="markdown ml-4" v-html="marked.parse(planetInterpret.interpret)"></div>-->
        </div>
    </div>
</template>

<style scoped>
@reference "tailwindcss";

:deep(.markdown .title) {
    @apply font-medium text-amber-300;
}
</style>
