<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import DefaultBanner from "@/../img/Profile/default_banner.jpg";
import DefaultAvatarMan from "@/../img/Profile/no_avatar_man_xs.jpg";
import { Mail, ShieldBan, UserRoundPlus } from 'lucide-vue-next'
import Modal from "@/Utils/Modal.vue";
import { ref } from 'vue'
import Tooltip from "@/Utils/Tooltip.vue";
import Posts from "@/Components/Profile/Posts.vue";
import Friends from "@/Components/Profile/Friends.vue";
import Subscriptions from "@/Components/Profile/Subscriptions.vue";
import MiniProfileAstro from "@/Components/Profile/MiniProfileAstro.vue";

const showBlockModal = ref(false)

const props = defineProps({
    navbar: Array
});
</script>

<template>
    <Modal title="Блокировка" v-model:show="showBlockModal">
        <p>Вы действительно хотите заблокировать данного пользователя? </p>
        <p>Вы всегда сможете отменить данное действие. </p>
        <p class="pt-2">Так же вы можете отправить на данный аккаунт <a href="#" class="text-accent hover:underline">жалобу</a>,</p>
        <p>если считаете его контент общественно-неприемлимым.</p>
    </Modal>
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
                            <div class="flex">
                                <ZodiacCapricorn size="30" />
                                <span class="ms-1">Holiev Rustam</span>
                            </div>
                        </h2>
                        <p class="text-gray-200 text-sm italic">
                            Потомственный маг и экстрасенс
                        </p>
                    </div>
                </div>
                <div class="absolute bottom-5 right-6 flex items-end gap-2 z-10 text-surface-200 bg-surface-700">
                    <div class="relative group border-1 flex pl-2 pr-2 pt-1 pb-1 transition rounded-sm items-center cursor-pointer hover:text-accent">
                        <Mail size="20" />
                        <Tooltip>Написать сообщение</Tooltip>
                    </div>

                    <div @click="showBlockModal = !showBlockModal"
                         class="relative group border-1 flex pl-2 pr-2 pt-1 pb-1 transition rounded-sm items-center cursor-pointer hover:text-accent">
                        <ShieldBan size="20" />
                        <Tooltip>Пожаловаться или заблокировать</Tooltip>
                    </div>

                    <div class="relative group border-1 flex pl-2 pr-2 pt-1 pb-1 transition rounded-sm items-center cursor-pointer hover:text-accent">
                        <UserRoundPlus size="20" />
                        <Tooltip>Добавить человека в друзья</Tooltip>
                    </div>
                </div>
            </div>

            <MiniProfileAstro />

            <div class="flex flex-col gap-6">
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <Friends />
                    <Subscriptions />
                </div>
                <h2 class="text-white text-xl mt-2">Посты</h2>
                <Posts />
            </div>
        </div>
    </MainLayout>
</template>
