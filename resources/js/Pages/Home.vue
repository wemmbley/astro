<script setup>
import Navbar from '../Components/Navbar/Navbar.vue';
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar">

    </MainLayout>
</template>
