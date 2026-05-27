<script setup>
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import Profile from "@/Modules/Social/UI/Templates/Profile.vue"

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar">
        <Profile />
    </MainLayout>
</template>
