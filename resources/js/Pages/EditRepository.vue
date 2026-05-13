<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import StarEditor from "@/App/StarEditor/Application/Components/StarEditor.vue";

const props = defineProps<{
    navbar: object,
    error?: string,
}>();
</script>

<template>
    <MainLayout :navbar="navbar">
        <template v-if="error">
            {{ error }}
        </template>

        <StarEditor />
    </MainLayout>
</template>
