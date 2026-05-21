<script setup lang="ts">
const model = defineModel<string>({ required: true });
const props = withDefaults(defineProps<{
    label?: string,
    maxlen?: number,
}>(), {
    label: 'Верификационный код',
    maxlen: 6,
});

const onInput = (e: Event) => {
    const target = e.target as HTMLInputElement;
    model.value = target.value
        .replace(/\D/g, '')
        .slice(0, props.maxlen);
};
</script>

<template>
    <label for="verification-code" class="mb-2 block text-sm font-medium text-surface-300">
        {{ props.label }}
    </label>
    <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
            <svg class="h-5 w-5 text-surface-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M7.5 4.5h9A2.25 2.25 0 0118.75 6.75v10.5A2.25 2.25 0 0116.5 19.5h-9a2.25 2.25 0 01-2.25-2.25V6.75A2.25 2.25 0 017.5 4.5z"/>
            </svg>
        </div>
        <input
            id="verification-code"
            :value="model"
            type="text"
            inputmode="numeric"
            autocomplete="one-time-code"
            :maxlength="props.maxlen"
            placeholder="000000"
            class="w-full rounded-2xl border border-surface-600 bg-surface-700/80
                   py-3.5 pl-12 pr-4 text-center text-2xl tracking-[0.5em]
                   text-surface-200 placeholder:text-surface-500
                   outline-none transition-all duration-200
                   focus:border-accent focus:ring-2 focus:ring-accent/15"
            @input="onInput"
        />
    </div>
</template>
