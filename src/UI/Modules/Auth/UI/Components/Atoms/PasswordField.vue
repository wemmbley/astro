<script setup lang="ts">
const model = defineModel<string>({ required: false });

const props = withDefaults(defineProps<{
    label?: string,
    showRecover?: boolean,
    name?: string,
}>(), {
    label: 'Пароль',
    showRecover: false,
    name: 'email',
});
</script>

<template>
    <div class="mb-2 flex items-center justify-between">
        <label for="password" class="block text-sm font-medium text-surface-300">
            {{ props.label }}
        </label>
        <div v-if="showRecover">
            <a href="/auth/recover" class="text-sm text-accent transition hover:text-accent-300">Восстановить?</a>
        </div>
    </div>
    <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
            <svg class="h-5 w-5 text-surface-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5m-.75 0h9.75A2.25 2.25 0 0119.5 12.75v5.25A2.25 2.25 0 0117.25 20.25H6.75A2.25 2.25 0 014.5 18v-5.25A2.25 2.25 0 016.75 10.5z"/>
            </svg>
        </div>
        <input
            v-model="model"
            type="password"
            placeholder="••••••••"
            class="w-full rounded-2xl border border-surface-600 bg-surface-700/80
                   py-3.5 pl-12 pr-4 text-surface-200 placeholder:text-surface-500
                   outline-none transition-all duration-200 focus:border-accent
                   focus:ring-2 focus:ring-accent/15"
        />
    </div>
</template>
