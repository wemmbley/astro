import { createSignal } from 'solid-js'

export default function Test() {
    const [count, setCount] = createSignal(0)

    return (
        <div class="text-white z-99 absolute">
            <button onClick={() => setCount(count() + 1)}>
                <p>Count: {count()}</p>
            </button>
        </div>
    )
}
