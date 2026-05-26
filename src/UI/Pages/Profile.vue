<script setup>
import MainLayout from "@/Resources/Layouts/MainLayout.vue";

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar">
        <Profile />
    </MainLayout>
</template>
