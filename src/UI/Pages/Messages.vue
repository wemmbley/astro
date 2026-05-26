<script setup lang="ts">
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import Messenger from "@/Modules/Messenger/UI/Templates/Messenger.vue";

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
        <Messenger :dialogues="dialogues" :currentUserId="currentUserId" />
    </MainLayout>
</template>
