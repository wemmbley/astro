<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import MatrixTemplate from "@/Modules/Matrix/UI/MatrixTemplate.vue";
import Footer from "@/Modules/Shared/Components/Footer.vue";

const props = defineProps<{
    destinyNumber: number,
    basePoints: object,
    diagonalPoints: object,
    chakras: Record<string, {
        physics: number
        energy: number
        emotion: number
    }>
}>();
</script>

<template>
    <MainLayout>
        <MatrixTemplate
            :destinyNumber="destinyNumber"
            :basePoints="basePoints"
            :diagonalPoints="diagonalPoints"
            :chakras="chakras" />
    </MainLayout>
    <Footer />
</template>
