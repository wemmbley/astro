<script setup lang="ts">
import Modal from "@/Modules/Shared/Components/Modal.vue";


</script>

<template>
    <Modal ultrawide :title="entityTitle + ' AI Астролог'" :show="!!modals['ai']" @update:show="closeModal('ai')">
        <div class="flow-root text-sm leading-relaxed text-pretty">
            <img
                :src="getPlanetArchetypeImage('astrologer')"
                alt="astrologer"
                class="float-left mr-6 mb-4 w-1/3 max-w-100 rounded-2xl shadow-lg ring-1 ring-white/10"
            />
            <div class="space-y-4">
                <p class="font-medium text-base text-white/90">
                    Получите возможность лично пообщаться с профессиональным
                    AI-астрологом и задать любой вопрос о Вашей Планете.
                </p>
                <p>
                    В отличие от кратких трактовок, диалог позволяет
                    разбирать Вашу карту глубоко и целостно —
                    с учётом Знака, Дома, аспектов и взаимосвязей
                    со всеми остальными Планетами.
                </p>
                <ul class="list-disc pl-5 space-y-1 italic opacity-90">
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
            </div>
            <div class="mt-8 pt-4 border-t border-white/10 clear-both">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm opacity-60 uppercase tracking-wider">Доступ к AI-диалогу</span>
                    <span class="text-2xl font-light tracking-tight">58 грн</span>
                </div>
                <button class="w-full py-4 rounded-2xl bg-linear-to-r from-accent/20 to-accent/10 border border-accent/50 text-accent hover:bg-accent/30 transition-all font-semibold uppercase tracking-widest text-xs">
                    Начать диалог
                </button>
            </div>
        </div>
    </Modal>
</template>
