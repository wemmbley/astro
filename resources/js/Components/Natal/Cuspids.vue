<script setup lang="ts">
import HouseIcon from "@/Icons/Zodiac/HouseIcon.vue";
import SignIcon from "@/Icons/Zodiac/SignIcon.vue";

defineProps({
    cusps: Object,
});
</script>

<template>
    <div class="mt-4 w-full pb-6">
        <div class="text-center font-medium pt-2 pb-4 text-surface-200">Куспиды</div>
        <div v-for="cuspid in cusps" :key="cusps.house" class="pl-8 pr-4">
            <div class="grid grid-cols-3 pb-[0.5px]">
                <HouseIcon class="pl-2" :house="cuspid.house" width="26" height="26"/>
                <SignIcon :sign="cuspid.sign" width="26" height="26"/>
                <span class="text-cream">{{ cuspid.degreeFormatted }}</span>
            </div>
        </div>
    </div>
</template>
