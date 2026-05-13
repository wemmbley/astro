<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import '@/App/StarEditor/Infrastructure/Vendor/simplemde.min'

declare const SimpleMDE: any

const props = defineProps<{
    modelValue: string
    fileName: string
}>()

const emit = defineEmits<{
    'update:modelValue': [value: string]
}>()

const textareaRef = ref<HTMLTextAreaElement | null>(null)
let editor: any = null

onMounted(() => {
    editor = new SimpleMDE({
        element: textareaRef.value,
        initialValue: props.modelValue,
        toolbar: false,
        forceSync: true,
        autofocus: true,
        spellChecker: false,
        toolbarTips: false,
        status: false,
        placeholder: "Проба пера...",
        autosave: {
            enabled: true,
            uniqueId: "MyUniqueID",
            delay: 1000,
        },
    })

    editor.codemirror.on('change', () => {
        emit('update:modelValue', editor.value())
    })
})

watch(() => props.modelValue, (newVal) => {
    if (editor && editor.value() !== newVal) {
        editor.value(newVal)
    }
})

onBeforeUnmount(() => {
    editor?.toTextArea()
    editor = null
})
</script>

<template>
    <div class="flex flex-col h-full">
        <textarea ref="textareaRef" />
    </div>
</template>

<style>
@import "@/App/StarEditor/Infrastructure/Vendor/simplemde.min.css";

:deep(.CodeMirror) {
    height: 100%;
    background: transparent;
    color: var(--color-surface-100, #f1f5f9);
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
    font-size: 14px;
    line-height: 1.7;
    border: none;
}

:deep(.CodeMirror-scroll) {
    padding: 24px 32px;
}

:deep(.editor-toolbar) {
    background: var(--color-surface-800, #1e293b);
    border-bottom: 1px solid var(--color-surface-700, #334155);
    border-top: none;
    border-left: none;
    border-right: none;
    opacity: 1;
}

:deep(.editor-toolbar a) {
    color: var(--color-surface-400, #94a3b8) !important;
}

:deep(.editor-toolbar a:hover),
:deep(.editor-toolbar a.active) {
    color: var(--color-accent, #7c3aed) !important;
    background: var(--color-surface-700, #334155);
}

:deep(.editor-toolbar i.separator) {
    border-color: var(--color-surface-600, #475569);
}

:deep(.CodeMirror-cursor) {
    border-color: var(--color-accent, #7c3aed);
}
</style>
