import { ref, watch } from 'vue'

const STORAGE_KEY = 'tree-open-state'

function loadFromStorage(): Record<number, boolean> {
    try {
        const saved = localStorage.getItem(STORAGE_KEY)
        return saved ? JSON.parse(saved) : {}
    } catch {
        return {}
    }
}

const openMap = ref<Record<number, boolean>>(loadFromStorage())

watch(
    openMap,
    (newMap) => {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(newMap))
    },
    { deep: true }
)

export function useTreeState() {

    const isOpen = (id: number): boolean => {
        return openMap.value[id] ?? false
    }

    const toggle = (id: number): void => {
        openMap.value[id] = !isOpen(id)
    }

    const expandAll = (ids: number[]): void => {
        ids.forEach(id => { openMap.value[id] = true })
    }

    const collapseAll = (ids: number[]): void => {
        ids.forEach(id => { openMap.value[id] = false })
    }

    return { isOpen, toggle, expandAll, collapseAll }
}
