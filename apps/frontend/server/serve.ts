import express from 'express'
import { createServer as createViteServer } from 'vite'
import fs from 'fs'
import path from 'path'
import { fileURLToPath } from 'url'


const __dirname = path.dirname(fileURLToPath(import.meta.url))
const isProd = process.env.NODE_ENV === 'production'

async function bootstrap() {
    const app = express()

    let vite
    let template
    let render

    if (!isProd) {

        vite = await createViteServer({
            server: { middlewareMode: true },
            appType: 'custom'
        })

        app.use(vite.middlewares)

        app.use(/.*/, async (req, res) => {
            try {
                template = fs.readFileSync(
                    path.resolve(__dirname, '../public/index.html'), 'utf-8'
                )
                template = await vite.transformIndexHtml(req.originalUrl, template)

                const module = await vite.ssrLoadModule('/bootstrap/Server.jsx')
                render = module.render

                const { appHtml, headData, context } = render(req.originalUrl)

                if (context.notFound) {
                    const notFoundHtml = template
                        .replace('%ssr%', appHtml)
                        .replace('%metaTags%', buildMeta(headData))
                    return res.status(404).end(notFoundHtml)
                }

                if (context.url) {
                    return res.redirect(301, context.url)
                }

                const html = template
                    .replace('%ssr%', appHtml)
                    .replace('%metaTags%', buildMeta(headData))

                res.status(200)
                    .set({ 'Content-Type': 'text/html' })
                    .end(html)

            } catch (e) {
                vite.ssrFixStacktrace(e)
                console.error(e)
                res.status(500).end(e.message)
            }
        })

    } else {
        app.use(express.static(path.resolve(__dirname, 'dist/client')))

        template = fs.readFileSync(path.resolve(__dirname, 'dist/client/index.html'), 'utf-8')
        render = (await import('../bootstrap/Server')).render

        app.get(/.*/, (req, res) => {
            const appHtml = render(req.url)
            const html = template.replace('<!--ssr-outlet-->', appHtml)
            res.status(200).set({ 'Content-Type': 'text/html' }).end(html)
        })
    }

    app.listen(3000, () => {
        console.log(
            `SSR server: http://localhost:3000 [${isProd ? 'prod' : 'dev'}]`
        )
    })
}

const buildMeta = (headData: Record<string, string>) => {
    const t = (v?: string) => v ? escapeHtml(v) : ''

    const title = headData.title
        ? `<title>${t(headData.title)}</title>`
        : ''

    const meta = (name: string, content?: string, attr = 'name') =>
        content ? `<meta ${attr}="${name}" content="${t(content)}">` : ''

    return [
        title,
        meta('description', headData.description),

        // Open Graph
        meta('og:title',       headData.ogTitle ?? headData.title,                         'property'),
        meta('og:description', headData.ogDescription ?? headData.description,             'property'),
        meta('og:image',       headData.ogImage,                                           'property'),
        meta('og:url',         headData.ogUrl,                                             'property'),
        meta('og:type',        headData.ogType ?? 'website',                               'property'),
        meta('og:site_name',   headData.siteName,                                          'property'),

        // Twitter
        meta('twitter:card',        headData.twitterCard ?? 'summary_large_image'),
        meta('twitter:title',       headData.twitterTitle ?? headData.ogTitle ?? headData.title),
        meta('twitter:description', headData.twitterDescription ?? headData.ogDescription ?? headData.description),
        meta('twitter:image',       headData.twitterImage ?? headData.ogImage),
        meta('twitter:site',        headData.twitterSite),

    ].filter(Boolean).join('\n    ')
}

const escapeHtml = (str: string) =>
    str.replace(/&/g,'&amp;')
        .replace(/"/g,'&quot;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')

bootstrap()