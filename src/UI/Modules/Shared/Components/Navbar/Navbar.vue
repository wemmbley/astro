<script setup lang="ts">
import NavbarLogo from "@/Modules/Shared/Components/Navbar/NavbarLogo.vue";
import NavbarItems from "@/Modules/Shared/Components/Navbar/NavbarItems.vue";
import NavbarProfile from "@/Modules/Shared/Components/Navbar/NavbarProfile.vue";
import NavbarNotifications from "@/Modules/Shared/Components/Navbar/NavbarNotifications.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage()
</script>

<template>
    <header class="relative bg-surface-700 border-b border-surface-600 text-cream z-9">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center">
            <div class="flex items-center flex-1 gap-4">
                <NavbarLogo />
                <NavbarItems />
            </div>
            <div class="flex items-center gap-2">
                <div v-if="page.role !== 'guest'">
                    <NavbarNotifications />
                </div>
                <NavbarProfile/>
            </div>
        </div>
    </header>
</template>
