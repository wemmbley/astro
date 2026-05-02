<script setup lang="ts">
defineProps<{
    title?: string
    show: boolean
}>()

const emit = defineEmits(['update:show', 'confirm', 'cancel'])

const close = () => emit('update:show', false)
</script>

<template>
    <transition name="modal-fade">
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 px-4"
            @click="close"
        >
            <transition name="modal-scale">
                <div
                    v-if="show"
                    class="relative w-full max-w-lg text-white bg-surface-700 border border-surface-500 rounded-2xl shadow-2xl"
                    @click.stop
                >
                    <button
                        class="cursor-pointer absolute top-4 right-4 w-7 h-7 flex items-center justify-center rounded-full text-gray-400 hover:text-white hover:bg-surface-500 transition"
                        @click="close"
                    >
                        ✕
                    </button>

                    <div class="p-7">
                        <h2 v-if="title" class="text-xl font-semibold pr-8">{{ title }}</h2>

                        <div class="mt-4 text-gray-300 text-sm leading-relaxed">
                            <slot />
                        </div>

                        <div class="mt-7 flex justify-end gap-3">
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
