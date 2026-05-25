<script setup>
import { signTranslations, planetTranslations } from '@/Modules/Natal/Domain/Locale/ZodiacLocale';
import { zodiacIcons } from '@/Modules/Natal/Domain/Icons/ZodiacIcons';
import { tarotNames } from '@/Modules/Tarot/Types/TarotNames';

const miniProfile = {
    sun: 'capricorn',
    moon: 'scorpio',
    asc: 'cancer',
    arcana: 'hermit',
};
</script>

<template>
    <div class="bg-surface-800 border border-surface-600 rounded-xl shadow-sm p-5 w-full">
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="text-center">
                <div class="text-surface-400 mb-1 flex justify-center">
                    <component :is="zodiacIcons[miniProfile.sun]" size="24" />
                </div>
                <div class="text-[10px] uppercase text-surface-300 font-bold">
                    {{ planetTranslations.sun }}
                </div>
                <div class="font-bold text-surface-50">
                    {{ signTranslations[miniProfile.sun] }}
                </div>
            </div>
            <div class="text-center border-surface-100">
                <div class="text-surface-400 mb-1 flex justify-center">
                    <component :is="zodiacIcons[miniProfile.moon]" size="24" />
                </div>
                <div class="text-[10px] uppercase text-surface-300 font-bold">
                    {{ planetTranslations.moon }}
                </div>
                <div class="font-bold text-surface-50">
                    {{ signTranslations[miniProfile.moon] }}
                </div>
            </div>
            <div class="text-center">
                <div class="text-surface-400 mb-1 flex justify-center">
                    <component :is="zodiacIcons[miniProfile.asc]" size="24" />
                </div>
                <div class="text-[10px] uppercase text-surface-300 font-bold">
                    {{ planetTranslations.asc }}
                </div>
                <div class="font-bold text-surface-50">
                    {{ signTranslations[miniProfile.asc] }}
                </div>
            </div>
        </div>
        <div class="bg-surface-700 rounded p-3 text-center">
            <span class="text-surface-300">Аркан: </span>
            <span class="font-medium text-surface-100 underline-offset-4">
                {{ tarotNames[miniProfile.arcana] }}
            </span>
        </div>
    </div>
</template>
