<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import DefaultBanner from "@/../img/Profile/default_banner.jpg";
import DefaultAvatarMan from "@/../img/Profile/no_avatar_man_xs.jpg";

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar">
        <div class="w-full flex flex-col gap-4">
            <div class="relative w-full">
                <img
                    :src="DefaultBanner"
                    alt="user banner"
                    class="w-full h-56 object-cover object-center rounded-2xl border-2 border-surface-600"
                />
                <div class="absolute inset-0 rounded-2xl bg-linear-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-5 left-6 flex items-end gap-5 z-10">
                    <img
                        :src="DefaultAvatarMan"
                        alt="user avatar"
                        class="w-24 h-24 rounded-full object-cover border-4 border-surface-700 shadow-lg"
                    />
                    <div class="pb-1">
                        <h2 class="text-white text-2xl font-semibold tracking-wide">
                            Holiev Rustam
                        </h2>
                        <p class="text-gray-200 text-sm italic">
                            Потомственный маг и экстрасенс
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-cream px-1">
                <details class="group rounded-xl border border-surface-600 bg-surface-700/40 p-4">
                    <summary class="cursor-pointer font-medium select-none hover:text-white transition">
                        Показать подробную информацию
                    </summary>
                    <div class="mt-4 space-y-2 text-sm text-gray-300">
                        <p>
                            Персональная натальная карта:
                            <a href="#" class="text-blue-300 hover:text-blue-200">ссылка</a>
                        </p>
                        <p>
                            Персональная матрица судьбы:
                            <a href="#" class="text-blue-300 hover:text-blue-200">ссылка</a>
                        </p>
                    </div>
                </details>
            </div>
        </div>
    </MainLayout>
</template>
