<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import Landing from "@/Modules/Home/UI/Templates/Landing.vue";
</script>

<template>
    <MainLayout :hasContainer="false">
        <Landing />
    </MainLayout>
</template>
