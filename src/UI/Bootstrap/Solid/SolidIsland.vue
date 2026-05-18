<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'

const props = defineProps<{
    loader: () => Promise<any>
    props?: any
}>()

const solidRoot = ref<HTMLElement | null>(null)

onMounted(async () => {
    const mod = await props.loader()

    await nextTick()

    if (solidRoot.value) {
        const { mountSolid } = await import('@/Bootstrap/Solid/Solid')

        mountSolid(mod.default, solidRoot.value, props.props)
    }
})
</script>

<template>
    <div ref="solidRoot" class="min-h-20" />
</template>
