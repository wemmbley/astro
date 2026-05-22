<script setup lang="ts">
import PasswordField from "@/Modules/Auth/UI/Components/Atoms/PasswordField.vue";
import EnterButton from "@/Modules/Auth/UI/Components/Atoms/EnterButton.vue";
import BlockIcon from "@/Modules/Auth/UI/Components/Atoms/BlockIcon.vue";
import EmailField from "@/Modules/Auth/UI/Components/Atoms/EmailField.vue";
import {ref} from "vue";
import CodeField from "@/Modules/Auth/UI/Components/Atoms/CodeField.vue";
import { useForm } from '@inertiajs/vue3'

const code = ref<string>('');
const step = ref(1);

const form = useForm({
    email: '',
    password: '',
    password_confirmation: '',
})
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
        <form @submit.prevent="form.post('/register')">
            <div v-if="step === 1" class="space-y-5">

                <EmailField v-model="form.email" label="Введите Вашу почту" />
                <p class="text-red-500" v-if="form.errors.email">
                    * {{ form.errors.email }}
                </p>

                <PasswordField v-model="form.password" label="Придумайте пароль" />
                <p class="text-red-500" v-if="form.errors.password">
                    * {{ form.errors.password }}
                </p>

                <PasswordField v-model="form.password_confirmation" label="Повторите пароль" />
                <p class="text-red-500" v-if="form.errors.password_confirmation">
                    * {{ form.errors.password_confirmation }}
                </p>

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
