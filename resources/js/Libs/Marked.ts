import { marked } from 'marked'
import fm from 'front-matter'

export type Block =
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
            const imageToken = (t.tokens ?? []).find(i => i.type === 'image') as any
            const linkToken  = (t.tokens ?? []).find(i => i.type === 'link')  as any

            if (imageToken) {
                blocks.push({
                    type: 'image',
                    href: imageToken.href,
                    alt:  imageToken.text,
                    link: linkToken?.href,
                })
            } else {
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
        // space и прочий шум — пропускаем
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
