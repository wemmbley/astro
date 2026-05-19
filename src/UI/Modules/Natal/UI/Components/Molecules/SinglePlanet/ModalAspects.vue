<script setup lang="ts">
import Modal from "@/Modules/Shared/Components/Modal.vue";
import Markdown from "@/Modules/Shared/Components/Markdown.vue";
</script>

<template>
    <template v-for="a in planet.aspects" :key="`modal-${a.name}-${a.target}`">
        <Modal wide
               :title="`${aspectTranslations[a.name as AspectType]} → ${planetTranslations[a.target as PlanetType]}`"
               :show="!!modals[aspectKey(a.name, a.target)]"
               @update:show="closeModal(aspectKey(a.name, a.target))"
        >
            <Markdown :blocks="allBlocks(aspectMdMap[aspectKey(a.name, a.target)] ?? null)" />
        </Modal>
    </template>
</template>
