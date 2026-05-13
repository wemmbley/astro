<template>
    <BaseIcon
        v-bind="$props"
        :view-box-width="59"
        :view-box-height="56"
        v-on="$listeners"
    >
        <g clip-path="url(#clip0_telegraph)">
            <path
                d="M29.5 12.25V43.75"
                :stroke="stroke"
                :stroke-width="strokeWidth"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                d="M11.0625 19.25V12.25H47.9375V19.25"
                :stroke="stroke"
                :stroke-width="strokeWidth"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                d="M22.125 43.75H36.875"
                :stroke="stroke"
                :stroke-width="strokeWidth"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </g>
        <defs>
            <clipPath id="clip0_telegraph">
                <rect width="59" height="56" fill="white"/>
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
