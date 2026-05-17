<script setup>
import branding from "@/Resources/Assets/Home/Branding.png";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <Link href="/" class="shrink-0">
        <img
            :src="branding"
            alt="branding"
            class="h-8 w-auto"
        />
    </Link>
</template>
