<script setup lang="ts">
import { computed, reactive } from 'vue'
import { useQuery } from '@tanstack/vue-query'
import { api } from '@/Libs/Fetcher'
import { parseMarkdown } from '@/Libs/Marked'
import Modal from '@/Utils/Modal.vue'
import Markdown from '@/Utils/Markdown.vue'
import PlanetIcon from '@/Icons/Zodiac/PlanetIcon.vue'
import SignIcon from '@/Icons/Zodiac/SignIcon.vue'
import HouseIcon from '@/Icons/Zodiac/HouseIcon.vue'
import AspectIcon from '@/Icons/Zodiac/AspectIcon.vue'
import { signTranslations, houseTranslations, planetTranslations, aspectTranslations } from '@/Lang/NatalTypesLang'
import type { AspectType, SignType, HouseType, PlanetType } from '@/Types/NatalTypes'
import sunImage from '@/../img/Astro/PlanetArts/Sun.jpg'
import moonImage from '@/../img/Astro/PlanetArts/Moon.png'

type ParsedMd = ReturnType<typeof parseMarkdown>

const IMAGE_NAME_MAPPER: Record<string, string> = {
    sun: sunImage,
    moon: moonImage,
}

const HOUSE_WORD_TO_NUMBER: Record<string, number> = {
    one: 1, two: 2, three: 3, four: 4, five: 5, six: 6,
    seven: 7, eight: 8, nine: 9, ten: 10, eleven: 11, twelve: 12,
}

const ASPECT_COLOR: Record<string, string> = {
    conjunction: '#3b82f6',
    opposition:  '#c23c3c',
    square:      '#c23c3c',
    trine:       '#eebe21',
    sextile:     '#eebe21',
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

// ── Все блоки для модалки (h1 + h2 + все подуровни) ─────────────────────────
const allBlocks = (md: ParsedMd | null) => {
    if (!md) return []
    const blocks: any[] = []
    for (let level = 1; level <= 4; level++) {
        const sections = md.byLevel(level) ?? []
        for (const section of sections) {
            if (section.heading) {
                blocks.push({ type: 'heading', text: section.heading, level })
            }
            for (const b of section.blocks ?? []) {
                if (!blocks.includes(b)) blocks.push(b)
            }
        }
    }
    return blocks
}

// Первый абзац секции "Описание" (вторая h1, индекс 1) — для превью
const descriptionFirstPara = (md: ParsedMd | null): string | null => {
    if (!md) return null
    const sections = md.byLevel(2)
    // ищем секцию с заголовком "Описание" или берём вторую
    const descSection = sections.find((s: any) =>
        s.heading?.toLowerCase() === 'описание'
    ) ?? sections[1] ?? null
    return descSection?.blocks?.find((b: any) => b.type === 'paragraph')?.text ?? null
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
        // ключ в нижнем регистре для надёжного поиска
        const key = `${a.aspect.toLowerCase()}-${a.to_planet.toLowerCase()}`
        map[key] = parseMarkdown(a.content)
    }
    return map
})

const aspectKey = (name: string, target: string) => `${name.toLowerCase()}-${target.toLowerCase()}`
</script>

