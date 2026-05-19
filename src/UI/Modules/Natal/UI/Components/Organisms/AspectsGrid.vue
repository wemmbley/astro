<script setup lang="ts">
import { computed, ref } from 'vue'
import PlanetIcon from "@/Resources/Icons/Zodiac/PlanetIcon.vue"
import AspectIcon from "@/Resources/Icons/Zodiac/AspectIcon.vue"
import Tooltip from "@/Modules/Shared/Components/Tooltip.vue";
import { aspectTranslations, planetTranslations } from "@/Modules/Natal/Domain/Locale/ZodiacLocale"
import { getAspectColor } from "@/Modules/Natal/Domain/Colors/AspectColor"
import { Planet } from "@/Modules/Natal/Domain/Types/NatalTypes"

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

const props = defineProps<{
    planets: Planet[],
}>()
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
                        <div
                            v-if="ci === ri"
                            class="w-9 h-9 flex items-center justify-center rounded transition-colors relative group"
                            :class="isHighlighted(ri, ci) ? 'bg-surface-600' : 'bg-surface-700'"
                        >
                            <PlanetIcon :planet="row.toLowerCase()" :width="20" :height="20" />
                            <Tooltip>{{ planetTranslations[row.toLowerCase()] }}</Tooltip>
                        </div>
                        <div
                            v-else
                            class="relative group w-9 h-9 flex flex-wrap items-center justify-center gap-px p-0.5 border border-white/8 rounded transition-colors"
                            :class="isHighlighted(ri, ci) ? 'bg-surface-600' : ''"
                        >
                            <AspectIcon
                                v-for="aspect in getAspects(row, col)"
                                :key="aspect.name"
                                :aspect="aspect.name"
                                :color="getAspectColor(aspect.name) ?? '#ffffff'"
                                :width="getAspects(row, col).length > 1 ? 13 : 19"
                                :height="getAspects(row, col).length > 1 ? 13 : 19"
                            />
                            <div v-if="getAspects(row, col).length">
                                <div v-for="aspect in getAspects(row, col)" :key="aspect.name">
                                    <Tooltip>
                                        {{ aspectTranslations[aspect.name] }} {{ aspect.orbFormatted }}
                                    </Tooltip>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
