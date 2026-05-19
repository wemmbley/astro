<script setup lang="ts">
type Tab = {
    key: string
    label: string
}

const props = defineProps<{
    tabs: Tab[]
    modelValue: string
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void
}>()

const setActive = (key: string) => {
    emit('update:modelValue', key)
}
</script>

<template>
    <div class="flex items-center gap-1 p-1 rounded-xl">
        <button
            v-for="tab in tabs"
            :key="tab.key"
            @click="setActive(tab.key)"
            :class="[
                'cursor-pointer px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200',
                modelValue === tab.key
                    ? 'bg-surface-600 text-surface-100 shadow-sm'
                    : 'text-surface-100/40 hover:text-surface-100/70'
            ]"
        >
            {{ tab.label }}
        </button>
    </div>
</template>
