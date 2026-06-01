<script setup lang="ts">
import {getArcaneImage} from "@/Modules/Matrix/Domain/ArcaneImages";
import ChakraList from "@/Modules/Matrix/UI/ChakraList.vue";
import {ArcaneNames} from "@/Modules/Matrix/Domain/ArcaneTypes";

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
    <div class="flex justify-center mt-2 mb-2">
        <div class="flex flex-col mt-4">
            <div class="glass-wrapper">
                <img :src="getArcaneImage(destinyNumber)" class="main-img" alt="arcane" />
                <div class="glass-sheen"></div>
            </div>
            <div class="w-full">
                <div class="text-2xl text-[#B59C81]/95 text-center border bg-[#B59C81]/16 cursor-default m-auto
                    border-[#B59C81]/95 rounded-full w-14 h-14 flex justify-center items-center mt-4">
                    {{ destinyNumber }}
                </div>
            </div>
        </div>
        <div>
            <div class="text-md text-center font-medium mb-4">{{ ArcaneNames[destinyNumber] }}</div>
            <div class="max-w-xl ml-6">
                <p><b>Тема:</b> Судьба, Фатум, Бытие, Предназначение, Миссия.</p>
                <p class="mt-2">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum nemo pr
                    aesentium soluta? Aperiam assumenda cumque dolore ex explicabo facere od
                    io quam vero voluptates voluptatibus. Deleniti dolores optio quasi saepe tenetur?
                </p>
                <a href="" class="text-surface-200 font-medium ml-auto w-full">Читать далее...</a>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto text-surface-100 mb-20 mt-10">
        <h2 class="text-xl mb-5 mt-15 text-center text-surface-200">Матрица Энергий</h2>
        <ChakraList :detailedChakras="props.chakras" />
    </div>
</template>

<style>
.glass-wrapper {
    position: relative;
    display: inline-block;
    overflow: hidden;
    border-radius: 1rem;
}
.main-img {
    height: 22.5rem;
    border-radius: 1rem;
    display: block;
}
.glass-sheen {
    position: absolute;
    top: -40%;
    left: -60%;
    width: 40%;
    height: 180%;
    background: linear-gradient(
        120deg,
        transparent 0%,
        rgba(255,255,255,0.15) 30%,
        rgba(255,255,255,0.6) 50%,
        rgba(255,255,255,0.15) 70%,
        transparent 100%
    );
    transform: rotate(25deg);
    filter: blur(2px);
    animation: sheenMove 2.5s ease-in-out infinite alternate;
    pointer-events: none;
}
@keyframes sheenMove {
    0%   { left: -60%; opacity: 0; }
    50%  { opacity: 0.7;           }
    100% { left: 120%; opacity: 0; }
}
</style>
