<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import User from "@/Modules/Social/UI/Components/Atoms/User.vue";
import {Check, CheckCheck} from "lucide-vue-next";
import {ref} from "vue";
import Message from "@/Modules/Messenger/UI/Atoms/Message.vue";
import {dialogues} from "@/Modules/Messenger/Domain/Mocks/Dialogues";
import SmileBox from "@/Modules/Messenger/UI/Organisms/SmileBox.vue";

const activeDialogueId = ref(1);
const message = ref("");

const insertSmilesTo = (smile: string) => {
    message.value += ` ${smile}`
}
</script>

<template>
    <MainLayout :hasContainer="false">
        <div class="flex max-w-4xl m-auto w-full mt-10">
            <div class="max-w-xs min-w-xs">
                <textarea class="flex w-full p-1 mt-2 h-8 mb-3 rounded-xs resize-none
                        focus:outline-1 focus:outline-offset-2 focus:outline-solid focus:outline-accent"
                          placeholder="Поиск среди диалогов..." />
                <div v-for="dialogue in dialogues"
                     class="flex hover:bg-surface-600 rounded-md p-2 cursor-pointer transition">
                    <User :avatar="dialogue.senderAvatar" :last-seen="dialogue.senderOnline" />
                    <div class="flex flex-col">
                        <p class="font-medium">{{ dialogue.senderName }}</p>
                        <div class="flex">
                            <p class="text-surface-200">
                                {{ dialogue.senderText }}
                            </p>
                            <div v-if="dialogue.textRead">
                                <CheckCheck class="text-accent/80 ml-2" />
                            </div>
                            <div v-else>
                                <Check class="text-accent/80 ml-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-[80vh] flex flex-col w-full">
                <div class="p-3 mb-4">
                    Сообщения
                </div>
                <div class="flex-1 overflow-x-hidden overflow-y-scroll px-3 py-2 scrollbar-surface">
                    <div
                        v-for="message in dialogues[0].messageBag"
                        :key="message.date">
                        <Message
                            class="mt-2"
                            :text="message.text"
                            :date="message.date"
                            :read="message.read"
                            :read-date="message.readDate"
                            :type="message.type"
                        />
                    </div>
                </div>
                <div class="p-3 border-t border-white/10 relative">
                    <textarea
                        v-model="message"
                        class="w-full p-2 rounded-md resize-none
                               focus:outline-1 focus:outline-offset-2
                               focus:outline-solid focus:outline-accent"
                        placeholder="Введите Ваше сообщение..."
                    />
                    <SmileBox :insertSmilesTo="insertSmilesTo" class="absolute top-5 right-5" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>
