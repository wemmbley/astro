<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import { Check, CheckCheck, Send } from "lucide-vue-next";
import { ref, computed, nextTick, watch, onUnmounted } from "vue";
import SmileBox from "@/Modules/Messenger/UI/Organisms/SmileBox.vue";
import Message from "@/Modules/Messenger/UI/Atoms/Message.vue";
import User from "@/Modules/Social/UI/Components/Atoms/User.vue";
import MessageDaySeparator from "@/Modules/Messenger/UI/Atoms/MessageDaySeparator.vue";

function isNewDay(msg: any, index: number): boolean {
    if (index === 0) return true;

    const prev = messages.value[index - 1];

    const currentDay = dateDay(msg.created_at);
    const prevDay    = dateDay(prev.created_at);

    return currentDay !== prevDay;
}

function dateDay(dateStr: string | null | undefined): string {
    if (!dateStr) return '';
    return dateStr.substring(0, 10);
}

function dayLabel(dateStr: string | null): string {
    if (!dateStr) return '';

    const day = dateStr.substring(0, 10);
    const [d, m, y] = day.split('.');

    const date = new Date(`${y}-${m}-${d}`);
    if (isNaN(date.getTime())) return '';

    const today     = new Date();
    const yesterday = new Date();
    yesterday.setDate(today.getDate() - 1);

    const fmt = (dt: Date) =>
        `${String(dt.getDate()).padStart(2,'0')}.${String(dt.getMonth()+1).padStart(2,'0')}.${dt.getFullYear()}`;

    if (day === fmt(today))     return 'Сегодня';
    if (day === fmt(yesterday)) return 'Вчера';

    return date.toLocaleDateString('ru-RU', {
        day: 'numeric', month: 'long', year: 'numeric'
    });
}

const activeDialogueId  = ref<number | null>(null);
const messages          = ref<any[]>([]);
const messageText       = ref("");
const isLoadingMessages = ref(false);
const isLoadingMore     = ref(false);
const hasMoreMessages   = ref(true);
const lastMessageId     = ref<number>(0);
const messagesContainer = ref<HTMLElement | null>(null);
const lazyTrigger       = ref<HTMLElement | null>(null);
const PAGE_SIZE         = 20;

let observer:     IntersectionObserver | null = null;
let pollInterval: ReturnType<typeof setInterval> | null = null;

function csrf(): string {
    const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
    return match ? decodeURIComponent(match[1]) : '';
}

function apiHeaders(): HeadersInit {
    return {
        'Accept':         'application/json',
        'Content-Type':   'application/json',
        'X-XSRF-TOKEN':   csrf(),
    };
}

const activeDialogue = computed(() =>
    props.dialogues.find(d => d.id === activeDialogueId.value) ?? null
);

const getInterlocutors = (dialogue: typeof props.dialogues[number]) =>
    dialogue.participants.filter(p => p.id !== props.currentUserId);

const insertSmile = (smile: string) => { messageText.value += ` ${smile}`; };

function scrollToBottom() {
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
}

async function openDialogue(dialogueId: number) {
    if (activeDialogueId.value === dialogueId) return;

    stopPolling();
    destroyObserver();

    activeDialogueId.value  = dialogueId;
    messages.value          = [];
    hasMoreMessages.value   = true;
    isLoadingMessages.value = true;

    try {
        const [msgsRes] = await Promise.all([
            fetch(`/api/v1/dialogues/${dialogueId}/messages?limit=10`, {
                headers: apiHeaders(),
            }).then(r => r.json()),

            fetch(`/api/v1/dialogues/${dialogueId}/read`, {
                method:  'POST',
                headers: apiHeaders(),
            }),
        ]);

        messages.value        = msgsRes.data ?? [];
        hasMoreMessages.value = (msgsRes.data?.length ?? 0) >= 10;
        lastMessageId.value   = messages.value.at(-1)?.id ?? 0;
    } finally {
        isLoadingMessages.value = false;
    }

    await nextTick();
    scrollToBottom();
    initObserver();
    startPolling(dialogueId);
}

