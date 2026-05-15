<script>
import { MilkdownProvider } from '@milkdown/vue'
import { defineComponent } from 'vue'
import MilkdownEditor from "@/Domain/MilkdownEditor/MilkdownEditor.vue";

export default defineComponent({
    name: 'MilkdownEditorWrapper',
    components: {
        MilkdownEditor,
        MilkdownProvider,
    },
})
</script>

<template>
    <MilkdownProvider>
        <MilkdownEditor />
    </MilkdownProvider>
</template>
