<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";

type Aspect = {
    icon: string
    type: 'conj' | 'sext' | 'chir' | 'cont'
    name: string
    link?: string
    orb: string
    direction?: 'in' | 'out'
}

type PlanetSection = {
    icon: string
    colorClass: string
    label: string
    title: string
    text: string
    link?: string
}

type Planet = {
    icon: string
    name: string
    subtitle: string
    description: string
    chips: string[]
    image: string
    sections: PlanetSection[]
    aspects: Aspect[]
}

defineProps<{
    planets: Planet[]
    navbar?: Array<any>
}>()
</script>

<template>
    <MainLayout :navbar="navbar">
        <div class="flex flex-col gap-4">
            <div v-for="planet in planets" :key="planet.name"
                 class="bg-surface-700 border border-surface-600 rounded-2xl overflow-hidden flex">

                <!-- Арт слева -->
                <div class="w-36 flex-shrink-0 relative overflow-hidden">
                    <img :src="planet.image"
                         class="w-full h-full object-cover object-top"/>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-surface-700"/>
                </div>

                <!-- Контент -->
                <div class="flex-1 min-w-0 flex flex-col p-5 pl-4">

                    <!-- Шапка -->
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center text-xl
                                        bg-accent/12 border border-accent/20">
                                {{ planet.icon }}
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-[9px] font-bold uppercase tracking-[0.12em] text-cream/28">Планета</span>
                                <span class="text-[15px] font-bold text-cream/92 leading-tight">{{ planet.name }}</span>
                                <span class="text-[11px] text-cream/35">{{ planet.subtitle }}</span>
                            </div>
                        </div>
                        <div class="flex gap-1.5 flex-wrap">
                            <span v-for="chip in planet.chips" :key="chip"
                                  class="text-[10px] font-semibold text-accent bg-accent/10
                                         border border-accent/18 px-2 py-0.5 rounded-lg">
                                {{ chip }}
                            </span>
                        </div>
                    </div>

                    <p class="text-[11px] text-cream/38 leading-relaxed mb-3">
                        {{ planet.description }}
                    </p>

                    <div class="h-px bg-white/5 mb-3"/>

                    <!-- Знак и дом -->
                    <div class="flex flex-col gap-3 mb-3">
                        <div v-for="section in planet.sections" :key="section.title"
                             class="flex gap-2.5 items-start">
                            <div :class="['w-7 h-7 rounded-lg flex-shrink-0 flex items-center justify-center text-[13px] mt-0.5', section.colorClass]">
                                {{ section.icon }}
                            </div>
                            <div class="flex flex-col gap-0.5 min-w-0">
                                <span class="text-[9px] font-bold uppercase tracking-[0.1em] text-cream/27">{{ section.label }}</span>
                                <span class="text-[12px] font-semibold text-cream/75">{{ section.title }}</span>
                                <span class="text-[11px] text-cream/37 leading-relaxed line-clamp-3">{{ section.text }}</span>
                                <a v-if="section.link" :href="section.link"
                                   class="text-[10px] text-accent border-b border-accent/25 w-fit mt-0.5">
                                    Подробнее →
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-white/5 mb-3"/>

                    <!-- Аспекты -->
                    <div>
                        <div class="text-[9px] font-bold uppercase tracking-[0.12em] text-cream/27 mb-2">Аспекты</div>
                        <div class="flex flex-col">
                            <div v-for="asp in planet.aspects" :key="asp.name"
                                 class="flex items-center gap-2 py-1.5 border-b border-white/[0.04] last:border-0 last:pb-0">
                                <div :class="['w-[22px] h-[22px] rounded-[6px] flex-shrink-0 flex items-center justify-center text-[11px]',
                                              asp.type === 'conj' ? 'bg-accent/13' :
                                              asp.type === 'sext' ? 'bg-emerald-500/13' :
                                              asp.type === 'chir' ? 'bg-amber-500/13' : 'bg-orange-700/12']">
                                    {{ asp.icon }}
                                </div>
                                <span class="flex-1 text-[11px] font-medium text-cream/65 min-w-0 truncate">
                                    <a v-if="asp.link" :href="asp.link" class="border-b border-cream/12">{{ asp.name }}</a>
                                    <template v-else>{{ asp.name }}</template>
                                </span>
                                <span class="text-[10px] text-cream/25 bg-surface-600 rounded-[5px] px-1.5 py-0.5">
                                    {{ asp.orb }}
                                </span>
                                <span v-if="asp.direction"
                                      :class="['text-[9px] font-bold uppercase px-1.5 py-0.5 rounded-[5px]',
                                               asp.direction === 'in' ? 'text-accent bg-accent/12' : 'text-cream/25 bg-white/5']">
                                    {{ asp.direction === 'in' ? 'сх.' : 'расх.' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </MainLayout>
</template>
