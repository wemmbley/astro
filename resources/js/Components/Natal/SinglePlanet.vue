<script setup lang="ts">
import { computed, reactive } from 'vue'
import { useQuery } from '@tanstack/vue-query'
import { api } from '@/Libs/Fetcher'
import { parseMarkdown, sectionsToBlocks } from '@/Libs/Marked'
import Modal from '@/Utils/Modal.vue'
import Markdown from '@/Utils/Markdown.vue'
import PlanetIcon from '@/Icons/Zodiac/PlanetIcon.vue'
import SignIcon from '@/Icons/Zodiac/SignIcon.vue'
import HouseIcon from '@/Icons/Zodiac/HouseIcon.vue'
import AspectIcon from '@/Icons/Zodiac/AspectIcon.vue'
import { signTranslations, houseTranslations, planetTranslations, aspectTranslations } from '@/Lang/NatalTypesLang'
import type { AspectType, SignType, HouseType, PlanetType } from '@/Types/NatalTypes'
import AIIcon from "@/Icons/AIIcon.vue";
import { getPlanetImage } from "@/Mappers/PlanetImages"
import { getAspectColor } from "@/Mappers/AspectColor"

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
    <!-- ── Модалка: AI ───────────────────────────────────────────────── -->
    <Modal :title="entityTitle" :show="!!modals['ai']" @update:show="closeModal('ai')">
        <div class="space-y-4 text-sm leading-6">
            <p>
                Получите возможность лично пообщаться с профессиональным
                AI-астрологом и задать любой вопрос о Вашей Планете,
                её влиянии на жизнь, характер, отношения, внутренние конфликты,
                реализации и жизненных сценариях.
            </p>
            <p>
                В отличие от кратких трактовок, диалог позволяет
                разбирать Вашу карту глубоко и целостно —
                с учётом Знака, Дома, аспектов и взаимосвязей
                со всеми остальными Планетами.
            </p>
            <ul class="list-disc pl-5 space-y-1">
                <li>любые вопросы без ограничений по теме;</li>
                <li>глубокие и связанные ответы вместо шаблонов;</li>
                <li>анализ психологических и событийных проявлений;</li>
                <li>разбор сильных сторон и внутренних противоречий;</li>
                <li>живой интерактивный формат общения.</li>
            </ul>
            <p>
                AI обучен на профессиональных авторских материалах
                и ведёт диалог на основе именно Вашей натальной карты.
            </p>
            <div class="pt-2 border-t border-surface-500">
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-70">Доступ к AI-диалогу</span>
                    <span class="text-lg font-semibold">58 грн</span>
                </div>
                <button class="text-accent border border-accent w-full mt-4 rounded-xl py-3 font-medium">
                    Начать диалог
                </button>
            </div>
        </div>
    </Modal>

    <!-- ── Модалка: AI Collect Text ──────────────────────────────────────── -->
    <Modal :title="entityTitle" :show="!!modals['aiFull']" @update:show="closeModal('aiFull')">
        <div class="space-y-4 text-sm leading-6">
            <p>
                Получите целостную и глубокую трактовку Вашей Планеты,
                созданную на основе профессиональной астрологической системы
                и авторской базы интерпретаций.
            </p>
            <p>Анализ включает:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>положение Планеты в Знаке и Доме;</li>
                <li>влияние всех аспектов и взаимосвязей;</li>
                <li>психологические и событийные проявления;</li>
                <li>сильные стороны, внутренние противоречия и потенциал реализации;</li>
                <li>единое цельное описание без разрозненных фрагментов.</li>
            </ul>
            <p>
                Текст генерируется персонально по Вашей натальной карте
                и формирует полноценный связный портрет вместо набора
                отдельных трактовок. Вам не придётся пытаться самостоятельно
                собирать фрагментированную информацию - полная картина будет
                перед Вами.
            </p>
            <p class="text-surface-300">
                * Далее Вы сможете пообщаться с AI
                в обычном формате вопрос-ответ, по цене 58грн за сообщение,
                если у Вас будут уточняющие вопросы.
            </p>
            <div class="pt-2 border-t border-surface-500">
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-70">Полный разбор</span>
                    <span class="text-lg font-semibold">71 грн</span>
                </div>
                <button class="text-accent border border-accent w-full mt-4 rounded-xl py-3 font-medium">
                    Получить полный анализ
                </button>
            </div>
        </div>
    </Modal>

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
