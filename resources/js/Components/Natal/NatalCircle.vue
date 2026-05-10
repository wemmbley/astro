<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query'
import {api} from '@/Libs/Fetcher'
import {ref, onMounted, onBeforeUnmount} from 'vue'

const props = defineProps({
    coordinates: Object,
})

const { data: svgData, isLoading: svgLoading } = useQuery({
    queryKey: ['natal-svg', props.coordinates],
    queryFn: () => api('natal/svg', {
        method: 'POST',
        body: JSON.stringify(props.coordinates),
    }),
})

// --- Fullscreen ---
const isFullscreen = ref(false)
const openFullscreen = () => {
    isFullscreen.value = true
}
const closeFullscreen = () => {
    isFullscreen.value = false;
    lensVisible.value = false
}

// --- Magnifier ---
const LENS_SIZE = 220
const ZOOM = 2

const lensVisible = ref(false)
const lensX = ref(0)
const lensY = ref(0)
const svgOffsetX = ref(0)
const svgOffsetY = ref(0)
const svgContainerRef = ref<HTMLElement | null>(null)

const onMouseMove = (e: MouseEvent) => {
    if (!svgContainerRef.value) return

    const rect = svgContainerRef.value.getBoundingClientRect()
    const mx = e.clientX - rect.left
    const my = e.clientY - rect.top

    if (mx < 0 || my < 0 || mx > rect.width || my > rect.height) {
        lensVisible.value = false
        return
    }

    lensVisible.value = true

    // Центрируем линзу на курсоре
    lensX.value = e.clientX - LENS_SIZE / 2
    lensY.value = e.clientY - LENS_SIZE / 2

    // Смещаем внутренний SVG так, чтобы точка под курсором оказалась в центре линзы
    svgOffsetX.value = LENS_SIZE / 2 - mx * ZOOM
    svgOffsetY.value = LENS_SIZE / 2 - my * ZOOM
}

const onMouseLeave = () => {
    lensVisible.value = false
}

const handleKeydown = (e: KeyboardEvent) => {
    if (e.key === 'Escape') closeFullscreen()
}

onMounted(() => window.addEventListener('keydown', handleKeydown))
onBeforeUnmount(() => window.removeEventListener('keydown', handleKeydown))
</script>

<template>
    <!-- Превью — cursor-zoom-in на весь блок, никакого JS для курсора -->
    <div
        class="natal-chart max-w-xl [&_svg]:w-full [&_svg]:h-auto cursor-zoom-in"
        @click="openFullscreen"
    >
        <div v-if="svgLoading" class="w-full aspect-square bg-surface-500 animate-pulse rounded-full"/>
        <div v-else v-html="svgData.svg" />
    </div>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isFullscreen"
                class="fixed inset-0 z-9999 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4"
            >
                <!-- Закрытие по фону -->
                <div class="absolute inset-0" @click="closeFullscreen"/>

                <div class="relative z-10 w-full h-full flex items-center justify-center">
                    <button
                        @click="closeFullscreen"
                        class="cursor-pointer absolute top-4 right-4 text-white text-4xl leading-none hover:opacity-70 transition"
                    >
                        ×
                    </button>

                    <!-- SVG-контейнер с отслеживанием мыши -->
                    <div
                        ref="svgContainerRef"
                        class="[&_svg]:w-[95vw] [&_svg]:h-[95vh] [&_svg]:max-w-none"
                        :class="lensVisible ? 'cursor-none' : 'cursor-crosshair'"
                        @mousemove="onMouseMove"
                        @mouseleave="onMouseLeave"
                        v-html="svgData.svg"
                    />

                    <!-- Линза-лупа -->
                    <div
                        v-if="lensVisible"
                        class="fixed pointer-events-none overflow-hidden rounded-sm border border-white/30 shadow-2xl"
                        :style="{
                                    width: `${LENS_SIZE}px`,
                                    height: `${LENS_SIZE}px`,
                                    left: `${lensX}px`,
                                    top:  `${lensY}px`,
                                }"
                    >
                        <!-- Внутренний SVG тех же размеров что и внешний, масштабируется 2× -->
                        <div
                            class="[&_svg]:w-[95vw] [&_svg]:h-[95vh] [&_svg]:max-w-none absolute"
                            :style="{
                                        transformOrigin: 'top left',
                                        transform: `scale(${ZOOM})`,
                                        left: `${svgOffsetX}px`,
                                        top:  `${svgOffsetY}px`,
                                    }"
                            v-html="svgData.svg"
                        />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
