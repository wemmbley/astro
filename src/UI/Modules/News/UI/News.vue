<script setup>
import { MOCK_NEWS } from "@/Modules/News/Domain/Mocks/News.ts";

const props = defineProps();
</script>

<template>
    <div class="border border-surface-500 rounded-xl w-110 h-140 ml-15
        bg-surface-700/50 z-10 flex flex-col overflow-hidden">
        <div class="px-5 pt-5 pb-4 border-b border-surface-600 shrink-0">
            <h2 class="text-surface-100 text-base font-semibold">
                Новости
            </h2>
        </div>
        <div
            class="flex flex-col overflow-y-auto flex-1 divide-y divide-surface-600/60"
            style="scrollbar-width: none; -ms-overflow-style: none;"
        >
            <article
                v-for="item in MOCK_NEWS"
                :key="item.id"
                class="relative px-5 py-4 hover:bg-surface-600/40 transition-colors cursor-default"
            >
                <span class="absolute right-5 top-5 w-2 h-2 rounded-full bg-accent" />
                <time class="block text-xs text-surface-400 mb-1.5 tracking-wide">
                    {{ item.date }}
                </time>
                <h3 class="text-sm font-semibold text-surface-100 leading-snug mb-2 pr-5">
                    {{ item.title }}
                </h3>
                <p class="text-xs text-surface-300 leading-relaxed line-clamp-2">
                    {{ item.body }}
                </p>
            </article>
        </div>
    </div>
</template>
