<script setup>
import Navbar from "@/Components/Navbar/Navbar.vue";

const { hasContainer = true } = defineProps({
    navbar: Array,
    background: String,
    hasContainer: Boolean,
});
</script>

<template>
    <div
        class="min-h-screen"
        :class="background ? '' : 'bg-surface-800'"
    >
        <template v-if="background">
            <div
                class="fixed inset-0 -z-10 bg-cover bg-center bg-no-repeat"
                :style="`background-image: url('${background}')`"
            />
            <div class="fixed inset-0 -z-10 bg-surface-800/70" />
        </template>

        <Navbar :navbar="navbar" />

        <div v-if="hasContainer">
            <div class="max-w-4xl mx-auto min-h-screen flex justify-center pt-10">
                <slot />
            </div>
        </div>
        <div v-else>
            <slot />
        </div>
    </div>
</template>
