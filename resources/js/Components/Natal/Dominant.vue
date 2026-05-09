<script setup lang="ts">
import SignIcon from "@/Icons/Zodiac/SignIcon.vue";

defineProps({
    dominant: Object,
});
</script>

<template>
    <div class="bg-surface-700 mt-4 w-full rounded-xl border border-surface-500 overflow-hidden">
        <div class="px-4 pt-2 text-center text-surface-200">
            Доминанта
        </div>
        <span class="flex gap-2 p-4 w-full justify-center">
            <SignIcon :sign="dominant.sign" width="26" height="26"/>
            {{ dominant.count }} шт.
        </span>
    </div>
</template>
