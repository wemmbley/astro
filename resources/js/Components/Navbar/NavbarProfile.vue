<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import { User, LogOut } from 'lucide-vue-next'

const isOpen = ref(false)

function toggle() {
    isOpen.value = !isOpen.value
}

function close() {
    isOpen.value = false
}

const form = useForm()

function logout() {

}
</script>

<template>
    <div class="relative">
        <button
            @click="toggle"
            class="p-2 rounded-lg transition-all
                   hover:bg-surface-600 text-gray-300
                   hover:text-white"
        >
            <User size="20" />
        </button>

        <transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
        >
            <div
                v-if="isOpen"
                class="absolute right-0 mt-2 w-48 z-10
                       bg-surface-600 border border-surface-500
                       rounded-lg shadow-lg overflow-hidden"
            >
                <Link
                    href="/profile"
                    class="block px-4 py-2 text-sm hover:bg-surface-500 text-gray-200"
                    @click="close"
                >
                    Профиль
                </Link>

                <Link
                    href="/astrobase"
                    class="block px-4 py-2 text-sm hover:bg-surface-500 text-gray-200"
                    @click="close"
                >
                    Личная база астрокарт
                </Link>

                <button
                    @click="logout"
                    class="w-full flex items-center gap-2 px-4 py-2 text-sm
                           hover:bg-surface-500 text-red-400"
                >
                    <LogOut size="16" />
                    Выйти
                </button>
            </div>
        </transition>
    </div>
</template>
