import { marked } from 'marked'
import fm from 'front-matter'

export type Block =
    | { type: 'heading'; level: number; text: string }
    | { type: 'paragraph'; text: string }
    | { type: 'list'; ordered: boolean; items: string[] }
    | { type: 'code'; lang: string; text: string }
    | { type: 'image'; href: string; alt: string; link?: string }
    | { type: 'hr' }

export interface Section {
    heading: string
    level: number
    blocks: Block[]
}

export interface ParsedMarkdown {
    attributes: Record<string, any>
    sections: Section[]
    get: (heading: string) => Section | undefined
    byLevel: (level: number) => Section[]
}

function tokenToBlocks(tokens: marked.Token[]): Block[] {
    const blocks: Block[] = []

    for (const t of tokens) {
        if (t.type === 'paragraph') {
            const children = t.tokens ?? []

            // [![alt](src)](url) — link содержащий image
            const linkWithImage = children.find(
                (i: any) => i.type === 'link' && i.tokens?.some((j: any) => j.type === 'image')
            ) as any

            // просто ![alt](src) без ссылки
            const bareImage = children.find((i: any) => i.type === 'image') as any

            if (linkWithImage) {
                const img = linkWithImage.tokens.find((j: any) => j.type === 'image')
                blocks.push({
                    type: 'image',
                    href: img.href,
                    alt:  img.text ?? img.alt ?? '',
                    link: linkWithImage.href,
                })
            } else if (bareImage) {
                blocks.push({
                    type: 'image',
                    href: bareImage.href,
                    alt:  bareImage.text ?? bareImage.alt ?? '',
                })
            } else {
                // сохраняем raw чтобы не потерять \n внутри параграфа
                blocks.push({ type: 'paragraph', text: t.raw.trim() })
            }
        } else if (t.type === 'list') {
            blocks.push({
                type: 'list',
                ordered: t.ordered,
                items: t.items.map((i: any) => i.text),
            })
        } else if (t.type === 'code') {
            blocks.push({ type: 'code', lang: t.lang ?? '', text: t.text })
        } else if (t.type === 'hr') {
            blocks.push({ type: 'hr' })
        }
    }

    return blocks
}

export function parseMarkdown(source: string): ParsedMarkdown {
    const parsed    = fm<Record<string, any>>(source)
    const allTokens = marked.lexer(parsed.body)

    const sections: Section[] = []
    let current: { heading: string; level: number; tokens: marked.Token[] } = {
        heading: '',
        level: 0,
        tokens: [],
    }

    for (const token of allTokens) {
        if (token.type === 'heading') {
            if (current.tokens.length > 0 || current.level > 0) {
                sections.push({
                    heading: current.heading,
                    level:   current.level,
                    blocks:  tokenToBlocks(current.tokens),
                })
            }
            current = { heading: token.text, level: token.depth, tokens: [] }
        } else {
            current.tokens.push(token)
        }
    }

    if (current.level > 0 || current.tokens.length > 0) {
        sections.push({
            heading: current.heading,
            level:   current.level,
            blocks:  tokenToBlocks(current.tokens),
        })
    }

    return {
        attributes: parsed.attributes,
        sections,
        get:     (heading) => sections.find(s => s.heading === heading),
        byLevel: (level)   => sections.filter(s => s.level === level),
    }
}

export function sectionsToBlocks(sections: Section[]): Block[] {
    return sections.flatMap(s => [
        ...(s.level > 0
                ? [{ type: 'heading' as const, level: s.level, text: s.heading }]
                : []
        ),
        ...s.blocks,
    ])
}