<template>
    <!-- ── Модалка: entity ───────────────────────────────────────────────── -->
    <Modal wide :title="entityTitle" :show="!!modals['entity']" @update:show="closeModal('entity')">
        <Markdown :blocks="allBlocks(entityMd)" />
    </Modal>

    <!-- ── Модалка: знак ─────────────────────────────────────────────────── -->
    <Modal wide
        :title="signTranslations[planet.sign as SignType]"
        :show="!!modals['sign']"
        @update:show="closeModal('sign')"
    >
        <Markdown :blocks="allBlocks(signMd)" />
    </Modal>

    <!-- ── Модалка: дом ──────────────────────────────────────────────────── -->
    <Modal wide
        :title="houseTranslations[planet.house as HouseType]"
        :show="!!modals['house']"
        @update:show="closeModal('house')"
    >
        <Markdown :blocks="allBlocks(houseMd)" />
    </Modal>

    <!-- ── Модалки: аспекты ──────────────────────────────────────────────── -->
    <template v-for="a in planet.aspects" :key="`modal-${a.name}-${a.target}`">
        <Modal wide
            :title="`${aspectTranslations[a.name as AspectType]} → ${planetTranslations[a.target as PlanetType]}`"
            :show="!!modals[aspectKey(a.name, a.target)]"
            @update:show="closeModal(aspectKey(a.name, a.target))"
        >
            <Markdown :blocks="allBlocks(aspectMdMap[aspectKey(a.name, a.target)] ?? null)" />
        </Modal>
    </template>

    <!-- ── Карточка ──────────────────────────────────────────────────────── -->
    <div class="mb-5">
        <div v-if="isLoading" class="h-40 w-full animate-pulse rounded-md bg-surface-700"/>

        <div v-else class="flex gap-5 items-stretch">

            <!-- Левый столбец: изображение -->
            <div class="shrink-0 w-38 h-110">
                <img
                    v-if="IMAGE_NAME_MAPPER[planet.name]"
                    :src="IMAGE_NAME_MAPPER[planet.name]"
                    class="w-full h-full object-cover rounded-xl"
                />
                <div v-else class="w-full h-full flex items-center justify-center">
                    <PlanetIcon :planet="planet.name" :width="48" :height="48" />
                </div>
            </div>

            <!-- Правый столбец: контент -->
            <div class="flex flex-col gap-4 flex-1 min-w-0">

                <!-- Entity -->
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <PlanetIcon :planet="planet.name" :width="20" :height="20" />
                        <h2 class="font-semibold text-amber-300">{{ entityTitle }}</h2>
                    </div>
                    <!-- Тэги -->
                    <div v-if="tags.length" class="flex flex-wrap gap-1">
                    <span
                        v-for="tag in tags"
                        :key="tag"
                        class="text-xs text-gray-400 bg-surface-700 px-2 py-0.5 rounded-full"
                    >
                        {{ tag }}
                    </span>
                    </div>
                    <p v-if="entityFirstPara" class="text-sm text-gray-300">
                        {{ entityFirstPara }}
                    </p>
                    <button class="text-xs text-accent hover:text-white transition self-start" @click="openModal('entity')">
                        ...читать подробнее
                    </button>
                </div>

                <!-- Знак -->
                <div class="flex items-start gap-2">
                    <SignIcon :sign="planet.sign" width="18" height="18" class="mt-0.5 shrink-0" />
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm font-medium text-amber-300">
                            {{ signTranslations[planet.sign as SignType] }}
                        </span>
                        <p v-if="signFirstPara" class="text-[13px] text-surface-100">
                            {{ signFirstPara }}
                        </p>
                        <button
                            v-if="signMd"
                            class="text-xs text-accent hover:text-white transition self-start"
                            @click="openModal('sign')"
                        >
                            ...подробнее
                        </button>
                    </div>
                </div>

                <!-- Дом -->
                <div class="flex items-start gap-2">
                    <HouseIcon :house="planet.house" width="24" height="24" class="mt-0.5 shrink-0" />
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm font-medium text-amber-300">
                            {{ houseTranslations[planet.house as HouseType] }}
                        </span>
                        <p v-if="houseFirstPara" class="text-[13px] text-surface-100">
                            {{ houseFirstPara }}
                        </p>
                        <button
                            v-if="houseMd"
                            class="text-xs text-accent hover:text-white transition self-start"
                            @click="openModal('house')"
                        >
                            ...подробнее
                        </button>
                    </div>
                </div>

                <!-- Аспекты -->
                <div v-if="planet.aspects.length" class="flex flex-col gap-2">
                    <h3 class="text-xs uppercase tracking-wider text-gray-500">Аспекты</h3>
                    <div
                        v-for="a in planet.aspects"
                        :key="aspectKey(a.name, a.target)"
                        class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition"
                        @click="openModal(aspectKey(a.name, a.target))"
                    >
                        <PlanetIcon :planet="planet.name" :width="16" :height="16" />
                        <AspectIcon
                            :aspect="a.name"
                            :width="16"
                            :height="16"
                            :style="{ color: ASPECT_COLOR[a.name] }"
                        />
                        <PlanetIcon :planet="a.target" :width="16" :height="16" />
                        <span class="text-xs text-gray-400">
                            {{ aspectTranslations[a.name as AspectType] }}
                            {{ planetTranslations[a.target as PlanetType] }}
                        </span>
                        <!-- Орб бейджик -->
                        <span class="ml-auto text-xs font-mono text-surface-400">
                            {{ a.orbFormatted }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
