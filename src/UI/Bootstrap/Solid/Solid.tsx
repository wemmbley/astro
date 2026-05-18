import { render } from 'solid-js/web'

export function mountSolid(Component: any, el: HTMLElement, props?: any) {
    return render(() => <Component {...props} />, el)
}
