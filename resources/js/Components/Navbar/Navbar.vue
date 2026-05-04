<script setup>
import NavbarLogo from "@/Components/Navbar/NavbarLogo.vue";
import NavbarItems from "@/Components/Navbar/NavbarItems.vue";
import NavbarProfile from "@/Components/Navbar/NavbarProfile.vue";
import NavbarNotifications from "@/Components/Navbar/NavbarNotifications.vue";

defineProps({
    navbar: Array
})
</script>

<template>
    <header class="bg-surface-700 border-b border-surface-600 text-cream">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center">
            <div class="flex items-center flex-1 gap-4">
                <NavbarLogo />
                <NavbarItems :navbar="navbar" />
            </div>
            <div class="flex items-center gap-2">
                <NavbarNotifications />
                <NavbarProfile />
            </div>
        </div>
    </header>
</template>
