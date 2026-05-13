<script setup lang="ts">
import type { TreeNode, NodeClickEvent } from '@/App/StarEditor/Domain/Types/TreeNode'
import TreeNodeView from '@/App/StarEditor/Application/Components/TreeNode.vue'

defineProps<{
    nodes: TreeNode[]
}>()

const emit = defineEmits<{
    'node-click': [payload: NodeClickEvent]
    'node-right-click': [payload: NodeClickEvent]
}>()
</script>

<template>
    <div class="bg-surface-900 overflow-y-auto p-1.5 h-full">
        <TreeNodeView
            v-for="node in nodes"
            :key="node.id"
            :node="node"
            :depth="0"
            @node-click="emit('node-click', $event)"
            @node-right-click="emit('node-right-click', $event)"
        />
        <div
            v-if="nodes.length === 0"
            class="text-surface-500 text-sm text-center py-8"
        >
            Хранилище пусто
        </div>
    </div>
</template>
