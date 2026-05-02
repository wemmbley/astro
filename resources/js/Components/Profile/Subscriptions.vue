<script setup>
import {ref} from "vue";

const subscriptions = ref([
    { id: 1, name: 'Лотос Безмятежности',    avatar: 'https://i.pinimg.com/1200x/64/bd/1b/64bd1bea46c5de53ad880d5cef027694.jpg' },
    { id: 2, name: 'Крылья Ангела',     avatar: 'https://i.pinimg.com/736x/5d/18/e3/5d18e3caaa23bf34c8ea704e79456eb7.jpg' },
    { id: 3, name: 'Отчаянная Душа',  avatar: 'https://i.pinimg.com/736x/e9/1a/3d/e91a3db898369493496b168894c5763c.jpg' },
    { id: 4, name: 'Тепло Надежды',  avatar: 'https://i.pinimg.com/736x/f8/19/e8/f819e8991eebfd54c156e5634945400d.jpg' },
    { id: 5, name: 'Просветлённое Безумие',   avatar: 'https://i.pinimg.com/736x/bb/ee/a4/bbeea43bdb39b0b4c038e56dd42b682c.jpg' },
    { id: 6, name: 'Царица Острова',    avatar: 'https://i.pinimg.com/736x/16/ed/bf/16edbf21444d884f6b62b4c42362d22a.jpg' },
    { id: 7, name: 'Лиза Фёдорова',   avatar: 'https://randomuser.me/api/portraits/women/21.jpg' },
    { id: 8, name: 'Роман Белов',     avatar: 'https://randomuser.me/api/portraits/men/63.jpg' },
])
</script>

<template>
    <div class="bg-surface-card border border-surface-border/60 rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between mb-4 px-1">
            <span class="text-[11px] font-bold uppercase tracking-[0.1em] text-cream/40">Подписки</span>
            <span class="text-[10px] font-medium text-accent bg-accent/10 px-2 py-0.5 rounded-md ring-1 ring-accent/20">
                {{ subscriptions.length }}
            </span>
        </div>

        <div class="grid grid-cols-3 gap-2">
            <div v-for="sub in subscriptions.slice(0, 6)" :key="sub.id"
                 class="group flex flex-col items-center gap-1.5 transition-all duration-300 cursor-pointer">
                <div class="relative">
                    <img :src="sub.avatar"
                         class="w-11 h-11 rounded-full object-cover ring-2 ring-transparent group-hover:ring-accent/50 group-hover:scale-105 transition-all duration-300 shadow-md" />
                </div>
                <span class="text-[10px] text-cream/60 group-hover:text-cream truncate w-full text-center transition-colors">
                    {{ sub.name }}
                </span>
            </div>
        </div>
    </div>
</template>
