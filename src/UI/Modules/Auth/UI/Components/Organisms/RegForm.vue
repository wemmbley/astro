<script setup lang="ts">
import PasswordField from "@/Modules/Auth/UI/Components/Atoms/PasswordField.vue";
import EnterButton from "@/Modules/Auth/UI/Components/Atoms/EnterButton.vue";
import BlockIcon from "@/Modules/Auth/UI/Components/Atoms/BlockIcon.vue";
import EmailField from "@/Modules/Auth/UI/Components/Atoms/EmailField.vue";
import {ref} from "vue";
import CodeField from "@/Modules/Auth/UI/Components/Atoms/CodeField.vue";

const password = ref<string>('');
const repeatPassword = ref<string>('');
const email = ref<string>('');
const code = ref<string>('');
const step = ref(2);
</script>

<template>
    <div class="p-8">
        <div class="mb-8 text-center">
            <BlockIcon />
            <h1 class="text-3xl font-bold tracking-tight text-surface-50">
                Регистрация
            </h1>
            <p class="mt-2 text-sm text-surface-200">
                Наш сайт позволяет Вам пройти регистрацию, и стать частью большой астрологической семьи!
            </p>
        </div>
        <form>
            <div v-if="step === 1" class="space-y-5">
                <EmailField v-model="email" label="Введите Вашу почту" />
                <PasswordField v-model="password" label="Придумайте пароль" />
                <PasswordField v-model="repeatPassword" label="Повторите пароль" />
                <EnterButton label="Зарегестрироваться" />
            </div>
            <div v-if="step === 2" class="space-y-5">
                <p class="text-surface-100 font-bold">Вам на почту отправлено письмо с кодом!</p>
                <CodeField v-model="code" />
                <EnterButton label="Готово!" class="mt-5" />
            </div>
        </form>
    </div>
</template>
