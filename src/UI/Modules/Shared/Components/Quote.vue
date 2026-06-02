<script setup lang="ts">
import {Quote} from "lucide-vue-next";
</script>

<template>
    <div class="bg-surface-700 px-8 py-6 space-y-4 mt-10 rounded-xl text-surface-100
                            border border-surface-600 relative">
        <Quote class="absolute -top-5 -left-5 text-surface-500" :size="46" />
        <slot />
    </div>
</template>
