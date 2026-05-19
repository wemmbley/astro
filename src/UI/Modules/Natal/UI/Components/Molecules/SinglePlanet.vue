<script setup lang="ts">
import { computed, reactive } from 'vue'
import { useQuery } from '@tanstack/vue-query'
import { api } from '@/Helpers/Fetcher'
import { parseMarkdown, sectionsToBlocks } from '@/Helpers/Marked'
import { signTranslations, houseTranslations, planetTranslations, aspectTranslations } from '@/Modules/Natal/Domain/Locale/ZodiacLocale'
import type { AspectType, SignType, HouseType, PlanetType } from '@/Modules/Natal/Domain/Types/NatalTypes'
import { getPlanetImage } from "@/Modules/Natal/Domain/Mappers/Planets"
import { getAspectColor } from "@/Modules/Natal/Domain/Colors/AspectColor"
import PlanetIcon from "@/Resources/Icons/Zodiac/PlanetIcon.vue";
import AIIcon from "@/Resources/Icons/Other/AIIcon.vue";
import SignIcon from "@/Resources/Icons/Zodiac/SignIcon.vue";
import HouseIcon from "@/Resources/Icons/Zodiac/HouseIcon.vue";
import AspectIcon from "@/Resources/Icons/Zodiac/AspectIcon.vue";

type ParsedMd = ReturnType<typeof parseMarkdown>

const HOUSE_WORD_TO_NUMBER: Record<string, number> = {
    one: 1, two: 2, three: 3, four: 4, five: 5, six: 6,
    seven: 7, eight: 8, nine: 9, ten: 10, eleven: 11, twelve: 12,
}

const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1)

const props = defineProps<{
    planet: {
        name: string
        sign: string
        house: string
        aspects: { name: string; target: string; orb: number; orbFormatted: string }[]
    }
}>()

// ── Модалки ──────────────────────────────────────────────────────────────────
const modals = reactive<Record<string, boolean>>({})
const openModal  = (key: string) => { modals[key] = true }
const closeModal = (key: string) => { modals[key] = false }

// ── Запрос ───────────────────────────────────────────────────────────────────
const houseNumber = computed(() => HOUSE_WORD_TO_NUMBER[props.planet.house] ?? null)

const aspectsPayload = computed(() =>
    props.planet.aspects.map(a => ({
        aspect:    capitalize(a.name),
        to_planet: capitalize(a.target),
    }))
)

const { data, isLoading } = useQuery({
    queryKey: ['planet-interpret', props.planet.name, props.planet.sign, props.planet.house],
    queryFn: () => api(`natal/interpret/planet/${capitalize(props.planet.name)}`, {
        method: 'POST',
        body: JSON.stringify({
            sign:    capitalize(props.planet.sign),
            house:   houseNumber.value,
            aspects: aspectsPayload.value,
        }),
    }),
})

const interpret = computed(() => data.value?.interpret ?? null)
const tags = computed(() => entityMd.value?.attributes?.tags ?? [])

// ── Все блоки для модалки ─────────────────────────────────────────────────────
const allBlocks = (md: ParsedMd | null) => {
    if (!md) return []
    return sectionsToBlocks(md.sections)
}

// Первый абзац секции "Описание" — для превью
const descriptionFirstPara = (md: ParsedMd | null): string | null => {
    if (!md) return null
    const descSection =
        md.get('Описание') ??
        md.byLevel(2)[0] ??
        null
    return descSection?.blocks?.find(b => b.type === 'paragraph')?.text ?? null
}

// ── Парсинг ───────────────────────────────────────────────────────────────────
const entityMd = computed(() => interpret.value?.entity  ? parseMarkdown(interpret.value.entity)  : null)
const signMd   = computed(() => interpret.value?.sign    ? parseMarkdown(interpret.value.sign)    : null)
const houseMd  = computed(() => interpret.value?.house   ? parseMarkdown(interpret.value.house)   : null)

const entityTitle     = computed(() => entityMd.value?.byLevel(1)[0]?.heading ?? planetTranslations[props.planet.name as PlanetType])
const entityFirstPara = computed(() => descriptionFirstPara(entityMd.value))
const signFirstPara   = computed(() => descriptionFirstPara(signMd.value))
const houseFirstPara  = computed(() => descriptionFirstPara(houseMd.value))

// ── Аспекты map ───────────────────────────────────────────────────────────────
const aspectMdMap = computed(() => {
    const map: Record<string, ParsedMd> = {}
    if (!interpret.value?.aspects?.length) return map
    for (const a of interpret.value.aspects) {
        if (!a.content) continue
        const key = `${a.aspect.toLowerCase()}-${a.to_planet.toLowerCase()}`
        map[key] = parseMarkdown(a.content)
    }
    return map
})

