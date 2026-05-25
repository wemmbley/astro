<script setup lang="ts">
const props = defineProps<{
    avatar: string,
    lastSeen: string,
    name?: string,
}>();
</script>

<template>
    <div class="flex flex-col justify-center items-center w-14 max-h-20">
        <div class="w-11 h-11 relative">
            <img :src="props.avatar"
                 class="w-11 h-11 rounded-full object-cover border-2 border-transparent
                    transition-colors duration-200" alt="users avatar"/>
            <div v-if="props.lastSeen === 'online'"
                 class="absolute bottom-0.5 right-0.5 w-3 h-3
                bg-green-500 rounded-full border-2 border-surface-700"/>
        </div>
        <div v-if="props.name">
            <span class="text-[11px] text-surface-100/55 group-hover:text-surface-100/90
                text-center transition-colors leading-tight
                line-clamp-2 break-words mt-1">
                {{ props.name }}
            </span>
        </div>
    </div>
</template>
