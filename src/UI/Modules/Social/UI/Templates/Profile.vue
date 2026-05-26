<script setup lang="ts">
import DefaultBanner from "@/Resources/Assets/Profile/DefaultBanner.jpg";
import DefaultAvatarMan from "@/Resources/Assets/Profile/NoAvatarManXS.jpg";
import { Mail, ShieldBan, UserRoundPlus, ZodiacCapricorn } from 'lucide-vue-next'
import { ref } from 'vue'
import Modal from "@/Modules/Shared/Components/Modal.vue";
import Tooltip from "@/Modules/Shared/Components/Tooltip.vue";
import AvatarGrid from "@/Modules/Social/UI/Components/Molecules/AvatarGrid.vue";
import Posts from "@/Modules/Social/UI/Components/Organisms/Posts.vue";
import AstroProfile from "@/Modules/Social/UI/Components/Molecules/AstroProfile.vue";
import {friends, subscriptions} from "@/Modules/Social/Domain/Mocks/Social.ts"

const showBlockModal = ref(false)
</script>

<template>
    <Modal title="Блокировка" v-model:show="showBlockModal">
        <p>Вы действительно хотите заблокировать данного пользователя? </p>
        <p>Вы всегда сможете отменить данное действие. </p>
        <p class="pt-2">Так же вы можете отправить на данный аккаунт
            <a href="#" class="text-accent hover:underline">жалобу</a>,
        </p>
        <p>если считаете его контент общественно-неприемлимым.</p>
    </Modal>
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
                            <span class="flex">
                                <ZodiacCapricorn size="30" />
                                <span class="ms-1">Holiev Rustam</span>
                            </span>
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
        <AstroProfile />
        <div class="flex flex-col gap-6">
            <div class="grid grid-cols-2 gap-4 mt-2">
                <AvatarGrid
                    :items="friends"
                    label="Друзья"
                    button-text="Все друзья"
                />
                <AvatarGrid
                    :items="subscriptions"
                    label="Подписки"
                    button-text="Все подписки"
                />
            </div>
            <h2 class="text-surface-200 uppercase text-md font-bold mt-4">
                Посты
                <span class="ml-1 border border-surface-600
                    text-accent rounded-md font-normal pl-1 pr-1">
                        22
                    </span>
            </h2>
            <Posts />
        </div>
    </div>
</template>
