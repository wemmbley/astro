<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import Natal from "@/Modules/Natal/UI/Templates/Natal.vue";
import Footer from "@/Modules/Shared/Components/Footer.vue";

const props = defineProps({
    navbar: Object,
    natal: Object,
    coordinates: Object,
});
</script>

<template>
    <MainLayout :navbar="navbar" :hasContainer="false">
        <Natal :natal="natal" :coordinates="coordinates" />
    </MainLayout>
    <Footer />
</template>
