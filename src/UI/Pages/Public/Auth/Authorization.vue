<script setup lang="ts">
defineProps({
    navbar: Object,
})
</script>

<template>
    <div class="min-h-screen bg-surface-950 flex items-center justify-center p-6">
        <div
            class="w-full max-w-md rounded-3xl border border-surface-800
            bg-surface-900/80 backdrop-blur-xl shadow-2xl shadow-black/40"
        >
            <div class="p-8">
                <div class="mb-8 text-center">
                    <div
                        class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl
                        bg-accent-500/15 ring-1 ring-accent-500/30">
                        <svg
                            class="h-8 w-8 text-accent-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-3A2.25 2.25 0 008.25 5.25V9m-2.25 0h12A2.25 2.25 0 0120.25 11.25v6.5A2.25 2.25 0 0118 20H6a2.25 2.25 0 01-2.25-2.25v-6.5A2.25 2.25 0 016 9z"
                            />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold tracking-tight text-surface-50">
                        Авторизация
                    </h1>
                    <p class="mt-2 text-sm text-surface-400">
                        Введите свои данные для продолжения.
                    </p>
                </div>
                <form class="space-y-5">
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-surface-300">
                            Email
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg
                                    class="h-5 w-5 text-surface-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15A2.25 2.25 0 012.25 17.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75m19.5 0l-8.69 5.516a2.25 2.25 0 01-2.12 0L2.25 6.75"
                                    />
                                </svg>
                            </div>
                            <input
                                id="email"
                                type="email"
                                placeholder="you@example.com"
                                class="w-full rounded-2xl border border-surface-600 bg-surface-700/80
                                py-3.5 pl-12 pr-4 text-surface-200 placeholder:text-surface-500
                                outline-none transition-all duration-200 focus:border-accent-500
                                focus:ring-2 focus:ring-accent-500/15"
                            />
                        </div>
                    </div>
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-surface-300">
                                Пароль
                            </label>
                            <a href="#" class="text-sm text-accent-400 transition hover:text-accent-300">
                                Восстановить?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg
                                    class="h-5 w-5 text-surface-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5m-.75 0h9.75A2.25 2.25 0 0119.5 12.75v5.25A2.25 2.25 0 0117.25 20.25H6.75A2.25 2.25 0 014.5 18v-5.25A2.25 2.25 0 016.75 10.5z"
                                    />
                                </svg>
                            </div>
                            <input
                                id="password"
                                type="password"
                                placeholder="••••••••"
                                class="w-full rounded-2xl border border-surface-600 bg-surface-700/80
                                py-3.5 pl-12 pr-4 text-surface-200 placeholder:text-surface-500
                                outline-none transition-all duration-200 focus:border-accent-500
                                focus:ring-2 focus:ring-accent-500/15"
                            />
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="group flex w-full items-center justify-center gap-3
                        rounded-2xl bg-accent-500 px-5 py-3.5 font-semibold text-accent
                        shadow-lg shadow-accent-500/20 transition-all duration-200 cursor-pointer
                        hover:bg-accent-400 hover:shadow-accent-500/40 active:scale-[0.99]"
                    >
                        <svg
                            class="h-5 w-5 transition-transform duration-200 group-hover:translate-x-0.5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />
                        </svg>
                        Войти
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
