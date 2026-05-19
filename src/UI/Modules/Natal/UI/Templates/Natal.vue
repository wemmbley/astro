<script setup lang="ts">
import {ref} from "vue";
import Tabber from "@/Modules/Shared/Components/Tabber.vue";
import Cuspids from "@/Modules/Natal/UI/Components/Organisms/CuspidsGrid.vue";
import DispositorsGrid from "@/Modules/Natal/UI/Components/Organisms/DispositorsGrid.vue";
import Elements from "@/Modules/Natal/UI/Components/Molecules/Elements.vue";
import SinglePlanet from "@/Modules/Natal/UI/Components/Molecules/SinglePlanet.vue";
import Dominant from "@/Modules/Natal/UI/Components/Molecules/Dominant.vue";
import NatalCircle from "@/Modules/Natal/UI/Components/Organisms/NatalCircle.vue";
import AspectsGrid from "@/Modules/Natal/UI/Components/Organisms/AspectsGrid.vue";
import SignsGrid from "@/Modules/Natal/UI/Components/Organisms/SignsGrid.vue";
import { Natal } from "@/Modules/Natal/Domain/Types/NatalTypes"

const activeTab = ref('natal')
const tabs = [
    { key: 'natal', label: 'Круг' },
    { key: 'aspects', label: 'Аспекты' },
    { key: 'dispositors', label: 'Диспозиторы' },
];

const props = defineProps<{
    natal: Natal,
    coordinates: object,
}>();
</script>

<template>
    <div class="max-w-4xl pt-10 m-auto">
        <Tabber v-model="activeTab" :tabs="tabs" />
        <div
            :class="[
            'grid gap-6',
            activeTab === 'dispositors'
                ? 'grid-cols-1'
                : 'grid-cols-[1fr_280px]'
        ]">
            <div>
                <div v-if="activeTab === 'natal'">
                    <h2 class="text-center font-medium mt-10 pb-5 text-surface-200">Натальный круг</h2>
                    <NatalCircle :coordinates="coordinates" />
                </div>
                <div v-else-if="activeTab === 'aspects'">
                    <h2 class="text-center font-medium mt-10 text-surface-200 mb-4">Аспекты</h2>
                    <AspectsGrid :planets="natal.planets" />
                </div>
                <div v-else-if="activeTab === 'dispositors'">
                    <h2 class="text-center font-medium mt-10 text-surface-200 mb-10">Диспозиторы</h2>
                    <DispositorsGrid :natal="natal" />
                </div>
            </div>
            <div v-if="activeTab !== 'dispositors'" class="sticky top-4 self-start mt-8">
                <SignsGrid :planets="natal.planets" />
                <Cuspids :cusps="natal.cusps" class="mt-4" />
                <Elements :elements="natal.elements" class="mt-4" />
                <Dominant :dominant="natal.dominant_sign" class="mt-4" />
            </div>
        </div>
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
</template>
