<script setup>
import Navbar from '../Components/Navbar.vue';

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <Navbar :navbar="navbar" />
</template>
