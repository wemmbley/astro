import { computed, ref } from 'vue'

function range(start: number, end: number) {
    return Array.from(
        { length: end - start + 1 },
        (_, i) => start + i
    )
}

interface UseDateSelectOptions {
    year?: number
    month?: number
    day?: number
    hour?: number
    minute?: number
}

export function useDateSelect(options: UseDateSelectOptions = {}) {
    const selectedYear = ref(options.year ?? 2000)
    const selectedMonth = ref(options.month ?? 12)
    const selectedDay = ref(options.day ?? 1)
    const selectedHour = ref(options.hour ?? 12)
    const selectedMinute = ref(options.minute ?? 0)

    const years = computed(() => range(1900, 2100))
    const months = computed(() => range(1, 12))
    const days = computed(() => range(1, 31))
    const hours = computed(() => range(0, 23))
    const minutes = computed(() => range(0, 59))

    return {
        selectedYear,
        selectedMonth,
        selectedDay,
        selectedHour,
        selectedMinute,

        years,
        months,
        days,
        hours,
        minutes
    }
}
