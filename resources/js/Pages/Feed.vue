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

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar" :hasContainer="false">
        <div class="max-w-4xl m-auto">
            <h2 class="text-surface-100 uppercase text-md font-bold mt-4">
                Лента
            </h2>
            <div v-for="post in posts" :key="post.id">
                <Post :post="post" />
            </div>
        </div>
    </MainLayout>
</template>
