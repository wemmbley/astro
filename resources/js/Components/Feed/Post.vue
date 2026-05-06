<script setup lang="ts">
import {Heart, MessageCircle, Share2} from "lucide-vue-next";

type Author = {
    name: string
    avatar: string
}

type Post = {
    id: number
    title: string
    excerpt: string
    image: string
    tag: string
    date: string
    likes: number
    comments: number
    author: Author
}

const props = defineProps<{
    post: Post
}>()
</script>
<template>
    <div class="group relative rounded-2xl overflow-hidden
                hover:border-surface-400/60 hover:shadow-2xl hover:shadow-black/30
                transition-all duration-500 cursor-pointer">
        <div class="pt-4 pb-2">
            <div class="flex items-center gap-2.5 mb-3">
                <div class="relative">
                    <img :src="post.author.avatar" class="w-9 h-9 rounded-full object-cover" />
                    <div class="absolute inset-0 rounded-full ring-1 ring-inset ring-white/10" />
                </div>
                <div class="flex min-w-0 flex-col">
                    <span class="text-cream/80 text-[14px] ml-2 font-semibold truncate">{{ post.author.name }}</span>
                    <div class="flex">
                        <div class="top-3 left-3">
                        <span class="inline-flex items-center backdrop-blur-md bg-black/40 border border-white/10
                                     text-accent text-[10px] font-bold uppercase tracking-widest
                                     px-2.5 py-1 rounded-lg">
                            {{ post.tag }}
                        </span>
                        </div>
                        <span class="text-cream/30 text-[14px] shrink-0">{{ post.date }}</span>
                    </div>
                    Подписаться
                    Скрыть пользователя из ленты
                </div>
            </div>
            <h2 class="text-cream text-[22px] font-semibold leading-snug mb-2.5
                       group-hover:text-accent transition-colors duration-300 line-clamp-2">
                {{ post.title }}
            </h2>
            <p class="text-cream/40 text-[16px] leading-relaxed line-clamp-2">
                {{ post.excerpt }}
            </p>
        </div>
        <div class="relative w-full h-52 overflow-hidden mt-1">
            <img
                :src="post.image"
                class="w-full h-full object-cover scale-100 transition-transform duration-700 ease-out"
            />
        </div>
        <div class="flex items-center justify-between py-3 mt-1">
            <div class="flex items-center gap-1.5">
                <button class="flex items-center gap-1.5 text-cream/30 hover:text-accent text-xs
                               hover:bg-accent/10 px-2.5 py-1.5 rounded-lg
                               transition-all duration-200 group/like">
                    <Heart :size="22" class="transition-all duration-200 group-hover/like:scale-110" />
                    <span class="font-medium tabular-nums">{{ post.likes }}</span>
                </button>
                <button class="flex items-center gap-1.5 text-cream/30 hover:text-accent text-xs
                               hover:bg-accent/10 px-2.5 py-1.5 rounded-lg
                               transition-all duration-200">
                    <MessageCircle :size="22" />
                    <span class="font-medium tabular-nums">{{ post.comments }}</span>
                </button>
            </div>
            <button class="p-1.5 text-cream/20 hover:text-cream/60 rounded-lg hover:bg-surface-500/50 transition-all duration-200">
                <Share2 :size="22" />
            </button>
        </div>
    </div>
</template>
