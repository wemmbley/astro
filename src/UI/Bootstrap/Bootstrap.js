import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { VueQueryPlugin } from '@tanstack/vue-query'
import './App.css';
import { createPinia } from 'pinia'

const pinia = createPinia()

createInertiaApp({
    resolve: name =>
        resolvePageComponent(
            `../Pages/${name}.vue`,
            import.meta.glob('../Pages/**/*.vue')
        ),

    setup({ el, App, props, plugin }) {
        createApp({
            render: () => h(App, props),
        })
        .use(plugin)
        .use(VueQueryPlugin)
        .use(pinia)
        .mount(el)
    },
})
