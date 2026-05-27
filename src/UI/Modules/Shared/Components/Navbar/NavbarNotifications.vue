<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { onClickOutside, useInfiniteScroll } from '@vueuse/core'
import { Bell } from 'lucide-vue-next'

const csrf = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content')

const page = usePage()
const open = ref(false)
const containerRef = ref(null)
const listRef = ref(null)

const normalizeNotification = (notification) => ({
    id: notification.id,
    title: notification.label,
    body: notification.text,
    link: notification.link,
    read: Boolean(notification.read),
    date: notification.created_at,
})

const notifications = ref(
    page.props.notifications.data.map(normalizeNotification)
)

const loading = ref(false)

const currentPage = ref(
    page.props.notifications.current_page
)

const lastPage = ref(
    page.props.notifications.last_page
)

const unreadCount = computed(() =>
    notifications.value.filter(n => !n.read).length
)

const hasMore = computed(() =>
    currentPage.value < lastPage.value
)

const toggle = () => {
    open.value = !open.value
}

const loadNotifications = async (page = 1) => {
    if (loading.value) return

    loading.value = true

    try {
        const response = await fetch(`/api/v1/notifications/?page=${page}`, {
            headers: {
                Accept: 'application/json',
            },
        })

        const data = await response.json()

        notifications.value.push(
            ...data.data.map(normalizeNotification)
        )

        currentPage.value = data.current_page
        lastPage.value = data.last_page
    } finally {
        loading.value = false
    }
}

const loadMore = async () => {
    if (!hasMore.value || loading.value) return

    await loadNotifications(currentPage.value + 1)
}

useInfiniteScroll(
    listRef,
    loadMore,
    {
        distance: 100,
    }
)

const markRead = async (id) => {
    const notification = notifications.value.find(n => n.id === id)

    if (!notification || notification.read) return

    notification.read = true

    try {
        await fetch(`/api/v1/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
            },
        })
    } catch {
        notification.read = false
    }

    if (notification.link) {
        window.location.href = notification.link
    }
}

const markAllRead = async () => {
    notifications.value.forEach(n => {
        n.read = true
    })

    try {
        await fetch('/api/v1/notifications/readAll', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
        })
    } catch {
        notifications.value.forEach(n => {
            n.read = false
        })
    }
}

const formatDate = (iso) => {
    return new Date(iso).toLocaleString('ru-RU', {
        day: '2-digit',
        month: 'short',
        hour: '2-digit',
        minute: '2-digit',
    })
}

onClickOutside(containerRef, () => {
    open.value = false
})
</script>

<template>
    <div class="relative" ref="containerRef">
        <button
            @click="toggle"
            class="cursor-pointer relative p-2 rounded-lg hover:bg-surface-600 transition-colors">
            <Bell class="w-5 h-5" />

            <span
                v-if="unreadCount > 0"
                class="absolute top-1 right-1 w-4 h-4 bg-red-500 rounded-full
                text-white text-[10px] font-bold flex items-center justify-center">
                {{ unreadCount }}
            </span>
        </button>

        <Transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1">

            <div
                v-if="open"
                class="absolute right-0 mt-2 w-80 bg-surface-700 border border-surface-600
                rounded-xl shadow-xl z-50 overflow-hidden">

                <div
                    class="px-4 py-3 border-b border-surface-600 flex items-center justify-between">

                    <span class="font-semibold text-sm">
                        Уведомления
                    </span>

                    <button
                        v-if="unreadCount > 0"
                        @click="markAllRead"
                        class="cursor-pointer text-xs text-blue-400 hover:text-blue-300 transition-colors">

                        Прочитать все
                    </button>
                </div>

                <ul
                    ref="listRef"
                    class="divide-y divide-surface-600 max-h-80 overflow-y-auto">

                    <li
                        v-for="n in notifications"
                        :key="n.id"
                        class="px-4 py-3 hover:bg-surface-600 transition-colors cursor-pointer"
                        :class="{ 'opacity-50': n.read }"
                        @click="markRead(n.id)">

                        <div class="flex items-start gap-2">
                            <span
                                v-if="!n.read"
                                class="mt-1.5 w-2 h-2 rounded-full bg-blue-400 shrink-0" />

                            <span
                                v-else
                                class="mt-1.5 w-2 h-2 shrink-0" />

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">
                                    {{ n.title }}
                                </p>

                                <p class="text-xs text-surface-300 mt-0.5 line-clamp-2">
                                    {{ n.body }}
                                </p>

                                <p class="text-[11px] text-surface-400 mt-1">
                                    {{ formatDate(n.date) }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li
                        v-if="loading"
                        class="px-4 py-4 text-center text-sm text-surface-400">

                        Загрузка...
                    </li>
                </ul>

                <div
                    v-if="!loading && notifications.length === 0"
                    class="px-4 py-6 text-center text-sm text-surface-400">

                    Нет уведомлений
                </div>
            </div>
        </Transition>
    </div>
</template>