function initObserver() {
    if (!lazyTrigger.value || !hasMoreMessages.value) return;

    observer = new IntersectionObserver(async ([entry]) => {
        if (!entry.isIntersecting || isLoadingMore.value || !hasMoreMessages.value) return;
        await loadMoreMessages();
    }, { root: messagesContainer.value, threshold: 0.1 });

    observer.observe(lazyTrigger.value);
}

function destroyObserver() {
    observer?.disconnect();
    observer = null;
}

async function loadMoreMessages() {
    if (!activeDialogueId.value) return;
    isLoadingMore.value = true;

    const oldScrollHeight = messagesContainer.value?.scrollHeight ?? 0;
    const oldest = messages.value[0];

    try {
        const res = await fetch(
            `/api/v1/dialogues/${activeDialogueId.value}/messages?limit=${PAGE_SIZE}&before_id=${oldest?.id ?? ''}`,
            { headers: apiHeaders() }
        ).then(r => r.json());

        const older: any[] = res.data ?? [];

        if (older.length < PAGE_SIZE) {
            hasMoreMessages.value = false;
            destroyObserver();
        }

        messages.value = [...older, ...messages.value];

        await nextTick();

        if (messagesContainer.value) {
            messagesContainer.value.scrollTop =
                messagesContainer.value.scrollHeight - oldScrollHeight;
        }
    } finally {
        isLoadingMore.value = false;
    }
}

function startPolling(dialogueId: number) {
    stopPolling();
    pollInterval = setInterval(() => pollNewMessages(dialogueId), 5000);
}

function stopPolling() {
    if (pollInterval) {
        clearInterval(pollInterval);
        pollInterval = null;
    }
}

async function pollNewMessages(dialogueId: number) {
    if (!lastMessageId.value) return;

    try {
        const res = await fetch(
            `/api/v1/dialogues/${dialogueId}/messages/poll?after_id=${lastMessageId.value}`,
            { headers: apiHeaders() }
        ).then(r => r.json());

        const fresh: any[] = res.data ?? [];
        if (!fresh.length) return;

        messages.value    = [...messages.value, ...fresh];
        lastMessageId.value = fresh.at(-1).id;

        await nextTick();
        scrollToBottom();
    } catch (e) {
        console.error('poll error', e);
    }
}

async function sendMessage() {
    if (!messageText.value.trim() || !activeDialogueId.value) return;

    const text = messageText.value.trim();
    messageText.value = '';

    try {
        const res = await fetch(
            `/api/v1/dialogues/${activeDialogueId.value}/messages`,
            {
                method:  'POST',
                headers: apiHeaders(),
                body:    JSON.stringify({ text }),
            }
        ).then(r => r.json());

        const sent = res.data;
        messages.value.push(sent);
        lastMessageId.value = sent.id;

        await nextTick();
        scrollToBottom();
    } catch (e) {
        messageText.value = text;
        console.error('send error', e);
    }
}

watch(activeDialogueId, () => {
    stopPolling();
    destroyObserver();
});

onUnmounted(() => {
    stopPolling();
    destroyObserver();
});

const props = defineProps<{
    dialogues: Array<{
        id: number;
        participants: Array<{ id: number; name: string; avatar: string; isOnline: string }>;
        lastMessage: { id: number; authorId: number; text: string; createdAt: string; readAt: string | null } | null;
    }>;
    currentUserId: number;
}>();
</script>

