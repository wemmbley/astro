<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import ChakraList from "@/Modules/Matrix/UI/ChakraList.vue";
import {ArcaneNames} from "@/Modules/Matrix/Domain/ArcaneTypes";
import {getArcaneImage} from "@/Modules/Matrix/Domain/ArcaneImages"

const props = defineProps<{
    destinyNumber: number,
    chakras: Record<string, {
        physics: number
        energy: number
        emotion: number
    }>
}>();
</script>

<template>
    <MainLayout>
        <div>
            <span>Число Судьбы: </span>
            {{ destinyNumber }}
        </div>
        <div>
            <span>Аркан:</span>
            {{ ArcaneNames[destinyNumber] }}
        </div>
        <img :src="getArcaneImage(destinyNumber)" alt="" class="h-90" />
        <div class="max-w-5xl mx-auto text-surface-100 mb-20">
            <ChakraList :detailedChakras="props.chakras" />
        </div>
    </MainLayout>
</template>
