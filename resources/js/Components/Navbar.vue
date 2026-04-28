<template>
    <ul>
        <li v-for="navItem in navbar" :key="navItem.id">
            <a :href="navItem.link">
                {{ navItem.label }}
            </a>
        </li>
    </ul>
</template>

<script setup>
defineProps({
    navbar: {
        type: Array,
        required: true
    }
});
</script>
