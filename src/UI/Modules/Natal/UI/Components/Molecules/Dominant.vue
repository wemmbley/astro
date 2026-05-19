<script setup lang="ts">
import SignIcon from "@/Resources/Icons/Zodiac/SignIcon.vue";
import { DominantSign } from "@/Modules/Natal/Domain/Types/NatalTypes"

defineProps<{
    dominant: DominantSign,
}>();
</script>

<template>
    <div class="mt-4 w-full overflow-hidden">
        <div class="px-4 pt-2 text-center text-surface-200 font-medium">
            Доминанта
        </div>
        <span class="flex gap-2 p-4 w-full justify-center">
            <SignIcon :sign="dominant.sign" width="26" height="26"/>
            {{ dominant.count }} шт.
        </span>
    </div>
</template>
