<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query'
import {api} from '@/Libs/Fetcher'
import {marked} from "marked";

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
    <div v-if="planetInterpretLoading" class="h-20 mb-20 w-full aspect-square bg-surface-500 animate-pulse rounded-md"/>
    <div v-else v-html="marked.parse(planetInterpret.interpret)" />
</template>
