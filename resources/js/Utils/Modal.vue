<script setup lang="ts">
const props = defineProps<{
    title?: string
    show: boolean
    wide?: boolean
    ultrawide?: boolean
    confirm?: boolean  // показывать ли кнопки подтверждения
}>()

const emit = defineEmits(['update:show', 'confirm', 'cancel'])

function getWideClasses() {
    if(props.ultrawide) return 'max-w-4xl h-[90vh]';
    if(props.wide) return 'max-w-lg max-h-[90vh]';
    return 'max-w-3xl h-[90vh]';
}

const close = () => emit('update:show', false)
</script>

<template>
    <transition name="modal-fade">
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 px-4 py-6"
            @click="close"
        >
            <transition name="modal-scale">
                <div
                    v-if="show"
                    class="relative flex flex-col text-white bg-surface-700 border
                    border-surface-500 rounded-2xl shadow-2xl transition-all duration-300"
                    :class="'w-full' + getWideClasses()"
                    @click.stop
                >
                    <!-- Шапка -->
                    <div class="shrink-0 flex items-center justify-between px-7 pt-6 pb-4 border-b border-surface-500">
                        <h2 v-if="title" class="text-xl font-semibold pr-4">{{ title }}</h2>
                        <button
                            class="cursor-pointer ml-auto shrink-0 w-7 h-7 flex items-center justify-center rounded-full text-gray-400 hover:text-white hover:bg-surface-500 transition"
                            @click="close"
                        >
                            ✕
                        </button>
                    </div>

                    <!-- Контент со скроллом -->
                    <div class="scrollbar-surface flex-1 overflow-y-auto py-5 px-20
                    text-gray-300 text-md leading-relaxed">
                        <slot />
                    </div>

                    <!-- Футер с кнопками (опционально) -->
                    <div
                        v-if="confirm"
                        class="shrink-0 flex justify-end gap-3 px-7 py-5 border-t border-surface-500"
                    >
                        <button
                            class="cursor-pointer px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 bg-surface-600 hover:bg-surface-500 transition"
                            @click="emit('cancel'); close()"
                        >
                            Отмена
                        </button>
                        <button
                            class="cursor-pointer px-5 py-2.5 rounded-xl text-sm font-medium bg-blue-600 hover:bg-blue-500 active:scale-95 transition text-white"
                            @click="emit('confirm'); close()"
                        >
                            Подтвердить
                        </button>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active { transition: opacity 0.25s ease; }
.modal-fade-enter-from,
.modal-fade-leave-to    { opacity: 0; }

.modal-scale-enter-active { transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1); }
.modal-scale-leave-active { transition: all 0.18s ease; }
.modal-scale-enter-from,
.modal-scale-leave-to     { opacity: 0; transform: scale(0.92) translateY(8px); }
</style>
