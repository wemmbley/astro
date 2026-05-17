<script setup lang="ts">
import MainLayout from "@/Modules/Shared/Layouts/MainLayout.vue";
import News from "@/Modules/News/UI/News.vue";
import HeroImage from "./Assets/Hero.png"
import Background from "./Assets/Background.png"
import Stars from "./Assets/Stars.png"

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar" :hasContainer="false">
        <img :src=Stars alt="banner" class="absolute w-screen h-screen top-0" />
        <div class="flex mt-20 justify-center overflow-hidden ">
            <div class="flex flex-col z-10">
                <img :src=HeroImage alt="banner" class="h-70 mt-20" />
                <button class="border border-surface-200 rounded-md p-2
                transition cursor-pointer text-surface-100 w-60 ml-auto
                hover:text-accent hover:border-accent">
                    Telegram
                </button>
            </div>
            <div class="relative">
                <News />
                <img
                    :src=Background
                    alt="banner"
                    class="absolute opacity-50 z-2" />
            </div>
        </div>
    </MainLayout>
</template>
