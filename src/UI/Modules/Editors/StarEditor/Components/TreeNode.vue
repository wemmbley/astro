<script lang="ts">export default { name: 'TreeNode' }</script>
<script setup lang="ts">
import { computed } from 'vue'
import type { TreeNode, NodeClickEvent } from '@/App/StarEditor/Domain/Types/TreeNode'
import { useTreeState } from '@/App/StarEditor/Application/Composables/TreeState'
import IconFolderOpen from "@/App/StarEditor/Application/Presentations/IconFolderOpen.vue";
import IconFile from "@/App/StarEditor/Application/Presentations/IconFile.vue";
import IconCaretOpen from "@/App/StarEditor/Application/Presentations/IconCaretOpen.vue";
import IconCaretClosed from "@/App/StarEditor/Application/Presentations/IconCaretClosed.vue";

const props = defineProps<{
    node: TreeNode
    depth: number
}>()

const emit = defineEmits<{
    'node-click': [payload: NodeClickEvent]
    'node-right-click': [payload: NodeClickEvent]
}>()

const { isOpen, toggle } = useTreeState()

const isFolder = computed(() => props.node.type === 'folder')
const folderOpen = computed(() => isFolder.value && isOpen(props.node.id))
const children = computed((): TreeNode[] => props.node.children ?? [])
const indentStyle = computed(() => ({
    paddingLeft: `${props.depth * 16 + 8}px`,
}))

function onClick(e: MouseEvent) {
    if (isFolder.value) toggle(props.node.id)
    emit('node-click', { node: props.node, mouseEvent: e })
}

function onRightClick(e: MouseEvent) {
    e.preventDefault()
    emit('node-right-click', { node: props.node, mouseEvent: e })
}
</script>

<template>
    <div class="select-none">
        <div
            class="flex items-center gap-2 py-[2px] pr-2 rounded-md cursor-pointer
             text-surface-300 hover:bg-surface-700/60 hover:text-surface-100
             transition-colors duration-100"
            :style="indentStyle"
            @click="onClick"
            @contextmenu="onRightClick"
        >
            <span class="w-3 flex-shrink-0 text-[10px] text-surface-500">
                <template v-if="isFolder">
                    <template v-if="folderOpen">
                        <IconCaretOpen class="pt-[2.5px]" />
                    </template>
                    <template v-else>
                        <IconCaretClosed class="pt-[2.5px]" />
                    </template>
                </template>
            </span>
            <span class="flex-shrink-0 text-sm leading-none">
                <template v-if="isFolder">
                    <template v-if="folderOpen">
                        <IconFolderOpen />
                    </template>
                    <template v-else>
                        <IconFolderOpen />
                    </template>
                </template>
                <template v-else>
                    <IconFile />
                </template>
            </span>
            <span class="truncate text-sm font-medium leading-5">{{ node.name }}</span>
        </div>
        <div
            v-if="isFolder && folderOpen"
            class="border-l border-surface-700/40 ml-1"
        >
            <TreeNode
                v-for="child in children"
                :key="child.id"
                :node="child"
                :depth="depth + 1"
                @node-click="emit('node-click', $event)"
                @node-right-click="emit('node-right-click', $event)"
            />
        </div>
    </div>
</template>
