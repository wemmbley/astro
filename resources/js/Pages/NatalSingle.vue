<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import AstroProfile from "@/Components/Natal/AstroProfile.vue";

const props = defineProps({
    navbar: Array,
    natal: Array,
});
</script>

<template>
    <MainLayout :navbar="navbar">
        <div class="flex flex-col">
           <AstroProfile :planets="natal.planets" />
            <span>Дома</span>
            <div v-for="cuspid in natal.cusps" :key="cuspid.house">
                <div class="flex gap-2">
                    <h2>{{ cuspid.house }}</h2>
                    <span>{{ cuspid.sign }}</span>
                    <span>{{ cuspid.degree }}°</span>
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
