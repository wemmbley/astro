<script setup lang="ts">
import NavbarLogo from "@/Modules/Shared/Components/Navbar/NavbarLogo.vue";
import NavbarItems from "@/Modules/Shared/Components/Navbar/NavbarItems.vue";
import NavbarProfile from "@/Modules/Shared/Components/Navbar/NavbarProfile.vue";
import NavbarNotifications from "@/Modules/Shared/Components/Navbar/NavbarNotifications.vue";
import {Link, usePage} from "@inertiajs/vue3";
import {computed} from "vue";
import NavbarMessages from "@/Modules/Shared/Components/Navbar/NavbarMessages.vue";

const page = usePage()
const isAuthenticated = computed(() => !!page.props.auth.user);
const isGuest = computed(() => !page.props.auth.user);
</script>

<template>
    <header class="relative bg-surface-700 border-b border-surface-600 text-surface-100 z-9">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center">
            <div class="flex items-center flex-1 gap-4">
                <NavbarLogo />
                <NavbarItems />
            </div>
            <div class="flex items-center gap-2">
                <Link href="/transits" class="block px-4 py-2 text-sm transition
                    hover:bg-surface-500 text-surface-100 font-medium ">
                    Транзиты
                </Link>
                <Link href="/transits" class="block px-4 py-2 text-sm transition
                    hover:bg-surface-500 text-surface-100 font-medium ">
                    Полнолуние
                </Link>
                <div v-if="isAuthenticated" class="flex gap-2">
                    <NavbarMessages />
                    <NavbarNotifications />
                    <NavbarProfile/>
                </div>
                <div v-else class="flex gap-2">
                    <Link href="/auth/register" class="block px-4 py-2 text-sm transition border rounded-md
                    hover:bg-surface-500 text-surface-100 font-medium border-surface-500">
                        Зарегестрироваться
                    </Link>
                    <Link href="/auth/login" class="block px-4 py-2 text-sm transition border rounded-md
                    hover:bg-surface-500 text-surface-100 font-medium border-surface-500">
                        Войти
                    </Link>
                </div>
            </div>
        </div>
    </header>
</template>
