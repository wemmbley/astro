<template>
    <BaseIcon v-bind="$props" v-on="$listeners">
        <g clip-path="url(#clip0_5_87)">
            <path
                d="M4.5 2.25L8.25 6L4.5 9.75"
                :stroke="stroke"
                :stroke-width="strokeWidth"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </g>
        <defs>
            <clipPath id="clip0_5_87">
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
