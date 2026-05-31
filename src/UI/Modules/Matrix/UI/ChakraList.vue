<script setup lang="ts">
import { ChakraOrder } from "@/Modules/Matrix/Domain/ChakraTypes";
import Chakra from "@/Modules/Matrix/UI/Chakra.vue";
</script>

<template>
    <Chakra
        v-for="(name, index) in ChakraOrder"
        :key="name"
        :name="name"
        :index="index"
        :length="ChakraOrder.length"
    />
</template>
