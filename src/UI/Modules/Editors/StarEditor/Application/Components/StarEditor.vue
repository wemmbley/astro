<script setup lang="ts">
// <StarEditor
// :initial-tree-data="tree"
// :editable="true"
// @update:tree-data="handleTreeUpdate"
// @file-opened="handleFileOpen"
// @file-content-changed="handleContentChange"
// @node-renamed="handleRename"
// @node-deleted="handleDelete"
// @node-created="handleCreate"
//     />

import { ref, onMounted, onBeforeUnmount } from 'vue'
import TreeView from '@/App/StarEditor/Application/Components/TreeView.vue'
import MarkdownEditor from '@/App/StarEditor/Application/Components/MarkdownEditor.vue'
import { useTreeState } from '@/App/StarEditor/Application/Composables/TreeState'
import type { NodeClickEvent, TreeNode } from '@/App/StarEditor/Domain/Types/TreeNode'
import IconFile from "@/App/StarEditor/Application/Presentations/IconFile.vue";
import IconFolderClosed from "@/App/StarEditor/Application/Presentations/IconFolderClosed.vue";
import IconTelegraph from "@/App/StarEditor/Application/Presentations/IconTelegraph.vue";

// Определяем пропсы
interface Props {
    initialTreeData?: TreeNode[] // Опциональный проп для начальных данных
    editable?: boolean // Можно ли редактировать файлы
}

const props = withDefaults(defineProps<Props>(), {
    initialTreeData: () => [],
    editable: true
})

// Эмиты для родительского компонента
const emit = defineEmits<{
    'update:treeData': [treeData: TreeNode[]]
    'fileOpened': [node: TreeNode]
    'fileContentChanged': [node: TreeNode, content: string]
    'nodeRenamed': [node: TreeNode, newName: string]
    'nodeDeleted': [node: TreeNode]
    'nodeCreated': [parentNode: TreeNode | null, newNode: TreeNode]
}>()

// Используем проп вместо мока
const treeData = ref<TreeNode[]>(props.initialTreeData)
const activeNode = ref<TreeNode | null>(null)
const editorContent = ref('')

// Следим за изменениями пропса
import { watch } from 'vue'
watch(() => props.initialTreeData, (newData) => {
    if (newData && newData.length > 0) {
        treeData.value = newData
    }
}, { deep: true })

// Сохраняем изменения в родительский компонент
function updateTreeData(newTreeData: TreeNode[]) {
    treeData.value = newTreeData
    emit('update:treeData', newTreeData)
}

function openFile(node: TreeNode) {
    if (node.type !== 'file') return
    activeNode.value = node
    editorContent.value = node.text ?? ''
    emit('fileOpened', node)
}

function onEditorUpdate(value: string) {
    editorContent.value = value
    if (activeNode.value?.type === 'file') {
        activeNode.value.text = value
        emit('fileContentChanged', activeNode.value, value)
        // Обновляем весь TreeData для синхронизации
        emit('update:treeData', treeData.value)
    }
}

const ctxMenu = ref({
    visible: false,
    x: 0,
    y: 0,
    node: null as TreeNode | null,
})

function showCtxMenu(payload: NodeClickEvent) {
    ctxMenu.value = {
        visible: true,
        x: payload.mouseEvent.clientX,
        y: payload.mouseEvent.clientY,
        node: payload.node,
    }
}

function hideCtxMenu() {
    ctxMenu.value.visible = false
}

onMounted(() => window.addEventListener('click', hideCtxMenu))
onBeforeUnmount(() => window.removeEventListener('click', hideCtxMenu))

function ctxRename() {
    console.log('rename', ctxMenu.value.node)
    if (ctxMenu.value.node && props.editable) {
        const newName = prompt('Введите новое имя:', ctxMenu.value.node.name)
        if (newName && newName !== ctxMenu.value.node.name) {
            ctxMenu.value.node.name = newName
            emit('nodeRenamed', ctxMenu.value.node, newName)
            emit('update:treeData', treeData.value)
        }
    }
    hideCtxMenu()
}

function ctxDelete() {
    console.log('delete', ctxMenu.value.node)
    if (ctxMenu.value.node && props.editable) {
        // Логика удаления узла
        removeNodeFromTree(ctxMenu.value.node)
        emit('nodeDeleted', ctxMenu.value.node)
        if (activeNode.value?.id === ctxMenu.value.node.id) {
            activeNode.value = null
            editorContent.value = ''
        }
    }
    hideCtxMenu()
}

function ctxNewFile() {
    console.log('new file in', ctxMenu.value.node)
    if (props.editable) {
        const fileName = prompt('Введите имя файла:')
        if (fileName) {
            const newNode: TreeNode = {
                id: Date.now(),
                name: fileName,
                type: 'file',
                text: ''
            }
            addNodeToTree(ctxMenu.value.node, newNode)
            emit('nodeCreated', ctxMenu.value.node, newNode)
            emit('update:treeData', treeData.value)
        }
    }
    hideCtxMenu()
}

function ctxNewFolder() {
    console.log('new folder in', ctxMenu.value.node)
    if (props.editable) {
        const folderName = prompt('Введите имя папки:')
        if (folderName) {
            const newNode: TreeNode = {
                id: Date.now(),
                name: folderName,
                type: 'folder',
                children: []
            }
            addNodeToTree(ctxMenu.value.node, newNode)
            emit('nodeCreated', ctxMenu.value.node, newNode)
            emit('update:treeData', treeData.value)
        }
    }
    hideCtxMenu()
}

