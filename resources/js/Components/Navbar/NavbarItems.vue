<script setup>
import {Link, usePage} from "@inertiajs/vue3";
const page = usePage()

defineProps({
    navbar: Array
})
</script>

<template>
    <nav class="flex items-center gap-1 ml-6">
        <Link
            v-for="navItem in navbar"
            :key="navItem.id"
            :href="navItem.link"

            :class="[
                     'flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all',

                     page.url === navItem.link
                       ? 'bg-surface-600 text-white'
                       : 'hover:bg-surface-600/50 hover:text-white'
                    ]"
        >
            {{ navItem.label }}
        </Link>
    </nav>
</template>
