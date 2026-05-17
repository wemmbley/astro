<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
    aspect: {
        type: String,
        required: true,
    },
    color: {
        type: String,
        default: '#FF332D',
    },
    width: {
        type: Number,
        default: 24,
    },
    height: {
        type: Number,
        default: 24,
    },
});

const computedColor = computed(() => props.color);
const normalized = computed(() => props.aspect.toLowerCase());
</script>

<template>
    <!-- Conjunction ☌ -->
    <svg v-if="normalized === 'conjunction'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M41.9985 45.1386C41.9985 45.1386 42.4383 31.8709 28.2191 32.001C27.4038 32.0084 26.6351 32.0582 25.9106 32.1455C13.1245 33.6855 14.3058 56.9085 27.184 56.9996C27.5206 57.002 27.8656 56.9941 28.2191 56.9754C40.5326 56.3251 41.9985 45.1386 41.9985 45.1386Z" :stroke="computedColor" stroke-width="5"/>
        <path d="M37 35L58 14" :stroke="computedColor" stroke-width="5"/>
    </svg>

    <!-- Opposition ☍ -->
    <svg v-else-if="normalized === 'opposition'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="22" cy="50" r="10" :stroke="computedColor" stroke-width="5"/>
        <circle cx="50" cy="22" r="10" :stroke="computedColor" stroke-width="5"/>
        <path d="M29 43L43 29" :stroke="computedColor" stroke-width="5"/>
    </svg>

    <!-- Sextile ⚹ -->
    <svg v-else-if="normalized === 'sextile'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M11 35H60.5" :stroke="computedColor" stroke-width="5"/>
        <path d="M17 16L56 55" :stroke="computedColor" stroke-width="5"/>
        <path d="M56 16L17 55" :stroke="computedColor" stroke-width="5"/>
        <path d="M36 60.5L36 11" :stroke="computedColor" stroke-width="5"/>
    </svg>


    <!-- Square □ -->
    <svg v-else-if="normalized === 'square'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M17 54V17H54V54H17Z" :stroke="computedColor" stroke-width="5"/>
    </svg>

    <!-- Trine △ -->
    <svg v-else-if="normalized === 'trine'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M36 12L10 60H62L36 12Z" :stroke="computedColor" stroke-width="5" stroke-linejoin="round"/>
    </svg>

    <!-- Semisquare ∠ — половина квадрата, угол 45° -->
    <svg v-else-if="normalized === 'semisquare'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 58L14 14L58 58" :stroke="computedColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>

    <!-- Sesquiquadrate ⊼ — квадрат + полуквадрат -->
    <svg v-else-if="normalized === 'sesquiquadrate'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 58V22H50" :stroke="computedColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M50 10L62 22" :stroke="computedColor" stroke-width="5" stroke-linecap="round"/>
    </svg>

    <!-- Quincunx ⚻ — квинконс, 150° -->
    <svg v-else-if="normalized === 'quincunx'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="22" cy="54" r="9" :stroke="computedColor" stroke-width="5"/>
        <circle cx="50" cy="54" r="9" :stroke="computedColor" stroke-width="5"/>
        <path d="M36 12L22 45M36 12L50 45" :stroke="computedColor" stroke-width="5" stroke-linecap="round"/>
    </svg>

    <!-- Quintile Q — пятая гармоника, пятиугольник -->
    <svg v-else-if="normalized === 'quintile'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M36 10L60.7 27.6L51.6 56.5H20.4L11.3 27.6Z" :stroke="computedColor" stroke-width="5" stroke-linejoin="round"/>
    </svg>

    <!-- Biquintile bQ — шестиугольник как 2×Q -->
    <svg v-else-if="normalized === 'biquintile'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M36 10L60.7 27.6L51.6 56.5H20.4L11.3 27.6Z" :stroke="computedColor" stroke-width="4" stroke-linejoin="round" stroke-dasharray="5 3"/>
        <text x="36" y="40" text-anchor="middle" dominant-baseline="central" font-size="14" font-weight="600" :fill="computedColor" font-family="sans-serif">bQ</text>
    </svg>

    <!-- Semisextile ⚺ — полусекстиль, 30° -->
    <svg v-else-if="normalized === 'semisextile'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 36H58" :stroke="computedColor" stroke-width="5"/>
        <path d="M36 14L58 36" :stroke="computedColor" stroke-width="5" stroke-linecap="round"/>
    </svg>

    <!-- Parallel ∥ -->
    <svg v-else-if="normalized === 'parallel'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M26 14V58M46 14V58" :stroke="computedColor" stroke-width="5" stroke-linecap="round"/>
    </svg>

    <!-- Contraparallel ⋕ -->
    <svg v-else-if="normalized === 'contraparallel'" :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M26 14V58M46 14V58" :stroke="computedColor" stroke-width="5" stroke-linecap="round"/>
        <path d="M14 30H58M14 42H58" :stroke="computedColor" stroke-width="3" stroke-linecap="round"/>
    </svg>

    <!-- Fallback: текстовая заглушка -->
    <svg v-else :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="4" y="4" width="64" height="64" rx="8" :stroke="computedColor" stroke-width="3" stroke-dasharray="6 3"/>
        <text x="36" y="40" text-anchor="middle" dominant-baseline="central" font-size="12" :fill="computedColor" font-family="sans-serif">{{ aspect.slice(0,3) }}</text>
    </svg>
</template>
