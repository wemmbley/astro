<script setup lang="ts">
import { ChakraOrder, ChakraMap } from "@/Modules/Matrix/Domain/ChakraTypes";
import Chakra from "@/Modules/Matrix/UI/Chakra.vue";
import {getArcaneImage} from "@/Modules/Matrix/Domain/ArcaneImages";
import {ArcaneNames} from "@/Modules/Matrix/Domain/ArcaneTypes";

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
        :length="ChakraOrder.length" class="mt-20">
        <div v-if="props.detailedChakras">
            <div class="flex justify-between">
                <div class="flex flex-col w-[32%] border rounded-md p-2" :style="getStyle(name)">
                    <span class="text-center">Материя</span>
                    <span class="text-center font-bold">{{ props.detailedChakras[name]?.physics }}</span>
                    <span class="text-center mt-2 mb-1 font-medium">
                        {{ ArcaneNames[props.detailedChakras[name]?.physics] }}
                    </span>
                    <img :src="getArcaneImage(props.detailedChakras[name]?.physics)"
                         class="h-80 w-50 m-auto rounded-xl" alt="arcane" />
                    <a href="" class="text-center mt-2 italic"
                       :class="`text-[${ChakraMap[name].color}]`">
                        ...читать подробнее
                    </a>
                </div>
                <div class="flex flex-col w-[32%] border rounded-md p-2" :style="getStyle(name)">
                    <span class="text-center">Духовная энергичность</span>
                    <span class="text-center font-bold">{{ props.detailedChakras[name]?.energy }}</span>
                    <span class="text-center mt-2 mb-1 font-medium">
                        {{ ArcaneNames[props.detailedChakras[name]?.energy] }}
                    </span>
                    <img :src="getArcaneImage(props.detailedChakras[name]?.energy)"
                         class="h-80 w-50 m-auto rounded-xl" alt="arcane" />
                    <a href="" class="text-center mt-2 italic"
                       :class="`text-[${ChakraMap[name].color}]`">
                        ...читать подробнее
                    </a>
                </div>
                <div class="flex flex-col w-[32%] border rounded-md p-2" :style="getStyle(name)">
                    <span class="text-center">Чувства</span>
                    <span class="text-center font-bold">{{ props.detailedChakras[name]?.emotion }}</span>
                    <span class="text-center mt-2 mb-1 font-medium">
                        {{ ArcaneNames[props.detailedChakras[name]?.emotion] }}
                    </span>
                    <img :src="getArcaneImage(props.detailedChakras[name]?.emotion)"
                         class="h-80 w-50 m-auto rounded-xl" alt="arcane" />
                    <a href="" class="text-center mt-2 italic"
                       :class="`text-[${ChakraMap[name].color}]`">
                        ...читать подробнее
                    </a>
                </div>
            </div>
        </div>
    </Chakra>
</template>
