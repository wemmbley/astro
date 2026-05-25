<script setup lang="ts">
import { Mail } from 'lucide-vue-next'

const unreadCount = 1;
</script>

<template>
    <a href="/messages" class="relative text-surface-100 p-2
    hover:bg-surface-600 transition rounded-md cursor-pointer">
        <Mail size="20" />
        <span
            v-if="unreadCount > 0"
            class="absolute top-1 right-1 w-4 h-4 bg-red-500 rounded-full
                       text-white text-[10px] font-bold flex items-center justify-center">
                {{ unreadCount }}
            </span>
    </a>
</template>
