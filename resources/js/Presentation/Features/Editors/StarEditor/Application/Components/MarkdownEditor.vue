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
    <div class="flex flex-col h-full flex-1 min-h-0 overflow-hidden scrollbar-surface">
        <textarea ref="textareaRef" />
    </div>
</template>

<style>
@import "@/App/StarEditor/Infrastructure/Vendor/simplemde.min.css";

.CodeMirror {
    height: 100%;
    max-height: 74vh;
    background: var(--color-surface-700);
    color: var(--color-surface-100);
    border: 1px solid var(--color-surface-500);
    border-radius: 14px;
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
    font-size: 14px;
    line-height: 1.75;
    position: relative;
    overflow: hidden;
    box-shadow:
        0 0 0 1px rgba(255,255,255,0.02),
        0 10px 30px rgba(0,0,0,0.35);
}
.CodeMirror-lines { padding: 24px 32px; }
.CodeMirror-scroll {
    overflow: auto !important;
    scrollbar-width: thin;
}
.CodeMirror-line { color: var(--color-surface-100); }
.CodeMirror-selected { background: rgba(255,255,255,0.08) !important; }
.CodeMirror-cursor { border-left: 2px solid #ffffff !important; }
.CodeMirror-activeline-background { background: rgba(255,255,255,0.03);}
.cm-header {
    color: #ffffff;
    font-weight: 700;
    line-height: 1.4;
}
.cm-strong { color: #ffffff; }
.cm-em { opacity: 0.9; }
.cm-link { color: var(--color-accent); }
.cm-comment { color: #94a3b8; }
.editor-preview {
    background: var(--color-surface-800);
    color: var(--color-surface-100);
    padding: 32px;
}
.editor-toolbar,
.CodeMirror,
.editor-preview-side {
    border: none;
}
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}
::-webkit-scrollbar-thumb {
    background: var(--color-surface-500);
    border-radius: 10px;
}
::-webkit-scrollbar-track,
::-webkit-scrollbar-corner {
    display: none;
}
::-webkit-scrollbar-thumb:hover {
    background: #555;
    border-radius: 10px;
}
</style>
