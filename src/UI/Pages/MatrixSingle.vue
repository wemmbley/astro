<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import MatrixTemplate from "@/Modules/Matrix/UI/MatrixTemplate.vue";

const props = defineProps<{
    destinyNumber: number,
    chakras: Record<string, {
        physics: number
        energy: number
        emotion: number
    }>
}>();
</script>

<template>
    <MainLayout>
        <MatrixTemplate :destiny-number="destinyNumber" :chakras="chakras" />
    </MainLayout>
</template>
