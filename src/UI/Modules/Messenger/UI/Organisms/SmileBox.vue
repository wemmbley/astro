<script setup lang="ts">
import BadSmile from "@/Resources/Assets/Messeneger/Smiles/Bad.png"
import CrySmile from "@/Resources/Assets/Messeneger/Smiles/Cry.png"
import GoodSmile from "@/Resources/Assets/Messeneger/Smiles/Good.png"
import HappySmile from "@/Resources/Assets/Messeneger/Smiles/Happy.png"
import SadnessSmile from "@/Resources/Assets/Messeneger/Smiles/Sadness.png"
import ZephirSmile from "@/Resources/Assets/Messeneger/Smiles/Zephir.png"

import { Smile } from "lucide-vue-next"
import {Ref, ref} from "vue"

const smileMapping = [
    { key: ':bad', src: BadSmile },
    { key: ':cry', src: CrySmile },
    { key: ':good', src: GoodSmile },
    { key: ':happy', src: HappySmile },
    { key: ':sad', src: SadnessSmile },
    { key: ':zephir', src: ZephirSmile },
]

const isSmileBoxOpen = ref(false)

const toggleSmileBox = () => isSmileBoxOpen.value = !isSmileBoxOpen.value

const props = defineProps<{
    insertSmilesTo: (smile: string) => void
}>()
</script>

<template>
    <div class="inline-block text-surface-300/70 hover:text-accent transition shadow-xl">
        <div @click="toggleSmileBox" class="cursor-pointer">
            <Smile />
        </div>
        <div v-if="isSmileBoxOpen" class="absolute bottom-10 right-0 w-28
        bg-surface-700 rounded-xl shadow-lg p-2">
            <div class="flex flex-wrap gap-2">
                <img
                    v-for="smile in smileMapping"
                    :key="smile.key"
                    :src="smile.src"
                    class="w-6 h-6 cursor-pointer hover:scale-110 transition"
                    alt="smile"
                    @click="props.insertSmilesTo(smile.key)" />
            </div>
        </div>
    </div>
</template>
