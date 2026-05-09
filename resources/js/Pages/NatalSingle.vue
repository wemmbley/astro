<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import AstroProfile from "@/Components/Natal/AstroProfile.vue";
import NatalCircle from "@/Components/Natal/NatalCircle.vue";
import Cuspids from "@/Components/Natal/Cuspids.vue";
import Elements from "@/Components/Natal/Elements.vue";
import Dominant from "@/Components/Natal/Dominant.vue";
import AspectsGrid from "@/Components/Natal/AspectsGrid.vue";

const props = defineProps({
    navbar: Object,
    natal: Object,
    coordinates: Object,
});
</script>

<template>
    <MainLayout :navbar="navbar">
        <div class="grid grid-cols-[1fr_280px] gap-6">
            <div>
                <NatalCircle :coordinates="coordinates" />
                <AspectsGrid :planets="natal.planets" />
            </div>

            <div class="sticky top-4 h-fit">
                <AstroProfile :planets="natal.planets" class="mt-5" />
                <Cuspids :cusps="natal.cusps" class="mt-4" />
                <Elements :elements="natal.elements" class="mt-4" />
                <Dominant :dominant="natal.dominant_sign" class="mt-4" />
            </div>
        </div>
    </MainLayout>
</template>
