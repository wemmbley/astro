<script setup lang="ts">
const model = defineModel<string>({ required: false });
const props = withDefaults(defineProps<{
    label?: string,
    name?: string,
}>(), {
    label: 'Email',
    name: 'email',
});
</script>

<template>
    <label for="email" class="mb-2 block text-sm font-medium text-surface-300">
        {{ props.label }}
    </label>
    <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
            <svg class="h-5 w-5 text-surface-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15A2.25 2.25 0 012.25 17.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75m19.5 0l-8.69 5.516a2.25 2.25 0 01-2.12 0L2.25 6.75"/>
            </svg>
        </div>
        <input
            v-model="model"
            type="email"
            :name="props.name"
            placeholder="you@example.com"
            class="w-full rounded-2xl border border-surface-600 bg-surface-700/80
                   py-3.5 pl-12 pr-4 text-surface-200 placeholder:text-surface-500
                   outline-none transition-all duration-200 focus:border-accent
                   focus:ring-2 focus:ring-accent/15"
        />
    </div>
</template>
