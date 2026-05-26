<script setup lang="ts">
import Tooltip from "@/Modules/Shared/Components/Tooltip.vue";
import { CheckCheck, Check } from "lucide-vue-next";
import { computed } from "vue";

type MessageType = "sender" | "receiver";

const props = defineProps<{
    text:      string;
    date:      string;
    read?:     boolean;
    readDate?: string | null;
    type:      MessageType;
}>();

const isSender = computed(() => props.type === 'sender');

const containerClass = computed(() => [
    'flex',
    isSender.value ? 'justify-start' : 'justify-end',
]);

const messageClass = computed(() => [
    'max-w-[60%] text-white px-4 py-2 rounded-2xl shadow',
    'flex gap-0.5 relative group',
    isSender.value
        ? 'bg-accent/70 rounded-bl-md'
        : 'bg-accent/30 rounded-br-md',
]);
</script>

<template>
    <div :class="containerClass">
        <div :class="messageClass">
            <p class="relative text-sm leading-snug">{{ text }}</p>
            <div class="flex gap-1 mt-0.5"
                 :class="isSender ? 'justify-start' : 'justify-end'">
                <p class="translate-y-1 text-[11px]
                text-surface-100/50 select-none" :class="isSender ? 'translate-x-1' : 'translate-x-2'">
                    {{ date }}
                </p>
                <div v-if="!isSender" class="flex items-center group/read">
                    <CheckCheck v-if="read" class="text-accent translate-y-1 translate-x-2" :size="14" />
                    <Check v-else class="text-white/40 translate-y-1 translate-x-2" :size="14" />
                    <Tooltip v-if="read">
                        Прочитано в <b>{{ readDate ?? 'неизвестно' }}</b>
                    </Tooltip>
                </div>
            </div>
        </div>
    </div>
</template>