// Вспомогательные функции для работы с деревом
function removeNodeFromTree(nodeToRemove: TreeNode) {
    const removeNode = (nodes: TreeNode[]): boolean => {
        for (let i = 0; i < nodes.length; i++) {
            if (nodes[i].id === nodeToRemove.id) {
                nodes.splice(i, 1)
                return true
            }
            if (nodes[i].children && removeNode(nodes[i].children!)) {
                return true
            }
        }
        return false
    }
    removeNode(treeData.value)
}

function addNodeToTree(parentNode: TreeNode | null, newNode: TreeNode) {
    if (!parentNode) {
        treeData.value.push(newNode)
    } else if (parentNode.type === 'folder') {
        if (!parentNode.children) parentNode.children = []
        parentNode.children.push(newNode)
    }
}

const { expandAll, collapseAll } = useTreeState()

function collectFolderIds(nodes: TreeNode[]): number[] {
    const ids: number[] = []
    for (const node of nodes) {
        if (node.type === 'folder') {
            ids.push(node.id)
            if (node.children) ids.push(...collectFolderIds(node.children))
        }
    }
    return ids
}
</script>

<template>
    <div class="flex h-screen bg-surface-950 text-surface-100 overflow-hidden font-sans">
        <aside class="w-60 flex flex-col bg-surface-900 border-r border-surface-700/40 flex-shrink-0">
            <div class="flex items-center justify-between px-3 py-2.5 border-b border-surface-700/40">
                <div class="flex items-center gap-2">
                    <span class="text-xs relative font-semibold text-surface-300 tracking-widest">
                        <IconTelegraph size="44"/>
                        <span class="absolute bottom-1">elegraph</span>
                    </span>
                </div>
                <div class="flex gap-0.5">
                    <button
                        v-if="treeData.length > 0"
                        class="w-6 h-6 flex items-center justify-center rounded text-surface-500
                   hover:text-accent hover:bg-surface-700/60 transition-colors text-xs"
                        title="Развернуть всё"
                        @click="expandAll(collectFolderIds(treeData))"
                    >⊞</button>
                    <button
                        v-if="treeData.length > 0"
                        class="w-6 h-6 flex items-center justify-center rounded text-surface-500
                   hover:text-accent hover:bg-surface-700/60 transition-colors text-xs"
                        title="Свернуть всё"
                        @click="collapseAll(collectFolderIds(treeData))"
                    >⊟</button>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto">
                <TreeView
                    :nodes="treeData"
                    @node-click="(e) => { openFile(e.node) }"
                    @node-right-click="showCtxMenu"
                />
            </div>
            <div class="px-3 py-2 border-t border-surface-700/40 flex items-center gap-2">
                <span class="text-[10px] text-surface-600">
                  {{ treeData.length }} элементов в корне
                </span>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0">
            <header class="flex items-center gap-2 px-4 py-2.5 border-b border-surface-700/40 bg-surface-900/50">
                <template v-if="activeNode">
                    <span class="text-sm text-surface-300 text-md">{{ activeNode.name }}</span>
                </template>
                <template v-else>
                    <span class="text-surface-600 text-xl">Файл не выбран</span>
                </template>
            </header>
            <div class="flex-1 overflow-hidden">
                <MarkdownEditor
                    v-if="activeNode && editable"
                    :key="activeNode.id"
                    :model-value="editorContent"
                    :file-name="activeNode.name"
                    @update:model-value="onEditorUpdate"
                />
                <div
                    v-else-if="activeNode && !editable"
                    class="flex flex-col items-center justify-center h-full gap-4 text-center px-8"
                >
                    <span class="text-5xl">🔒</span>
                    <p class="text-surface-500 text-sm max-w-xs leading-relaxed">
                        Редактирование отключено
                    </p>
                </div>
                <div
                    v-else
                    class="flex flex-col items-center justify-center h-full gap-4 text-center px-8"
                >
                    <span class="text-5xl">✦</span>
                    <h1 class="text-xl font-semibold text-surface-300">Star Editor</h1>
                    <p class="text-surface-500 text-sm max-w-xs leading-relaxed">
                        Выбери файл в панели слева или кликни правой кнопкой чтобы создать новый
                    </p>
                </div>
            </div>
        </main>
    </div>

    <Teleport to="body">
        <div
            v-if="ctxMenu.visible && editable"
            class="fixed z-50 min-w-[180px] bg-surface-800 border border-surface-600/60
             rounded-lg shadow-2xl overflow-hidden py-1"
            :style="{ top: `${ctxMenu.y}px`, left: `${ctxMenu.x}px` }"
            @click.stop
        >
            <div class="px-3 py-1.5 text-[11px] text-surface-500 truncate border-b border-surface-700/50 mb-1">
                <div v-if="ctxMenu.node?.type === 'folder'">
                    <IconFolderClosed />
                </div>
                <div v-else>
                    <IconFile />
                </div>
                {{ ctxMenu.node?.name }}
            </div>
            <button
                class="ctx-item"
                @click="ctxRename"
            >
                Переименовать
            </button>
            <template v-if="ctxMenu.node?.type === 'folder'">
                <button class="ctx-item" @click="ctxNewFile">
                    <span class="text-xs"><IconFile /></span> Новый файл
                </button>
                <button class="ctx-item" @click="ctxNewFolder">
                    <span class="text-xs"><IconFolderClosed /></span> Новая папка
                </button>
            </template>
            <div class="border-t border-surface-700/50 mt-1 pt-1">
                <button class="ctx-item text-red-400 hover:text-red-300" @click="ctxDelete">
                    Удалить
                </button>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
@reference "@/../css/app.css";

.ctx-item {
    @apply w-full text-left px-3 py-1.5 text-sm text-surface-300
    hover:bg-surface-700/60 hover:text-surface-100
    transition-colors duration-100 flex items-center gap-2;
}
</style>
