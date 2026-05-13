<template>
    <BaseIcon v-bind="$props" v-on="$listeners">
        <path
            d="M12 2.25C6.624 2.25 2.25 6.624 2.25 12C2.25 17.376 6.624 21.75 12 21.75C17.376 21.75 21.75 17.376 21.75 12C21.75 6.624 17.376 2.25 12 2.25ZM12 3.75C16.5645 3.75 20.25 7.4355 20.25 12C20.25 16.5645 16.5645 20.25 12 20.25C7.4355 20.25 3.75 16.5645 3.75 12C3.75 7.4355 7.4355 3.75 12 3.75ZM11.25 7.5V11.25H7.5V12.75H11.25V16.5H12.75V12.75H16.5V11.25H12.75V7.5H11.25Z"
            :fill="fill"
            :stroke="stroke"
            :stroke-width="strokeWidth"
        />
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
