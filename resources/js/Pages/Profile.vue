<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import DefaultBanner from "@/../img/Profile/default_banner.jpg";

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar">
        <div class="w-full flex flex-col gap-3">
            <img
                :src="DefaultBanner"
                alt="default user's banner"
                class="w-full h-48 object-cover object-center rounded-2xl"
            />

            <div class="text-cream">
                <h2>
                    Holiev Rustam
                </h2>
                <p>Потомственный маг и экстрасенс.</p>
                <div class="mt-2">
                    <p>Персональная натальная карта: ссылка</p>
                    <p>Персональная матрица судьбы: ссылка</p>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
