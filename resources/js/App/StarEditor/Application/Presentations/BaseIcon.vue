<template>
  <span
      class="icon"
      :style="{
      width: size,
      height: size,
      display: 'inline-flex',
      flexShrink: 0
    }"
  >
    <svg
        :width="size"
        :height="size"
        :viewBox="`0 0 ${viewBoxWidth} ${viewBoxHeight}`"
        :fill="fill"
        :stroke="stroke"
        :stroke-width="strokeWidth"
        xmlns="http://www.w3.org/2000/svg"
        v-bind="$attrs"
    >
      <slot />
    </svg>
  </span>
</template>

<script setup>
const props = defineProps({
    size: {
        type: [Number, String],
        default: 24
    },
    viewBoxWidth: {
        type: [Number, String],
        default: 24
    },
    viewBoxHeight: {
        type: [Number, String],
        default: 24
    },
    fill: {
        type: String,
        default: 'none'
    },
    stroke: {
        type: String,
        default: 'currentColor'
    },
    strokeWidth: {
        type: [Number, String],
        default: 1.5
    }
})
</script>

<style scoped>
.icon {
    line-height: 0;
    flex-shrink: 0;
}
</style>
