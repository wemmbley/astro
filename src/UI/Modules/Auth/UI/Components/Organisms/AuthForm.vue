<script setup lang="ts">
import PasswordField from "@/Modules/Auth/UI/Components/Atoms/PasswordField.vue";
import EnterButton from "@/Modules/Auth/UI/Components/Atoms/EnterButton.vue";
import BlockIcon from "@/Modules/Auth/UI/Components/Atoms/BlockIcon.vue";
import EmailField from "@/Modules/Auth/UI/Components/Atoms/EmailField.vue";
import {ref} from "vue";

const password = ref<string>('');
const email = ref<string>('');
</script>

<template>
    <div class="p-8">
        <div class="mb-8 text-center">
            <BlockIcon />
            <h1 class="text-3xl font-bold tracking-tight text-surface-50">
                Авторизация
            </h1>
            <p class="mt-2 text-sm text-surface-200">
                Введите свои данные для продолжения.
            </p>
        </div>
        <form class="space-y-5">
            <EmailField v-model="email" />
            <PasswordField v-model="password" />
            <a href="/auth/register" class="text-sm text-accent transition hover:text-accent-300">
                Может, зарегестрируемся? Это бесплатно!
            </a>
            <EnterButton label="Войти" />
        </form>
    </div>
</template>
