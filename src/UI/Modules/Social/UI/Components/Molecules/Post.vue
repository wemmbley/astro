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
    <div class="group max-w-4xl pt-4">
        <div class="flex items-start justify-between gap-3 mb-4">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="relative flex-shrink-0">
                    <img :src="post.author.avatar"
                         class="w-10 h-10 rounded-full object-cover"/>
                    <div class="absolute inset-0 rounded-full ring-1 ring-inset ring-white/10"/>
                </div>
                <div class="flex flex-col gap-1 min-w-0">
                    <span class="text-[14px] font-semibold text-surface-100/85 truncate">
                        {{ post.author.name }}
                    </span>
                    <div class="flex items-center gap-1.5">
                        <span class="text-[10px] font-bold uppercase tracking-[0.08em]
                                     text-accent bg-accent/10 border border-accent/20
                                     px-2 py-0.5 rounded-md">
                            {{ post.tag }}
                        </span>
                        <span class="text-surface-100/20 text-[10px]">·</span>
                        <span class="text-[12px] text-surface-100/28 shrink-0">{{ post.date }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-1.5 flex-shrink-0">
                <button class="text-[11px] font-semibold text-accent cursor-pointer
                               bg-accent/10 hover:bg-accent/20 border border-accent/20
                               px-3 py-1.5 rounded-lg transition-colors duration-200 whitespace-nowrap">
                    Подписаться
                </button>
                <button class="text-[11px] font-medium text-surface-100/55 hover:text-surface-100/90
                               border border-white/7 hover:border-white/15 cursor-pointer
                               px-2.5 py-1.5 rounded-lg transition-all duration-200 whitespace-nowrap">
                    Скрыть
                </button>
            </div>
        </div>
        <h2 class="text-[20px] font-semibold text-surface-100/95 leading-snug mb-2.5
                   transition-colors duration-300 line-clamp-2">
            {{ post.title }}
        </h2>
        <p class="text-[14px] text-surface-100/55 leading-relaxed line-clamp-2 mb-3.5">
            {{ post.excerpt }}
        </p>
        <div class="rounded-2xl overflow-hidden h-56">
            <img :src="post.image"
                 class="w-full h-full object-cover transition-transform duration-700
                        group-hover:scale-[1.03]"/>
        </div>
        <div class="flex items-center justify-between pt-2.5 pb-1">
            <div class="flex items-center gap-1">
                <button class="flex items-center gap-1.5 text-surface-100/28 hover:text-accent text-[13px]
                               font-medium hover:bg-accent/10 px-2.5 py-1.5 rounded-xl
                               transition-all duration-200 group/like">
                    <Heart :size="20" class="transition-transform duration-200 group-hover/like:scale-110"/>
                    <span class="tabular-nums">{{ post.likes }}</span>
                </button>
                <button class="flex items-center gap-1.5 text-surface-100/28 hover:text-accent text-[13px]
                               font-medium hover:bg-accent/10 px-2.5 py-1.5 rounded-xl
                               transition-all duration-200">
                    <MessageCircle :size="20"/>
                    <span class="tabular-nums">{{ post.comments }}</span>
                </button>
            </div>
            <button class="p-2 text-surface-100/20 hover:text-surface-100/55 rounded-xl
                           hover:bg-white/6 transition-all duration-200">
                <Share2 :size="20"/>
            </button>
        </div>
    </div>
</template>
