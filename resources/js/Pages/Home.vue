<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import LandingImage from "@/../img/hero.png";
import LandingBackground from "@/../img/landing-background.png";

const MOCK_NEWS = [
    {
        id: 1,
        date: '2026-05-04',
        title: 'Платформа обновлена до версии 3.0',
        body: 'Полный редизайн интерфейса, новый модуль аналитики и улучшенная производительность на мобильных устройствах.',
    },
    {
        id: 2,
        date: '2026-05-03',
        title: 'Интеграция с внешними API',
        body: 'Добавлена поддержка webhook-уведомлений и OAuth 2.0 для сторонних сервисов.',
    },
    {
        id: 3,
        date: '2026-04-28',
        title: 'Плановое техническое обслуживание',
        body: 'Сервис был недоступен с 02:00 до 04:00. Все данные сохранены, инциденты устранены.',
    },
    {
        id: 4,
        date: '2026-04-21',
        title: 'Новые роли и права доступа',
        body: 'Теперь можно гибко настраивать права для каждой роли: просмотр, редактирование, удаление.',
    },
    {
        id: 5,
        date: '2026-04-14',
        title: 'Экспорт отчётов в PDF',
        body: 'Добавлена возможность экспортировать любой отчёт в PDF одним кликом прямо из дашборда.',
    },
]

const formatDate = (iso) =>
    new Date(iso).toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    });

const isFresh = (dateStr) =>
    (Date.now() - new Date(dateStr)) / (1000 * 60 * 60 * 24) <= 3;

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <MainLayout :navbar="navbar" :hasContainer="false">
        <div class="relative flex mt-20 justify-center overflow-hidden ">
            <div class="flex flex-col z-10">
                <img :src=LandingImage alt="banner" class="h-70 mt-20" />
                <button class="border border-surface-200 rounded-md p-2 transition cursor-pointer text-surface-100 w-60 ml-auto hover:text-accent hover:border-accent">
                    Telegram
                </button>
            </div>
            <div class="border border-surface-500 rounded-xl w-110 h-140 ml-15 bg-surface-700/50 z-10 flex flex-col overflow-hidden">

                <!-- Заголовок -->
                <div class="px-5 pt-5 pb-4 border-b border-surface-600 shrink-0">
                    <h2 class="text-cream text-base font-semibold">
                        Новости
                    </h2>
                </div>

                <!-- Список -->
                <div
                    class="flex flex-col overflow-y-auto flex-1 divide-y divide-surface-600/60"
                    style="scrollbar-width: none; -ms-overflow-style: none;"
                >
                    <article
                        v-for="item in MOCK_NEWS"
                        :key="item.id"
                        class="relative px-5 py-4 hover:bg-surface-600/40 transition-colors cursor-default"
                    >
                        <!-- Точка свежей новости -->
                        <span
                            v-if="isFresh(item.date)"
                            class="absolute right-5 top-5 w-2 h-2 rounded-full bg-accent"
                        />

                        <time class="block text-xs text-surface-400 mb-1.5 tracking-wide">
                            {{ formatDate(item.date) }}
                        </time>

                        <h3 class="text-sm font-semibold text-cream leading-snug mb-2 pr-5">
                            {{ item.title }}
                        </h3>

                        <p class="text-xs text-surface-300 leading-relaxed line-clamp-2">
                            {{ item.body }}
                        </p>
                    </article>
                </div>

            </div>
            <img :src=LandingBackground alt="banner" class="absolute b-0 right-0 translate-x-15 translate-y-20 opacity-50 z-0" />
        </div>
    </MainLayout>
</template>
