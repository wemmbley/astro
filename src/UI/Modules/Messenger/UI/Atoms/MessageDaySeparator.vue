<script setup lang="ts">
defineProps<{ label: string }>();
</script>

<template>
    <div class="flex items-center justify-center my-3 select-none">
        <span class="bg-surface-700 text-surface-100
        text-[13px] px-5 py-2 rounded-full font-medium">
            {{ label }}
        </span>
    </div>
</template>
