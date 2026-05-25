<script setup lang="ts">
import Tooltip from "@/Modules/Shared/Components/Tooltip.vue";
import {CheckCheck} from "lucide-vue-next";
import {computed} from "vue";

type MessageType =
    | "sender"
    | "receiver";

const props = defineProps<{
    text: string,
    date: string,
    read?: boolean,
    readDate?: string,
    type: MessageType,
}>();

const containerClass = computed(() => [
    'flex',
    props.type === 'sender'
        ? 'justify-start'
        : 'justify-end'
]);

const messageClass = computed(() => [
    'max-w-[60%] text-white px-4 py-2 ' +
    'rounded-2xl shadow flex relative group',
    props.type === 'sender'
        ? 'bg-accent/70 rounded-bl-md'
        : 'bg-accent/30 rounded-br-md'
]);
</script>

<template>
    <div :class="containerClass">
        <div
            :class="messageClass">
            <span>{{ text }}</span>
            <div v-if="read">
                <CheckCheck
                    :class="['ml-2 translate-y-1',
                    props.type === 'sender'
                        ? 'text-accent'
                        : 'text-accent/80']" />
                <Tooltip>
                    Прочитано в <b>{{ readDate ?? 'неизвестно' }}</b>
                </Tooltip>
            </div>
        </div>
    </div>
</template>
