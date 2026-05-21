import { defineStore } from 'pinia'
import { ref } from 'vue'
import {AuthRole} from "@/Modules/Auth/Domain/Types/AuthRole";

export const useSharedStore = defineStore('shared', () => {
    const navbar = ref<any>(null)
    const role = ref<AuthRole>('guest')

    function fill(data: {
        navbar: any
        role: AuthRole
    }) {
        navbar.value = data.navbar
        role.value = data.role
    }

    return {
        navbar,
        role,
        fill
    }
})
