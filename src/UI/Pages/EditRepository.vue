<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import StarEditor from "@/App/StarEditor/Application/Components/StarEditor.vue";
import {TreeNode} from "@/App/StarEditor/Domain/Types/TreeNode";

const props = defineProps<{
    navbar: object,
    error?: string,
    repository?: { key: string; tree: TreeNode[] },
}>();
</script>

<template>
    <MainLayout :navbar="navbar">
        <template v-if="error">
            {{ error }}
        </template>

        <StarEditor
            :initial-tree-data="repository.tree"
            :editable="true"
        />
    </MainLayout>
</template>
