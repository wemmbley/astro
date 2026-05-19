<script setup lang="ts">
import Modal from "@/Modules/Shared/Components/Modal.vue";
</script>

<template>
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
</template>
