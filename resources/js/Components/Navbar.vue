<script setup>
import { Link } from '@inertiajs/vue3'
import branding from '../../img/branding_sm.png'

defineProps({
    navbar: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <ul class="bg-gray-800 text-white flex">
        <li>
            <img :src="branding" />
        </li>
        <li v-for="navItem in navbar" :key="navItem.id" class="p-3">
            <Link :href="navItem.link">
                {{ navItem.label }}
            </Link>
        </li>
    </ul>
</template>
