<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import AstroProfile from "@/Components/Natal/AstroProfile.vue";
import NatalCircle from "@/Components/Natal/NatalCircle.vue";
import Cuspids from "@/Components/Natal/Cuspids.vue";
import Elements from "@/Components/Natal/Elements.vue";
import Dominant from "@/Components/Natal/Dominant.vue";
import AspectsGrid from "@/Components/Natal/AspectsGrid.vue";
import ZodiacCanvas from "@/Components/Natal/ZodiacCanvas.vue";

const props = defineProps({
    navbar: Object,
    natal: Object,
    coordinates: Object,
});
</script>

<template>
    <MainLayout :navbar="navbar" :hasContainer="false">
        <div class="max-w-4xl pt-10 m-auto">
            <div class="grid grid-cols-[1fr_280px] gap-6">
                <div>
                    <h2 class="text-center font-medium mt-10 pb-5 text-surface-200">Натальный круг</h2>
                    <NatalCircle :coordinates="coordinates" />
                    <h2 class="text-center font-medium mt-10 text-surface-200">Аспекты</h2>
                    <AspectsGrid :planets="natal.planets" />
                </div>
                <div class="sticky top-4 h-fit">
                    <AstroProfile :planets="natal.planets" class="mt-10" />
                    <Cuspids :cusps="natal.cusps" class="mt-4" />
                    <Elements :elements="natal.elements" class="mt-4" />
                    <Dominant :dominant="natal.dominant_sign" class="mt-4" />
                </div>
            </div>
        </div>
        <div class="mt-10 p-5">
            <h2 class="text-center font-medium pb-5 text-surface-200">Натальный документ</h2>
            <ZodiacCanvas :natal="natal" class="mb-5" />
        </div>
        <div class="max-w-4xl pt-10 m-auto">
            <div class="grid grid-cols-[1fr_280px] gap-6">
                <div>
                    <h2 class="text-center font-medium pb-5 text-surface-200">Трактовка</h2>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
