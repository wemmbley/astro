<script setup>
import { ref } from 'vue'
import {Heart, MessageCircle, Share2} from "lucide-vue-next";

const posts = ref([
    {
        id: 1,
        title:   'Астрология. Введение.',
        excerpt: 'В этом посте я коротко расскажу про такую науку как Астрология, и дам короткий экскурс в базовые понятия.',
        image:   'https://i.pinimg.com/1200x/2b/ed/62/2bed62aba829a95a1cf1d0b825243b17.jpg',
        tag:     'Астрология',
        date:    '2 мая 2026',
        likes:   24,
        comments: 7,
        author: { name: 'Анна Лебедь', avatar: 'https://randomuser.me/api/portraits/women/12.jpg' },
    },
    {
        id: 2,
        title:   'Ретроградный Меркурий: мифы и реальность.',
        excerpt: 'Разбираю самое популярное астрологическое явление — почему все боятся ретроградного Меркурия и что на самом деле происходит.',
        image:   'https://i.pinimg.com/736x/02/2b/2d/022b2d24f8c8206ff6e43419cb671fe0.jpg',
        tag:     'Планеты',
        date:    '28 апр. 2026',
        likes:   51,
        comments: 13,
        author: { name: 'Анна Лебедь', avatar: 'https://randomuser.me/api/portraits/women/12.jpg' },
    },
])

</script>

<template>
    <div v-for="post in posts" :key="post.id"
         class="group bg-surface-card border border-surface-border/60 rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-accent/5 transition-all duration-500">

        <div class="relative w-full h-56 overflow-hidden">
            <img :src="post.image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
            <div class="absolute inset-0 bg-gradient-to-t from-surface-card via-transparent to-transparent opacity-80" />

            <div class="absolute top-4 right-4">
                <span class="backdrop-blur-md bg-surface-card/60 text-accent text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-lg border border-white/5">
                    {{ post.tag }}
                </span>
            </div>
        </div>

        <div class="p-5">
            <div class="flex items-center gap-3 mb-4">
                <img :src="post.author.avatar" class="w-8 h-8 rounded-full ring-2 ring-surface-border" />
                <div class="flex flex-col">
                    <span class="text-cream text-xs font-semibold">{{ post.author.name }}</span>
                    <span class="text-cream/30 text-[10px]">{{ post.date }}</span>
                </div>
            </div>

            <h2 class="text-cream text-lg font-semibold mb-2 group-hover:text-accent transition-colors duration-300 leading-tight">
                {{ post.title }}
            </h2>
            <p class="text-cream/50 text-sm leading-relaxed line-clamp-2">
                {{ post.excerpt }}
            </p>
        </div>

        <div class="flex items-center justify-between px-5 pb-5 pt-2">
            <div class="flex items-center gap-2">
                <button class="flex items-center gap-2 bg-surface-hover/50 hover:bg-accent/10 hover:text-accent text-cream/40 text-xs transition-all px-3 py-2 rounded-xl group/btn">
                    <Heart :size="16" class="group-hover/btn:fill-accent/20" />
                    <span class="font-medium">{{ post.likes }}</span>
                </button>
                <button class="flex items-center gap-2 bg-surface-hover/50 hover:bg-accent/10 hover:text-accent text-cream/40 text-xs transition-all px-3 py-2 rounded-xl">
                    <MessageCircle :size="16" />
                    <span class="font-medium">{{ post.comments }}</span>
                </button>
            </div>

            <button class="p-2 text-cream/30 hover:text-white transition-colors">
                <Share2 :size="18" />
            </button>
        </div>
    </div>
</template>
