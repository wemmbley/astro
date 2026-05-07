function getId(key) {
    const storage = key === 'visitor_id' ? localStorage : sessionStorage
    let id = storage.getItem(key)
    if (!id) {
        id = crypto.randomUUID()
        storage.setItem(key, id)
    }
    return id
}

export function track(event = 'pageview', extra = {}) {
    const params = Object.fromEntries(new URLSearchParams(location.search))

    const payload = {
        event,
        ts: Date.now(),

        // идентификация
        visitor_id: getId('visitor_id'),
        session_id: getId('session_id'),

        // страница
        url: location.pathname,
        title: document.title,
        referrer: document.referrer || null,

        // UTM
        utm_source:   params.utm_source   || null,
        utm_medium:   params.utm_medium   || null,
        utm_campaign: params.utm_campaign || null,
        utm_content:  params.utm_content  || null,
        utm_term:     params.utm_term     || null,

        // окружение
        lang:     navigator.language,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        platform: navigator.userAgentData?.platform ?? navigator.platform,

        screen: {
            w:   screen.width,
            h:   screen.height,
            dpr: window.devicePixelRatio,
        },
        viewport: {
            w: window.innerWidth,
            h: window.innerHeight,
        },

        network: {
            type:     navigator.connection?.effectiveType ?? null,
            saveData: navigator.connection?.saveData ?? null,
        },

        ...extra,
    }

    const blob = new Blob([JSON.stringify(payload)], { type: 'application/json' })

    if (!navigator.sendBeacon('/api/v1/track', blob)) {
        // fallback если beacon не пролез (редко, но бывает при блокировщиках)
        fetch('/api/v1/track', { method: 'POST', body: blob, keepalive: true })
    }
}
