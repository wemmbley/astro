<script setup>
import {ref} from "vue";

const friends = ref([
    { id: 1, name: 'Каролина Дарк', lastSeen: 'online',    avatar: 'https://i.pinimg.com/736x/f0/2e/c5/f02ec5df4ecc74356b9300151cb069f4.jpg' },
    { id: 2, name: 'Иисус Христос', lastSeen: 'online', avatar: 'https://i.pinimg.com/736x/3b/a6/88/3ba68836da08177bf1b3927ea64b1704.jpg' },
    { id: 3, name: 'Элли Хромова',  lastSeen: '02.05.2026 10:00',  avatar: 'https://i.pinimg.com/736x/82/1b/81/821b81fb0a280d1f9c455935ee2ab8de.jpg' },
    { id: 4, name: 'Вероника Мирошниченко', lastSeen: '02.05.2026 10:00',   avatar: 'https://i.pinimg.com/736x/74/0e/7a/740e7a9f66c3343c99befef4c757cba1.jpg' },
    { id: 5, name: 'Наташа Лиса', lastSeen: '02.05.2026 10:00', avatar: 'https://i.pinimg.com/736x/47/ff/ca/47ffcaba8a46de68c4c72ffd95cc8a6a.jpg' },
    { id: 6, name: 'Отчаянная Грешница', lastSeen: '02.05.2026 10:00',   avatar: 'https://i.pinimg.com/736x/e9/fa/5b/e9fa5b95260c61f47a189ea04d794ffa.jpg' },
    { id: 7, name: 'Церковный Обряд',   lastSeen: '02.05.2026 10:00',   avatar: 'https://i.pinimg.com/1200x/53/de/49/53de496410fb6518b78a2b6f9092b64c.jpg' },
])
</script>

<template>
    <div class="bg-surface-700 border border-surface-border/60 rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between mb-4 px-1">
            <span class="text-[11px] font-bold uppercase tracking-[0.1em] text-cream/40">Друзья</span>
            <span class="text-[10px] font-medium text-accent bg-accent/10 px-2 py-0.5 rounded-md ring-1 ring-accent/20">
                {{ friends.length }}
            </span>
        </div>

        <div class="grid grid-cols-3 gap-2">
            <div v-for="person in friends.slice(0, 6)" :key="person.id"
                 class="group flex flex-col items-center gap-1.5 transition-all duration-300 cursor-pointer">
                <div class="relative">
                    <img :src="person.avatar"
                         class="w-11 h-11 rounded-full object-cover ring-2 ring-transparent group-hover:ring-accent/50 group-hover:scale-105 transition-all duration-300 shadow-md" />

                    <div v-if="person.lastSeen === 'online'">
                        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-surface-card rounded-full"></div>
                    </div>
                </div>
                <span class="text-[10px] text-cream/60 group-hover:text-cream truncate w-full text-center transition-colors">
                    {{ person.name }}
                </span>
            </div>
        </div>
    </div>
</template>
