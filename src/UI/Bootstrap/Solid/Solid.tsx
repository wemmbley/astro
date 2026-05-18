import { render } from 'solid-js/web'
import { createRoot } from 'solid-js'
import type { Component } from 'solid-js'

export function mountSolid(
    Component: Component<any>,
    el: HTMLElement,
    props?: Record<string, any>
): () => void {
    let renderDispose!: () => void

    // createRoot изолирует реактивный граф — каждый островок независим
    const rootDispose = createRoot((dispose) => {
        renderDispose = render(() => <Component {...(props ?? {})} />, el)
        return dispose
    })

    // Возвращаем функцию полной очистки: сначала DOM, потом реактивный root
    return () => {
        renderDispose()
        rootDispose()
    }
}
