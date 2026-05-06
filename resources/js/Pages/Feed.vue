<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import Posts from "@/Components/Profile/Posts.vue";
import {ref} from "vue";

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

const tabs = [
    { key: 'friends', label: 'Друзья' },
    { key: 'global',  label: 'Мировая' },
]
const active = ref('friends')

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar" :hasContainer="false">
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
    </MainLayout>
</template>
