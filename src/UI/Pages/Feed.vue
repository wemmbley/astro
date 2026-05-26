<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar" :hasContainer="false">
        <Feed />
    </MainLayout>
</template>
