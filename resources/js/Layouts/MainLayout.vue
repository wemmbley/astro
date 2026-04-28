<script setup>
import Navbar from "@/Components/Navbar/Navbar.vue";

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <Navbar :navbar="navbar" />
    <div class="bg-surface-800">
        <div class="max-w-4xl m-auto min-h-screen flex justify-center pt-10">
            <slot />
        </div>
    </div>
</template>
