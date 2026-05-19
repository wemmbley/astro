<script setup>
import PlanetIcon from "@/Resources/Icons/Zodiac/PlanetIcon.vue";
import HouseIcon from "@/Resources/Icons/Zodiac/HouseIcon.vue";
import SignIcon from "@/Resources/Icons/Zodiac/SignIcon.vue";
import Tooltip from "@/Modules/Shared/Components/Tooltip.vue";

defineProps({
    planets: Array,
});
</script>

<template>
    <div class="rounded-xl pt-2 pl-4 pb-4 ">
        <p class="mb-2 text-center font-medium text-surface-200">Знаки</p>
        <div v-for="planet in planets" :key="planet.name">
            <div class="grid grid-cols-5 text-cream pb-[0.5px]">
                <PlanetIcon :planet="planet.name" width="26" height="26" />
                <SignIcon :sign="planet.sign" width="26" height="26" />
                <p class="text-surface-100">{{ planet.degreeFormatted }}</p>
                <HouseIcon class="pl-2" :house="planet.house" width="26" height="26" />
                <div v-if="planet.retrograde" class="relative group">
                    <span class="cursor-default border border-surface-500 pl-3 pr-3 rounded-md text-accent">
                        <Tooltip>Ретроградное движение</Tooltip>
                        R
                    </span>
                </div>
                <div v-if="planet.stationary" class="relative group">
                    <span class="cursor-default border border-surface-500 pl-3 pr-3 rounded-md text-accent">
                        <Tooltip>Прямое (стационарное) движение</Tooltip>
                        <i>st</i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
