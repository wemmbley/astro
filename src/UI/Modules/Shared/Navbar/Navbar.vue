<script setup>
import NavbarLogo from "@/Modules/Shared/Components/Organisms/Navbar/NavbarLogo.vue";
import NavbarItems from "@/Modules/Shared/Components/Organisms/Navbar/NavbarItems.vue";
import NavbarProfile from "@/Modules/Shared/Components/Organisms/Navbar/NavbarProfile.vue";
import NavbarNotifications from "@/Modules/Shared/Components/Organisms/Navbar/NavbarNotifications.vue";

defineProps({
    navbar: Array
})
</script>

<template>
    <header class="relative bg-surface-700 border-b border-surface-600 text-cream z-9">
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
