<template>
    <BaseIcon v-bind="$props" v-on="$listeners">
        <g clip-path="url(#clip0_5_61)">
            <path
                d="M9.75 4.5L6 8.25L2.25 4.5"
                :stroke="stroke"
                :stroke-width="strokeWidth"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </g>
        <defs>
            <clipPath id="clip0_5_61">
                <rect width="24" height="24" fill="white"/>
            </clipPath>
        </defs>
    </BaseIcon>
</template>

<script setup>
import BaseIcon from './BaseIcon.vue'

const props = defineProps({
    size: [Number, String],
    fill: String,
    stroke: String,
    strokeWidth: [Number, String]
})
</script>
