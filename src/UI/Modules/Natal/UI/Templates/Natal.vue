<script setup lang="ts">
import {ref} from "vue";
import Tabber from "@/Modules/Shared/Components/Tabber.vue";
import Cuspids from "@/Modules/Natal/UI/Components/Organisms/CuspidsGrid.vue";
import DispositorsGrid from "@/Modules/Natal/UI/Components/Organisms/DispositorsGrid.vue";
import Elements from "@/Modules/Natal/UI/Components/Molecules/Elements.vue";
import SinglePlanet from "@/Modules/Natal/UI/Components/Molecules/SinglePlanet.vue";
import Dominant from "@/Modules/Natal/UI/Components/Molecules/Dominant.vue";
import NatalCircle from "@/Modules/Natal/UI/Components/Organisms/NatalCircle.vue";
import AspectsGrid from "@/Modules/Natal/UI/Components/Organisms/AspectsGrid.vue";
import SignsGrid from "@/Modules/Natal/UI/Components/Organisms/SignsGrid.vue";
import { Natal } from "@/Modules/Natal/Domain/Types/NatalTypes"
import {MessageCircleQuestionMarkIcon, ArrowRight, ArrowLeft, Save} from 'lucide-vue-next'
import Tooltip from "@/Modules/Shared/Components/Tooltip.vue";
import AIIcon from "@/Resources/Icons/Other/AIIcon.vue";

const activeTab = ref('natal')
const tabs = [
    { key: 'natal', label: 'Круг' },
    { key: 'aspects', label: 'Аспекты' },
    { key: 'dispositors', label: 'Диспозиторы' },
];

const props = defineProps<{
    natal: Natal,
    coordinates: object,
}>();
</script>

<template>
    <div class="max-w-4xl pt-10 m-auto">
        <Tabber v-model="activeTab" :tabs="tabs" />
        <div
            :class="[
            'grid gap-6',
            activeTab === 'dispositors'
                ? 'grid-cols-1'
                : 'grid-cols-[1fr_280px]'
        ]">
            <div>
                <div v-if="activeTab === 'natal'">
                    <div class="relative group w-full flex justify-center
                    items-center font-medium mt-10 pb-5 text-surface-200">
                        <h2 class="mr-2">Натальный круг</h2>
                        <MessageCircleQuestionMarkIcon class="text-surface-400" />
                        <Tooltip>Натальный Круг позволяет увидеть карту целостно.</Tooltip>
                    </div>
                    <NatalCircle :coordinates="coordinates" />
                </div>
                <div v-else-if="activeTab === 'aspects'">
                    <h2 class="text-center font-medium mt-10 text-surface-200 mb-4">Аспекты</h2>
                    <AspectsGrid :planets="natal.planets" />
                </div>
                <div v-else-if="activeTab === 'dispositors'">
                    <h2 class="text-center font-medium mt-10 text-surface-200 mb-10">Диспозиторы</h2>
                    <DispositorsGrid :natal="natal" />
                </div>
            </div>
            <div v-if="activeTab !== 'dispositors'" class="sticky top-4 self-start mt-0">
                <div class="flex">
                    <button class="ui-button"><ArrowLeft /></button>
                    <select name="" id="" class="surface-ui w-40">
                        <option>1 минута</option>
                        <option>5 минут</option>
                        <option>10 минут</option>
                        <option>1 час</option>
                        <option>12 часов</option>
                        <option>1 день</option>
                        <option>Неделя</option>
                        <option>Месяц</option>
                        <option>Год</option>
                        <option>9 лет</option>
                    </select>
                    <button class="ui-button"><ArrowRight /></button>
                </div>
                <div class="font-medium uppercase text-xs flex justify-center
                        text-accent/80 border border-surface-600 bg-surface-700 rounded p-1.5
                        hover:bg-surface-600 transition cursor-pointer">
                    <Save />
                    <p class="pl-2">Сохранить карту</p>
                </div>
                <div class="font-medium uppercase text-xs flex justify-center
                        text-accent/80 border border-surface-600 bg-surface-700 rounded p-1.5
                        hover:bg-surface-600 transition cursor-pointer"
                     @click="openModal('aiFull')">
                    <AIIcon :width="20" :height="20" />
                    <p class="pl-2">Задать вопрос</p>
                </div>
                <SignsGrid :planets="natal.planets" />
                <Cuspids :cusps="natal.cusps" class="mt-4" />
                <Elements :elements="natal.elements" class="mt-4" />
                <Dominant :dominant="natal.dominant_sign" class="mt-4" />
            </div>
        </div>
    </div>
    <div class="max-w-5xl pt-10 m-auto">
        <div class="grid grid-cols-[1fr_280px] gap-6">
            <div>
                <h2 class="text-2xl text-center pb-15 text-surface-200">Трактовка</h2>
                <div class="flex flex-col gap-15">
                    <div v-for="planet in natal.planets" :key="planet.name">
                        <SinglePlanet :planet="planet" />
                        <div v-if="planet.name === 'pluto'" class="w-full text-center text-xl mt-30">
                            <p>Неканонические планеты и фиктивные точки</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
