<script setup lang="ts">
import { ChakraName, ChakraMap } from "@/Modules/Matrix/Domain/ChakraTypes";
import {computed} from "vue";
import ChakraBg from "./ChakraBg.png"

const props = defineProps<{
    name: ChakraName;
    index: number;
    length: number;
}>();

const isFirst = computed(() => props.index === 0);
const isLast = computed(() => props.index === props.length - 1);

type ChakraDescription = {
    core: string;
    tags: string;
    description: string;
};

const descriptionMap: Record<ChakraName, ChakraDescription> = {
    muladhara: {
        core: "корень",
        tags: "выживание, безопасность, род, материальная опора",
        description:
            "Аркан показывает базовую родовую программу, полученные от предков установки и фундамент жизненной устойчивости.",
    },
    svadhisthana: {
        core: "крестец",
        tags: "удовольствие, сексуальность, творчество, отношения",
        description:
            "Показывает сценарии близости, взаимодействия с партнёром и способность принимать радость жизни.",
    },
    manipura: {
        core: "солнечное сплетение",
        tags: "сила воли, самооценка, лидерство, социальная реализация",
        description:
            "Отражает отношение человека к власти, ответственности, личным границам и достижению целей.",
    },
    anahata: {
        core: "сердце",
        tags: "любовь, принятие, сострадание, связь с собой и окружающими",
        description:
            "Часто именно здесь раскрывается главный жизненный урок, связанный с любовью и гармонией.",
    },
    vishuddha: {
        core: "горло",
        tags: "речь, самовыражение, творчество, коммуникация",
        description:
            "Показывает, насколько свободно человек выражает свои мысли, идеи и внутреннюю истину.",
    },
    ajna: {
        core: "третий глаз",
        tags: "интуиция, мировоззрение, убеждения и восприятие реальности",
        description:
            "Показывает фильтры восприятия, через которые человек интерпретирует происходящее вокруг.",
    },
    sahasrara: {
        core: "корона",
        tags: "предназначение, смысл жизни, связь с высшими уровнями бытия",
        description:
            "Отражает глобальное направление пути и задачи, которые раскрываются через жизненный опыт.",
    },
};

const chakra = ChakraMap[props.name];
const info = descriptionMap[props.name];
</script>

<template>
    <div class="border p-5 relative z-5 overflow-hidden"
         :class="{
            'rounded-t-lg': isFirst,
            'rounded-b-lg': isLast,
            'mb-[0.4px]': !isLast,
         }"
         :style="{
            borderColor: chakra.color + 'B3',
            backgroundColor: chakra.color + '1A',
         }">
        <div class="z-9 flex">
            <img :src="chakra.imageChakra" :alt="name" class="w-48 h-48"/>
            <div>
                <h3 class="mb-2 font-medium" :style="{ color: chakra.color }">
                    {{ chakra.name }} — {{ info.core }}
                </h3>
                <p><strong>Тема:</strong> {{ info.tags }}.</p>
                <p class="mt-2">{{ info.description }}</p>
            </div>
        </div>
        <img
            :src="ChakraBg"
            alt="chakra background"
            class="absolute inset-0 w-full h-full object-cover brightness-12 -z-10"
        />
        <slot/>
    </div>
</template>