<template>
    <MainLayout :hasContainer="false">
        <div class="flex max-w-4xl m-auto w-full mt-10 h-[80vh]">
            <div class="flex flex-col min-w-72 max-w-72 border-r border-white/10">
                <textarea
                    class="w-full p-2 mx-2 mt-2 h-9 mb-3 rounded-xs resize-none text-sm
                           focus:outline-1 focus:outline-offset-2 focus:outline-solid focus:outline-accent"
                    placeholder="Поиск среди диалогов..."/>
                <div class="flex-1 overflow-y-auto scrollbar-surface">
                    <div v-for="dialogue in dialogues"
                        :key="dialogue.id"
                        @click="openDialogue(dialogue.id)"
                        :class="[
                            'flex items-center gap-2 rounded-md p-2 mx-1 cursor-pointer transition-colors',
                            activeDialogueId === dialogue.id
                                ? 'bg-surface-500'
                                : 'hover:bg-surface-600',
                        ]">
                        <template v-if="getInterlocutors(dialogue).length">
                            <User
                                :avatar="getInterlocutors(dialogue)[0].avatar"
                                :last-seen="getInterlocutors(dialogue)[0].isOnline"/>
                            <div class="flex flex-col min-w-0">
                                <p class="font-medium truncate text-sm">
                                    {{ getInterlocutors(dialogue)[0].name }}
                                </p>
                                <div class="flex items-center gap-1">
                                    <p class="text-surface-200 text-xs truncate">
                                        {{ dialogue.lastMessage?.text ?? '…' }}
                                    </p>
                                    <component
                                        :is="dialogue.lastMessage?.readAt ? CheckCheck : Check"
                                        class="text-accent/80 shrink-0"
                                        :size="14"/>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="flex flex-col flex-1 min-w-0">
                <div v-if="activeDialogueId === null"
                    class="flex-1 flex items-center justify-center text-surface-300 select-none">
                    <p class="text-sm">Выберите диалог</p>
                </div>
                <template v-else>
                    <div ref="messagesContainer"
                        class="flex-1 overflow-y-auto overflow-x-hidden px-3 py-2 scrollbar-surface">
                        <div ref="lazyTrigger" class="h-1" />
                        <div v-if="isLoadingMore" class="flex justify-center py-2">
                            <span class="text-xs text-surface-300 animate-pulse">Загрузка…</span>
                        </div>
                        <div v-if="!hasMoreMessages && messages.length" class="flex justify-center py-2">
                            <span class="text-xs text-surface-400">Начало переписки</span>
                        </div>
                        <div v-if="isLoadingMessages" class="flex flex-col gap-2 px-1 py-2">
                            <div
                                v-for="i in 6" :key="i"
                                class="h-8 rounded-md bg-surface-600 animate-pulse"
                                :class="i % 2 === 0 ? 'w-2/3 self-end' : 'w-1/2'"
                            />
                        </div>
                        <template v-for="(msg, index) in messages" :key="msg.id">
                            <MessageDaySeparator
                                v-if="isNewDay(msg, index)"
                                :label="dayLabel(msg.created_at)"
                            />
                            <Message
                                class="mt-1"
                                :text="msg.user_message"
                                :read="!!msg.read_at"
                                :date="msg.created_at?.split('T')[1].slice(0, 5) ?? ''"
                                :read-date="msg.read_at?.split('T')[1].slice(0, 5) ?? null"
                                :type="msg.author_id === currentUserId ? 'receiver' : 'sender'"
                            />
                        </template>
                    </div>
                    <div class="p-3 border-t border-white/10 relative flex items-end gap-2">
                        <textarea
                            v-model="messageText"
                            @keydown.enter.prevent="sendMessage"
                            rows="2"
                            class="flex-1 p-2 rounded-md resize-none text-sm
                                   focus:outline-1 focus:outline-offset-2
                                   focus:outline-solid focus:outline-accent"
                            placeholder="Введите сообщение…"/>
                        <SmileBox :insertSmilesTo="insertSmile" />
                        <button @click="sendMessage"
                                class="p-2 rounded-md bg-accent hover:bg-accent/80 transition shrink-0">
                            <Send :size="18" />
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </MainLayout>
</template>
