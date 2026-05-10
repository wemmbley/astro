import { marked } from 'marked'

const renderer = new marked.Renderer()

renderer.heading = ({ tokens, depth }) => {
    const text = tokens.map(t => t.raw).join('')

    // смещение заголовков
    const level = Math.min(depth + 1, 6)

    const classes: Record<number, string> = {
        2: 'title',
        3: 'subtitle',
        4: 'subtitle-4',
        5: 'subtitle-5',
    }

    const className = classes[level] ?? ''

    return `<h${level} class="${className}">${text}</h${level}>`
}

marked.use({ renderer })

export default marked

export function parseInterpretation(text: string) {
    const lines = text
        .split('\n')
        .map(l => l.trim())
        .filter(Boolean)

    const title = lines[0]

    const tagsIndex = lines.findIndex(l => l.toLowerCase() === 'тэги')

    const tags =
        tagsIndex !== -1
            ? lines[tagsIndex + 1] ?? ''
            : ''

    const full = text

    return {
        title,
        tags,
        full,
    }
}
