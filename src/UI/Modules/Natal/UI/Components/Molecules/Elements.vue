<script setup lang="ts">
import ElementIcon from "@/Resources/Icons/Zodiac/ElementIcon.vue";

const props = defineProps({
    elements: Object,
});
</script>

<template>
    <div class="mt-4 w-full overflow-hidden">
        <div class="px-4 pt-2 text-center text-surface-200 font-medium">
            Элементы
        </div>
        <div class="grid grid-cols-4 gap-2 px-4 pt-2 pb-4">
            <div class="flex flex-col items-center justify-center gap-2 rounded-lg py-3">
                <ElementIcon element="fire" :width="24" :height="24" />
                <span class="text-sm text-surface-100">
                    {{ elements.fire }}
                </span>
            </div>
            <div class="flex flex-col items-center justify-center gap-2 rounded-lg py-3">
                <ElementIcon element="earth" :width="24" :height="24" />
                <span class="text-sm text-surface-100">
                    {{ elements.earth }}
                </span>
            </div>
            <div class="flex flex-col items-center justify-center gap-2 rounded-lg py-3">
                <ElementIcon element="air" :width="24" :height="24" />
                <span class="text-sm text-surface-100">
                    {{ elements.air }}
                </span>
            </div>
            <div class="flex flex-col items-center justify-center gap-2 rounded-lg py-3">
                <ElementIcon element="water" :width="24" :height="24" />
                <span class="text-sm text-surface-100">
                    {{ elements.water }}
                </span>
            </div>
        </div>
    </div>
</template>
