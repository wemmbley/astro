<script setup>
import SignIcon from "@/Icons/Zodiac/SignIcon.vue";
import PlanetIcon from "@/Icons/Zodiac/PlanetIcon.vue";
import HouseIcon from "@/Icons/Zodiac/HouseIcon.vue";

defineProps({
    planets: Array,
});
</script>

<template>
    <div class="bg-surface-700 rounded-md pt-3 pl-4 pb-3 border border-surface-500">
        <p class="mb-2">Знаки</p>
        <div v-for="planet in planets" :key="planet.name">
            <div class="grid grid-cols-5 text-cream">
                <PlanetIcon :planet="planet.name" width="26" height="26" />
                <SignIcon :sign="planet.sign" width="26" height="26" />
                <p>{{ planet.degree }}°</p>
                <HouseIcon class="pl-2" :house="planet.house" width="26" height="26" />
                <div v-if="planet.retrograde">
                    <span class="border border-surface-500 pl-3 pr-3 rounded-md text-accent">R</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
