<script setup lang="ts">
import { ref, onMounted, onUnmounted, nextTick } from 'vue'

const props = defineProps<{
    loader: () => Promise<any>
    props?: Record<string, any>
}>()

const solidRoot = ref<HTMLElement | null>(null)

let disposeIsland: (() => void) | null = null

onMounted(async () => {
    const mod = await props.loader()

    await nextTick()

    if (solidRoot.value) {
        const { mountSolid } = await import('@/Bootstrap/Solid/Solid')
        disposeIsland = mountSolid(mod.default, solidRoot.value, props.props)
    }
})

onUnmounted(() => {
    disposeIsland?.()
    disposeIsland = null
})
</script>

<template>
    <div ref="solidRoot" class="min-h-20" />
</template>
