<script setup lang="ts">
import Modal from "@/Modules/Shared/Components/Modal.vue";
import Markdown from "@/Modules/Shared/Components/Markdown.vue";
</script>

<template>
    <Modal wide
           :title="signTranslations[planet.sign as SignType]"
           :show="!!modals['sign']"
           @update:show="closeModal('sign')"
    >
        <Markdown :blocks="allBlocks(signMd)" />
    </Modal>
</template>
