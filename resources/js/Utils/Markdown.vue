<script setup lang="ts">
defineProps({
    blocks: Object,
})
</script>

<template>
    <template v-for="(block, i) in blocks" :key="i">
        <h2 v-if="block.type === 'heading' && block.level === 2" class="font-semibold text-amber-300 mt-4 mb-1">
            {{ block.text }}
        </h2>
        <h3 v-else-if="block.type === 'heading' && block.level === 3" class="font-medium text-amber-200 mt-3 mb-1">
            {{ block.text }}
        </h3>
        <p v-else-if="block.type === 'paragraph'" class="mt-2">{{ block.text }}</p>
        <ul v-else-if="block.type === 'list' && !block.ordered" class="list-disc ml-4 mt-2">
            <li v-for="item in block.items" :key="item">{{ item }}</li>
        </ul>
        <ol v-else-if="block.type === 'list' && block.ordered" class="list-decimal ml-4 mt-2">
            <li v-for="item in block.items" :key="item">{{ item }}</li>
        </ol>
        <a v-else-if="block.type === 'image'" :href="block.link" target="_blank">
            <img :src="block.href" :alt="block.alt" />
        </a>
    </template>
</template>
