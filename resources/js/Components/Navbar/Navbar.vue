<script setup>
import NavbarLogo from "@/Components/Navbar/NavbarLogo.vue";
import NavbarItems from "@/Components/Navbar/NavbarItems.vue";
import NavbarProfile from "@/Components/Navbar/Profile/NavbarProfile.vue";

defineProps({
    navbar: Array
})
</script>

<template>
    <header class="bg-surface-700 border-b border-surface-500 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center">
            <NavbarLogo />
            <NavbarItems :navbar="navbar" />
            <NavbarProfile />
        </div>
    </header>
</template>
