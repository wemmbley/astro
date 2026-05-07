<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    navbar: Array,
    natal: Array,
});
</script>

<template>
    <MainLayout :navbar="navbar">
        <div class="flex flex-col">
            Знаки
            <div v-for="planet in natal.planets" :key="planet.name">
                <div class="flex gap-2">
                    <p>{{ planet.name }}</p>
                    <p>{{ planet.sign }}</p>
                    <p>{{ planet.degree }}*</p>
                    <p>{{ planet.house }}</p>

                    <div v-if="planet.retrograde">
                        <span>R</span>
                    </div>
                </div>
            </div>
            <span>Дома</span>
            <div v-for="cuspid in natal.cusps" :key="cuspid.house">
                <div class="flex gap-2">
                    <h2>{{ cuspid.house }}</h2>
                    <span>{{ cuspid.sign }}</span>
                    <span>{{ cuspid.degree }}*</span>
                </div>
            </div>
            <span>Элементы</span>
            <div class="flex gap-2">
                <span>Fire: {{ natal.elements.fire }}</span>
                <span>Earth: {{ natal.elements.earth }}</span>
                <span>Air: {{ natal.elements.air }}</span>
                <span>Water: {{ natal.elements.water }}</span>
            </div>
            <span>Доминанта - {{ natal.dominant_sign.sign }} ({{ natal.dominant_sign.count }})</span>
        </div>
    </MainLayout>
</template>
