<script setup lang="ts">
import { ChakraOrder, ChakraMap } from "@/Modules/Matrix/Domain/ChakraTypes";
import Chakra from "@/Modules/Matrix/UI/Chakra.vue";

const getStyle = (name: keyof typeof ChakraMap) => {
    const color = ChakraMap[name].color;

    return {
        backgroundColor: color + "1A",
        borderColor: color + "4A",
    };
};

const props = defineProps<{
    detailedChakras?: object,
}>();
</script>

<template>
    <Chakra
        v-for="(name, index) in ChakraOrder"
        :key="name"
        :name="name"
        :index="index"
        :length="ChakraOrder.length">
        <div v-if="props.detailedChakras">
            <div class="flex justify-between">
                <div class="flex flex-col w-[32%] border rounded-md p-2" :style="getStyle(name)">
                    <span class="text-center">Физика</span>
                    <span class="text-center font-bold">{{ props.detailedChakras[name]?.physics }}</span>
                </div>
                <div class="flex flex-col w-[32%] border rounded-md p-2" :style="getStyle(name)">
                    <span class="text-center">Энергия</span>
                    <span class="text-center font-bold">{{ props.detailedChakras[name]?.energy }}</span>
                </div>
                <div class="flex flex-col w-[32%] border rounded-md p-2" :style="getStyle(name)">
                    <span class="text-center">Чувства</span>
                    <span class="text-center font-bold">{{ props.detailedChakras[name]?.emotion }}</span>
                </div>
            </div>
        </div>
    </Chakra>
</template>
