<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar">

    </MainLayout>
</template>
