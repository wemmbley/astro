<script setup lang="ts">
import CalculateForm from "@/Modules/Natal/UI/Templates/CalculateForm.vue";
import MainLayout from "@/Resources/Layouts/MainLayout.vue";

defineProps({
    navbar: Array,
})
</script>

<template>
    <MainLayout :navbar="navbar" :background="womanImage">
        <CalculateForm />
    </MainLayout>
</template>
