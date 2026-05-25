<script setup>
import AspectIcon from "@/Icons/Zodiac/AspectIcon.vue";

defineProps({
    name: String,
    type: String,
    orb: String,
    direction: String,
});
</script>

<template>
    <AspectIcon :aspect="type" :width="24" :height="24" color="#fff"/>
    <span class="flex-1 text-sm font-medium text-surface-100/65 min-w-0 truncate">
        {{ name }}
    </span>
    <span class="text-[12px] text-surface-100/25 bg-surface-600 rounded-[5px] px-1.5 py-0.5">
        {{ orb }}
    </span>
    <span v-if="direction"
          :class="['text-[9px] font-bold uppercase px-1.5 py-0.5 rounded-[5px]',
            direction === 'in'
            ? 'text-accent bg-accent/12'
            : 'text-surface-100/25 bg-white/5']"
    >
        {{ direction === 'in' ? 'сход.' : 'расход.' }}
    </span>
</template>
