import { createContext, useContext, useEffect } from 'react'

interface HeadData {
    title?: string
    description?: string
    ogTitle?: string
    ogDescription?: string
    ogImage?: string
    ogUrl?: string
    ogType?: string
    siteName?: string
    twitterCard?: string
    twitterTitle?: string
    twitterDescription?: string
    twitterImage?: string
    twitterSite?: string
    notFound?: boolean
}

export const HeadContext = createContext<HeadData>({})

export const useHead = (data) => {
    const ctx = useContext(HeadContext)
    Object.assign(ctx, data)

    useEffect(() => {
        if (data.title) document.title = data.title

        const setMeta = (property, content, attr = 'name') => {
            if (!content) return
            let el = document.querySelector(`meta[${attr}="${property}"]`)
            if (!el) {
                el = document.createElement('meta')
                el.setAttribute(attr, property)
                document.head.appendChild(el)
            }
            el.setAttribute('content', content)
        }

        setMeta('description', data.description)

        // Open Graph
        setMeta('og:title', data.ogTitle ?? data.title, 'property')
        setMeta('og:description', data.ogDescription ?? data.description, 'property')
        setMeta('og:image', data.ogImage, 'property')
        setMeta('og:url', data.ogUrl, 'property')
        setMeta('og:type', data.ogType ?? 'website', 'property')
        setMeta('og:site_name', data.siteName, 'property')

        // Twitter
        setMeta('twitter:card', data.twitterCard ?? 'summary_large_image')
        setMeta('twitter:title', data.twitterTitle ?? data.ogTitle ?? data.title)
        setMeta('twitter:description', data.twitterDescription ?? data.ogDescription ?? data.description)
        setMeta('twitter:image', data.twitterImage ?? data.ogImage)
        setMeta('twitter:site', data.twitterSite)

    }, [JSON.stringify(data)])
}