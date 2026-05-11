<script setup lang="ts">
import { computed } from 'vue'
import {
    signTranslations,
    houseTranslations,
    planetTranslations,
} from '@/Lang/NatalTypesLang'
import PlanetIcon from '@/Icons/Zodiac/PlanetIcon.vue'
import SignIcon from '@/Icons/Zodiac/SignIcon.vue'
import HouseIcon from '@/Icons/Zodiac/HouseIcon.vue'
import Tooltip from '@/Utils/Tooltip.vue'

const props = defineProps<{ natal: any }>()

const houseOrder = [
    'one','two','three','four','five','six',
    'seven','eight','nine','ten','eleven','twelve',
]

const signRulers: Record<string, string> = {
    aries:       'mars',
    taurus:      'venus',
    gemini:      'mercury',
    cancer:      'moon',
    leo:         'sun',
    virgo:       'mercury',
    libra:       'venus',
    scorpio:     'pluto',
    sagittarius: 'jupiter',
    capricorn:   'saturn',
    aquarius:    'uranus',
    pisces:      'neptune',
}

const houseChains = computed(() =>
    houseOrder.map(houseKey => {
        const cusp             = props.natal.cusps[houseKey]
        const rulerName        = signRulers[cusp.sign]
        const rulerPlanet      = props.natal.planets[rulerName]
        const dispositorName   = signRulers[rulerPlanet.sign]
        const isSelfDispositor = dispositorName === rulerName
        const planetsInHouse   = Object.values(props.natal.planets).filter(
            (p: any) => p.house === houseKey
        )
        return { houseKey, cusp, rulerName, rulerPlanet, dispositorName, isSelfDispositor, planetsInHouse }
    })
)
</script>

<template>
    <div class="grid grid-cols-12">
        <div
            v-for="chain in houseChains"
            :key="chain.houseKey"
            class="flex flex-col items-center py-2 px-0.5"
        >
            <!-- 1. Диспозитор -->
            <div class="relative group cursor-default mb-2">
                <PlanetIcon :planet="chain.dispositorName" width="26" height="26" />
                <Tooltip>
                    Диспозитор {{ planetTranslations[chain.dispositorName] }}
                    <template v-if="chain.isSelfDispositor"> — в своём знаке</template>
                </Tooltip>
            </div>

            <!-- Линия вниз от диспозитора -->
            <div class="w-px h-4 bg-surface-600 mt-2" />

            <!-- 2. Три луча → управитель (планета + знак + дом) -->
            <div class="relative w-full mb-5">
                <!-- Иконки управителя -->
                <div class="flex justify-around pt-4 mt-5">
                    <div class="relative group cursor-default">
                        <PlanetIcon :planet="chain.rulerName" width="20" height="20" />
                        <Tooltip>{{ planetTranslations[chain.rulerName] }}</Tooltip>
                    </div>
                    <div class="relative group cursor-default">
                        <SignIcon :sign="chain.rulerPlanet.sign" width="20" height="20" />
                        <Tooltip>{{ signTranslations[chain.rulerPlanet.sign] }}</Tooltip>
                    </div>
                    <div class="relative group cursor-default">
                        <HouseIcon :house="chain.rulerPlanet.house" width="20" height="20" />
                        <Tooltip>{{ houseTranslations[chain.rulerPlanet.house] }}</Tooltip>
                    </div>
                </div>
                <!-- SVG с тремя лучами из центральной точки вниз -->
                <svg
                    class="absolute top-0 left-0 w-full text-surface-600"
                    height="14"
                    viewBox="0 0 100 14"
                    preserveAspectRatio="none"
                >
                    <line x1="50" y1="0" x2="17" y2="14"
                          stroke="currentColor" stroke-width="1.5"
                          vector-effect="non-scaling-stroke" />
                    <line x1="50" y1="0" x2="50" y2="14"
                          stroke="currentColor" stroke-width="1.5"
                          vector-effect="non-scaling-stroke" />
                    <line x1="50" y1="0" x2="83" y2="14"
                          stroke="currentColor" stroke-width="1.5"
                          vector-effect="non-scaling-stroke" />
                </svg>
            </div>

            <!-- 3. Знак куспида -->
            <div class="relative group cursor-default mt-2 mb-4">
                <SignIcon :sign="chain.cusp.sign" width="26" height="26" />
                <Tooltip>{{ signTranslations[chain.cusp.sign] }} — {{ chain.cusp.degreeFormatted }}</Tooltip>
            </div>

            <!-- 4. Номер дома -->
            <div class="relative group cursor-default">
                <HouseIcon :house="chain.houseKey" width="26" height="26" />
                <Tooltip>{{ houseTranslations[chain.houseKey] }}</Tooltip>
            </div>
            <div class="w-px h-4 bg-surface-600 mt-2" />
            <!-- SVG с тремя лучами из центральной точки вниз -->
            <svg
                class="text-surface-600 mb-5"
                height="14"
                viewBox="0 0 100 14"
                preserveAspectRatio="none"
            >
                <line x1="50" y1="0" x2="17" y2="14"
                      stroke="currentColor" stroke-width="1.5"
                      vector-effect="non-scaling-stroke" />
                <line x1="50" y1="0" x2="50" y2="14"
                      stroke="currentColor" stroke-width="1.5"
                      vector-effect="non-scaling-stroke" />
                <line x1="50" y1="0" x2="83" y2="14"
                      stroke="currentColor" stroke-width="1.5"
                      vector-effect="non-scaling-stroke" />
            </svg>

            <!-- 5. Планеты в доме: иконка + знак + дом + градус -->
            <template v-if="chain.planetsInHouse.length">
                <div
                    v-for="planet in chain.planetsInHouse"
                    :key="planet.name"
                    class="flex items-center gap-0.5 mb-1"
                >
                    <div class="relative group cursor-default">
                        <PlanetIcon :planet="planet.name" width="22" height="22" />
                        <Tooltip>
                            {{ planetTranslations[planet.name] }}
                            <template v-if="planet.retrograde"> ℞</template>
                        </Tooltip>
                    </div>
<!--                    <div class="relative group cursor-default">-->
<!--                        <SignIcon :sign="planet.sign" width="18" height="18" />-->
<!--                        <Tooltip>{{ signTranslations[planet.sign] }}</Tooltip>-->
<!--                    </div>-->
<!--                    <div class="relative group cursor-default">-->
<!--                        <HouseIcon :house="planet.house" width="18" height="18" />-->
<!--                        <Tooltip>{{ houseTranslations[planet.house] }}</Tooltip>-->
<!--                    </div>-->
<!--                    <span class="text-[9px] text-cream/50 leading-none">{{ planet.degreeFormatted }}</span>-->
                </div>
            </template>
            <div v-else class="text-xs opacity-20 select-none">·</div>
        </div>
    </div>
</template>
