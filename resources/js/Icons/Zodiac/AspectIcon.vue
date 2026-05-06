<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
    aspect: {
        type: String,
        validator: (value: string) => {
            const validAspects = [
                'conjunction',
                'opposition',
                'sextile',
                'square',
                'trine'
            ];
            return validAspects.indexOf(value) !== -1;
        },
        required: true,
    },
    color: {
        type: String,
        default: '#FF332D',
    },
    width: {
        type: Number,
        default: 64,
    },
    height: {
        type: Number,
        default: 64,
    },
});

const computedColor = computed(() => props.color);
</script>

<template>
    <div v-if="aspect === 'conjunction'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M41.9985 45.1386C41.9985 45.1386 42.4383 31.8709 28.2191 32.001C27.4038 32.0084 26.6351 32.0582 25.9106 32.1455C13.1245 33.6855 14.3058 56.9085 27.184 56.9996C27.5206 57.002 27.8656 56.9941 28.2191 56.9754C40.5326 56.3251 41.9985 45.1386 41.9985 45.1386Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M37 35L58 14" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="aspect === 'opposition'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M31.999 50.4087C31.999 50.4087 32.2974 41.9174 22.6487 42.0006C22.3673 42.003 22.094 42.0125 21.8288 42.0285C12.8717 42.5702 13.6864 58.4308 22.6487 57.9843C31.0043 57.568 31.999 50.4087 31.999 50.4087Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M58.999 22.4087C58.999 22.4087 59.2974 13.9174 49.6487 14.0006C49.3673 14.003 49.094 14.0125 48.8288 14.0285C39.8717 14.5702 40.6864 30.4308 49.6487 29.9843C58.0043 29.568 58.999 22.4087 58.999 22.4087Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M28 45L45 27" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="aspect === 'sextile'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 35H60.5" :stroke="computedColor" stroke-width="6"/>
            <path d="M17 16L56 55" :stroke="computedColor" stroke-width="6"/>
            <path d="M56 16L17 55" :stroke="computedColor" stroke-width="6"/>
            <path d="M36 60.5L36 11" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="aspect === 'square'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 54V17H54V54H17Z" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="aspect === 'trine'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M37.5 12L11 59H61.5L37.5 12Z" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
</template>
