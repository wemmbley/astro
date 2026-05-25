<script setup>
import User from "@/Modules/Social/UI/Components/Atoms/User.vue";

const props = defineProps({
    items:       { type: Array,   default: () => [] },
    label:       { type: String,  default: 'Друзья' },
    buttonText:  { type: String,  default: 'Смотреть все' },
    limit:       { type: Number,  default: 6 },
})

const emit = defineEmits(['button-click', 'item-click'])
</script>

<template>
    <div class="bg-surface-800 border border-surface-600 rounded-2xl p-4">
        <div class="flex items-center justify-between mb-3 px-0.5">
            <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-surface-100/35">
                {{ label }}
            </span>
            <span class="text-[10px] font-semibold text-accent bg-accent/10 px-2 py-0.5 rounded-md border border-accent/20">
                {{ items.length }}
            </span>
        </div>
        <div class="grid grid-cols-3 gap-1">
            <div v-for="person in items.slice(0, limit)" :key="person.id"
                 class="group flex flex-col items-center gap-1.5 px-1.5 py-2.5
                        rounded-xl cursor-pointer transition-colors duration-200
                        hover:bg-surface-600"
                 @click="emit('item-click', person)">
                <User :avatar="person.avatar"
                      :last-seen="person.lastSeen"
                      :name="person.name" />
            </div>
        </div>
        <div class="mt-3 pt-2">
            <button class="w-full text-[11px] font-medium text-accent cursor-pointer
                           bg-accent/8 hover:bg-accent/15 border border-accent/15
                           rounded-lg py-1.5 transition-colors duration-200"
                    @click="emit('button-click')">
                {{ buttonText }}
            </button>
        </div>
    </div>
</template>
