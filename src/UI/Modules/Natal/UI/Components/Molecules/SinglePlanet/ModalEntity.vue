<script setup lang="ts">
import Modal from "@/Modules/Shared/Components/Modal.vue";
import Markdown from "@/Modules/Shared/Components/Markdown.vue";
</script>

<template>
    <Modal wide :title="entityTitle" :show="!!modals['entity']" @update:show="closeModal('entity')">
        <Markdown :blocks="allBlocks(entityMd)" />
    </Modal>
</template>
