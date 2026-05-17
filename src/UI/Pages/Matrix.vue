<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar" :hasContainer="false">
        Матрица Судьбы.
    </MainLayout>
</template>