const aspectKey = (name: string, target: string) => `${name.toLowerCase()}-${target.toLowerCase()}`
</script>

<template>
    <div class="mb-5">
        <div v-if="isLoading" class="h-40 w-full animate-pulse rounded-md bg-surface-700"/>
        <div v-else class="flex gap-5 items-stretch">
            <div class="shrink-0 w-50 h-110">
                <img
                    v-if="getPlanetImage(planet.name)"
                    :src="getPlanetImage(planet.name)"
                    class="w-full h-full object-cover rounded-xl"
                    alt="planet image preview" />
                <div v-else class="w-full h-full flex items-center justify-center">
                    <PlanetIcon :planet="planet.name" :width="48" :height="48" />
                </div>
            </div>
            <div class="flex flex-col gap-4 flex-1 min-w-0">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <div class="flex gap-2">
                            <PlanetIcon :planet="planet.name" :width="20" :height="20" />
                            <h2 class="font-semibold text-amber-300">{{ entityTitle }}</h2>
                        </div>
                        <div class="
                        text-accent border border-surface-600 bg-surface-700 rounded p-1.5
                        hover:bg-surface-600 transition cursor-pointer
                        "
                        @click="openModal('ai')">
                            <AIIcon :width="18" :height="18" />
                        </div>
                    </div>
                    <div v-if="tags.length" class="flex flex-wrap gap-1">
                    <span
                        v-for="tag in tags"
                        :key="tag"
                        class="text-[14px] text-surface-200 py-0.5">
                        {{ tag }},
                    </span>
                    </div>
                    <p
                        v-if="entityFirstPara"
                        class="text-sm text-gray-300"
                        @click="openModal('entity')">
                        {{ entityFirstPara }}
                        <span class="inline-flex text-accent">
                                <span class="
                                    transition ml-2 hover:text-surface-100 hover:underline cursor-pointer">
                                    ...читать далее
                                </span>
                        </span>
                    </p>
                </div>
                <div class="flex items-start gap-2">
                    <div class="flex flex-col gap-0.5">
                        <span class="flex text-sm font-medium text-amber-300 mb-1">
                            <SignIcon :sign="planet.sign" width="20" height="20" class="mr-1.5 shrink-0" />
                            {{ signTranslations[planet.sign as SignType] }}
                        </span>
                        <p v-if="signFirstPara"
                           class="text-sm text-gray-300"
                           @click="openModal('sign')">
                            {{ signFirstPara }}
                            <span class="inline-flex text-accent">
                                <span class="
                                    transition ml-2 hover:text-surface-100 hover:underline cursor-pointer">
                                    ...читать далее
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="flex flex-col gap-0.5">
                        <span class="flex text-sm font-medium text-amber-300 mb-1">
                            <HouseIcon :house="planet.house" width="20" height="20" class="mr-1.5 shrink-0" />
                            {{ houseTranslations[planet.house as HouseType] }}
                        </span>
                        <p v-if="houseFirstPara"
                           class="text-sm text-gray-300"
                           @click="openModal('house')">
                            {{ houseFirstPara }}
                            <span class="inline-flex text-accent">
                                <span class="
                                transition ml-2 hover:text-surface-100 hover:underline cursor-pointer">
                                    ...читать далее
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
                <div v-if="planet.aspects?.length" class="flex flex-col gap-2">
                    <h3 class="flex text-sm text-surface-50 mb-1">Аспекты</h3>
                    <div
                        v-for="aspect in planet.aspects"
                        :key="aspectKey(aspect.name, aspect.target)"
                        class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"
                        @click="openModal(aspectKey(aspect.name, aspect.target))">
                        <AspectIcon
                            :aspect="aspect.name"
                            :width="16"
                            :height="16"
                            :style="{ color: getAspectColor(aspect.name) }"/>
                        <span class="text-xs text-gray-400 hover:text-accent">
                            {{ aspectTranslations[aspect.name as AspectType] }}
                            {{ planetTranslations[aspect.target as PlanetType] }}
                        </span>
                        <PlanetIcon :planet="aspect.target" :width="16" :height="16" />
                        <span class="ml-auto text-xs font-mono text-surface-400">
                            {{ aspect.orbFormatted }}
                        </span>
                    </div>
                </div>
                <div class="font-medium uppercase text-xs flex justify-center
                        text-accent/80 border border-surface-600 bg-surface-700 rounded p-1.5
                        hover:bg-surface-600 transition cursor-pointer"
                    @click="openModal('aiFull')">
                    <AIIcon :width="20" :height="20" />
                    <p class="pl-2">Читать полную легенду</p>
                </div>
            </div>
        </div>
    </div>
</template>
