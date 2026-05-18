<script setup lang="ts">
import NatalCircle from "@/Modules/Natal/UI/Components/Organisms/NatalCircle.vue";
import AspectsGrid from "@/Modules/Natal/UI/Components/Organisms/AspectsGrid.vue";
import Elements from "@/Modules/Natal/UI/Components/Molecules/Elements.vue";
import SinglePlanet from "@/Modules/Natal/UI/Components/Molecules/SinglePlanet.vue";
import Cuspids from "@/Modules/Natal/UI/Components/Organisms/CuspidsGrid.vue";
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import AstroProfile from "@/Modules/Social/UI/Components/Molecules/AstroProfile.vue";
import Dominant from "@/Modules/Natal/UI/Components/Molecules/Dominant.vue";
import DispositorsGrid from "@/Modules/Natal/UI/Components/Organisms/DispositorsGrid.vue";

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
            <DispositorsGrid :natal="natal" class="mb-5" />
        </div>
        <div class="max-w-5xl pt-10 m-auto">
            <div class="grid grid-cols-[1fr_280px] gap-6">
                <div>
                    <h2 class="text-2xl text-center pb-15 text-surface-200">Трактовка</h2>
                    <div class="flex flex-col gap-15">
                        <div v-for="planet in natal.planets" :key="planet.name">
                            <SinglePlanet :planet="planet" />
                            <div v-if="planet.name === 'pluto'" class="w-full text-center text-xl mt-30">
                                <p>Неканонические планеты и фиктивные точки</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
