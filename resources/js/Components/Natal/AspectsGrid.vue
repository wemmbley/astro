<script setup lang="ts">
import { computed, ref } from 'vue'
import PlanetIcon from "@/Icons/Zodiac/PlanetIcon.vue"
import AspectIcon from "@/Icons/Zodiac/AspectIcon.vue"
import Tooltip from "@/Utils/Tooltip.vue";
import { aspectTranslations } from "@/Lang/NatalTypesLang"
import {planetTranslations} from "../../Lang/NatalTypesLang";

const props = defineProps<{
    planets: Record<string, {
        aspects: Array<{
            name: string;
            target: string;
            orb: number;
            orbFormatted: string
        }>
    }>
}>()

const ASPECT_COLOR: Record<string, string> = {
    conjunction:    '#3b82f6', // слияние в чистом свете, начало цикла
    opposition:     '#c23c3c', // противостояние, столкновение двух истин
    square:         '#c23c3c', // трение, высекающее искру действия
    trine:          '#eebe21', // природная лёгкость, дар потока
    sextile:        '#eebe21', // свежий ветер возможностей
    semisquare:     '#c23c3c', // назойливый зуд, требующий внимания
    sesquiquadrate: '#c23c3c', // застарелое напряжение, подтачивающее изнутри
    quincunx:       '#ba54ee', // иррациональная нестыковка, вынужденная адаптация
    quintile:       '#3b82f6', // творческая искра, игра ума
    biquintile:     '#3b82f6', // оформленный талант, двойная квинтэссенция
    semisextile:    '#9ca3af', // едва заметная связь, требующая осознанности
    parallel:       '#3b82f6', // глубинный резонанс, подобный соединению на уровне склонения
    contraparallel: '#c23c3c', // скрытое противостояние, подобное оппозиции
};

const list = computed(() => Object.keys(props.planets))

const hovered = ref<{ ri: number; ci: number } | null>(null)

const isHighlighted = (ri: number, ci: number): boolean => {
    if (!hovered.value) return false
    const { ri: hr, ci: hc } = hovered.value
    const sameRow = ri === hr && ci >= hc
    const sameCol = ci === hc && ri <= hr
    return sameRow || sameCol
}

const getAspects = (row: string, col: string) => {
    const key = [row, col].sort().join('|')
    const seen = new Set<string>()
    const result: Array<{ name: string; orbFormatted: string }> = []
    for (const p of [row, col]) {
        for (const a of props.planets[p]?.aspects ?? []) {
            const akey = [p, a.target].sort().join('|')
            if (akey === key && !seen.has(a.name)) {
                seen.add(a.name)
                result.push(a)
            }
        }
    }
    return result
}
</script>

<template>
    <div>
        <table class="border-collapse table-fixed">
            <tbody>
                <tr v-for="(row, ri) in list" :key="row">
                    <td
                        v-for="(col, ci) in list.slice(0, ri + 1)"
                        :key="col"
                        class="p-0 w-9 h-9"
                        @mouseenter="hovered = { ri, ci }"
                        @mouseleave="hovered = null"
                    >
                        <!-- Диагональ — иконка планеты -->
                        <div
                            v-if="ci === ri"
                            class="w-9 h-9 flex items-center justify-center rounded transition-colors relative group"
                            :class="isHighlighted(ri, ci) ? 'bg-surface-600' : 'bg-surface-700'"
                        >
                            <PlanetIcon :planet="row.toLowerCase()" :width="20" :height="20" />
                            <Tooltip>{{ planetTranslations[row.toLowerCase()] }}</Tooltip>
                        </div>

                        <!-- Ячейка аспектов -->
                        <div
                            v-else
                            class="relative group w-9 h-9 flex flex-wrap items-center justify-center gap-px p-0.5 border border-white/8 rounded transition-colors"
                            :class="isHighlighted(ri, ci) ? 'bg-surface-600' : ''"
                        >
                            <AspectIcon
                                v-for="a in getAspects(row, col)"
                                :key="a.name"
                                :aspect="a.name"
                                :color="ASPECT_COLOR[a.name] ?? '#ffffff'"
                                :width="getAspects(row, col).length > 1 ? 13 : 19"
                                :height="getAspects(row, col).length > 1 ? 13 : 19"
                            />

                            <!-- Тултип -->
                            <div v-if="getAspects(row, col).length">
                                <div v-for="a in getAspects(row, col)" :key="a.name">
                                    <Tooltip>{{ aspectTranslations[a.name] }} {{ a.orbFormatted }}</Tooltip>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
