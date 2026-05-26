<script setup lang="ts">
import {posts} from "@/Modules/Social/Domain/Mocks/Posts.ts"
import {ref} from "vue";
import Post from "@/Modules/Social/UI/Components/Molecules/Post.vue";

const tabs = [
    { key: 'friends', label: 'Друзья' },
    { key: 'global',  label: 'Мировая' },
]
const active = ref('friends')
</script>

<template>
    <div class="max-w-4xl m-auto">
        <div class="w-full flex justify-between mt-4">
            <h2 class="text-surface-100 uppercase text-md font-bold">
                Лента
            </h2>
            <div class="flex items-center gap-1 bg-surface-800/60 p-1 rounded-xl border border-surface-600/50">
                <button
                    v-for="tab in tabs"
                    :key="tab.key"
                    @click="active = tab.key"
                    :class="[
                            'px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200',
                            active === tab.key
                                ? 'bg-surface-600 text-cream shadow-sm'
                                : 'text-cream/40 hover:text-cream/70'
                        ]"
                >
                    {{ tab.label }}
                </button>
            </div>
        </div>
        <div v-for="post in posts" :key="post.id">
            <Post :post="post" />
        </div>
    </div>
</template>
