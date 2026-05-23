<script setup>
import DefaultBanner from "@/Resources/Assets/Profile/DefaultBanner.jpg";
import DefaultAvatarMan from "@/Resources/Assets/Profile/NoAvatarManXS.jpg";
import { Mail, ShieldBan, UserRoundPlus, ZodiacCapricorn } from 'lucide-vue-next'
import { ref } from 'vue'
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import Modal from "@/Modules/Shared/Components/Modal.vue";
import Tooltip from "@/Modules/Shared/Components/Tooltip.vue";
import AvatarGrid from "@/Modules/Social/UI/Components/Molecules/AvatarGrid.vue";
import Posts from "@/Modules/Social/UI/Components/Organisms/Posts.vue";
import AstroProfile from "@/Modules/Social/UI/Components/Molecules/AstroProfile.vue";

const friends = ref([
    { id: 1, name: 'Каролина Дарк', lastSeen: 'online',    avatar: 'https://i.pinimg.com/736x/f0/2e/c5/f02ec5df4ecc74356b9300151cb069f4.jpg' },
    { id: 2, name: 'Иисус Христос', lastSeen: 'online', avatar: 'https://i.pinimg.com/736x/3b/a6/88/3ba68836da08177bf1b3927ea64b1704.jpg' },
    { id: 3, name: 'Элли Хромова',  lastSeen: '02.05.2026 10:00',  avatar: 'https://i.pinimg.com/736x/82/1b/81/821b81fb0a280d1f9c455935ee2ab8de.jpg' },
    { id: 4, name: 'Вероника Мирошниченко', lastSeen: '02.05.2026 10:00',   avatar: 'https://i.pinimg.com/736x/74/0e/7a/740e7a9f66c3343c99befef4c757cba1.jpg' },
    { id: 5, name: 'Наташа Лиса', lastSeen: '02.05.2026 10:00', avatar: 'https://i.pinimg.com/736x/47/ff/ca/47ffcaba8a46de68c4c72ffd95cc8a6a.jpg' },
    { id: 6, name: 'Отчаянная Грешница', lastSeen: '02.05.2026 10:00',   avatar: 'https://i.pinimg.com/736x/e9/fa/5b/e9fa5b95260c61f47a189ea04d794ffa.jpg' },
    { id: 7, name: 'Церковный Обряд',   lastSeen: '02.05.2026 10:00',   avatar: 'https://i.pinimg.com/1200x/53/de/49/53de496410fb6518b78a2b6f9092b64c.jpg' },
])
const subscriptions = ref([
    { id: 1, name: 'Лотос Безмятежности',    avatar: 'https://i.pinimg.com/1200x/64/bd/1b/64bd1bea46c5de53ad880d5cef027694.jpg' },
    { id: 2, name: 'Крылья Ангела',     avatar: 'https://i.pinimg.com/736x/5d/18/e3/5d18e3caaa23bf34c8ea704e79456eb7.jpg' },
    { id: 3, name: 'Отчаянная Душа',  avatar: 'https://i.pinimg.com/736x/e9/1a/3d/e91a3db898369493496b168894c5763c.jpg' },
    { id: 4, name: 'Тепло Надежды',  avatar: 'https://i.pinimg.com/736x/f8/19/e8/f819e8991eebfd54c156e5634945400d.jpg' },
    { id: 5, name: 'Просветлённое Безумие',   avatar: 'https://i.pinimg.com/736x/bb/ee/a4/bbeea43bdb39b0b4c038e56dd42b682c.jpg' },
    { id: 6, name: 'Царица Острова',    avatar: 'https://i.pinimg.com/736x/16/ed/bf/16edbf21444d884f6b62b4c42362d22a.jpg' },
    { id: 7, name: 'Лиза Фёдорова',   avatar: 'https://randomuser.me/api/portraits/women/21.jpg' },
    { id: 8, name: 'Роман Белов',     avatar: 'https://randomuser.me/api/portraits/men/63.jpg' },
])

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
                    <span class="ml-1 border border-surface-600 text-accent rounded-md font-normal pl-1 pr-1">22</span>
                </h2>
                <Posts />
            </div>
        </div>
    </MainLayout>
</template>
