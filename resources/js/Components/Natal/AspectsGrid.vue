<script setup lang="ts">
import { computed } from 'vue'
import PlanetIcon from "@/Icons/Zodiac/PlanetIcon.vue"
import AspectIcon from "@/Icons/Zodiac/AspectIcon.vue"

const props = defineProps<{
    planets: Record<string, { aspects: Array<{ name: string; target: string; orb: number; orbFormatted: string }> }>
}>()

const ASPECT_COLOR: Record<string, string> = {
    conjunction:    '#a78bfa',
    opposition:     '#f87171',
    square:         '#fb923c',
    trine:          '#4ade80',
    sextile:        '#60a5fa',
    semisquare:     '#fbbf24',
    sesquiquadrate: '#f97316',
    quincunx:       '#e879f9',
    quintile:       '#2dd4bf',
    biquintile:     '#2dd4bf',
    semisextile:    '#94a3b8',
    parallel:       '#94a3b8',
    contraparallel: '#94a3b8',
}

const list = computed(() => Object.keys(props.planets))

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
    <div class="overflow-x-auto">
        <table class="border-collapse table-fixed">
            <tbody>
            <tr v-for="(row, ri) in list" :key="row">
                <!-- Ячейки: только до диагонали включительно -->
                <td v-for="(col, ci) in list.slice(0, ri + 1)" :key="col" class="p-0 w-9 h-9">

                    <!-- Диагональ — иконка планеты -->
                    <div v-if="ci === ri" class="w-9 h-9 flex items-center justify-center rounded bg-surface-700">
                        <PlanetIcon :planet="row.toLowerCase()" :width="20" :height="20" />
                    </div>

                    <!-- Ячейка аспектов -->
                    <div v-else class="w-9 h-9 flex flex-wrap items-center justify-center gap-px p-0.5 border border-white/8 rounded group relative">
                        <AspectIcon
                            v-for="a in getAspects(row, col)"
                            :key="a.name"
                            :aspect="a.name"
                            :color="ASPECT_COLOR[a.name] ?? '#ffffff'"
                            :width="getAspects(row, col).length > 1 ? 13 : 19"
                            :height="getAspects(row, col).length > 1 ? 13 : 19"
                        />
                        <!-- Тултип -->
                        <div v-if="getAspects(row, col).length" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 px-1.5 py-0.5 rounded bg-surface-900 text-white text-[10px] whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 z-50 shadow">
                            <div v-for="a in getAspects(row, col)" :key="a.name">{{ a.name }} {{ a.orbFormatted }}</div>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
