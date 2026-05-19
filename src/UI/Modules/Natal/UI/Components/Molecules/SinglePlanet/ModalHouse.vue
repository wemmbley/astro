<script setup lang="ts">
import Modal from "@/Modules/Shared/Components/Modal.vue";
import Markdown from "@/Modules/Shared/Components/Markdown.vue";
</script>

<template>
    <Modal wide
           :title="houseTranslations[planet.house as HouseType]"
           :show="!!modals['house']"
           @update:show="closeModal('house')"
    >
        <Markdown :blocks="allBlocks(houseMd)" />
    </Modal>
</template>
