<script>
import { Crepe } from '@milkdown/crepe'
import { Milkdown, MilkdownProvider, useEditor } from '@milkdown/vue'
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'MilkdownEditor',
    components: {
        Milkdown,
    },
    setup: () => {
        const { get } = useEditor((root) => {
            return new Crepe({ root })
        })
    },
})
</script>

<template>
    <Milkdown />
</template>
