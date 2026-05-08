type TrackEvent = 'pageview' | 'click' | 'submit' | string

type TrackPayload = {
    event?: TrackEvent
    ts?: number

    visitor_id?: string
    session_id?: string

    url?: string
    title?: string
    referrer?: string | null

    utm_source?: string | null
    utm_medium?: string | null
    utm_campaign?: string | null
    utm_content?: string | null
    utm_term?: string | null

    lang?: string
    timezone?: string
    platform?: string

    screen?: {
        w: number
        h: number
        dpr: number
    }

    viewport?: {
        w: number
        h: number
    }

    network?: {
        type: string | null
        saveData: boolean | null
    }

    [key: string]: unknown
}

type NavigatorConnection = {
    effectiveType?: string
    saveData?: boolean
}

type NavigatorWithConnection = Navigator & {
    connection?: NavigatorConnection
    userAgentData?: {
        platform?: string
    }
}

function getId(key: 'visitor_id' | 'session_id'): string {
    const storage: Storage =
        key === 'visitor_id'
            ? localStorage
            : sessionStorage

    let id = storage.getItem(key)

    if (!id) {
        id = crypto.randomUUID()
        storage.setItem(key, id)
    }

    return id
}

export function track(
    event: TrackEvent = 'pageview',
    extra: Partial<TrackPayload> = {}
): void {
    const nav = navigator as NavigatorWithConnection

    const params = Object.fromEntries(
        new URLSearchParams(location.search)
    )

    const payload: TrackPayload = {
        event,
        ts: Date.now(),

        visitor_id: getId('visitor_id'),
        session_id: getId('session_id'),

        url: location.pathname,
        title: document.title,
        referrer: document.referrer || null,

        utm_source: params.utm_source || null,
        utm_medium: params.utm_medium || null,
        utm_campaign: params.utm_campaign || null,
        utm_content: params.utm_content || null,
        utm_term: params.utm_term || null,

        lang: navigator.language,

        timezone: Intl.DateTimeFormat()
            .resolvedOptions()
            .timeZone,

        platform:
            nav.userAgentData?.platform ??
            navigator.platform,

        screen: {
            w: screen.width,
            h: screen.height,
            dpr: window.devicePixelRatio,
        },

        viewport: {
            w: window.innerWidth,
            h: window.innerHeight,
        },

        network: {
            type: nav.connection?.effectiveType ?? null,
            saveData: nav.connection?.saveData ?? null,
        },

        ...extra,
    }

    const blob = new Blob(
        [JSON.stringify(payload)],
        {
            type: 'application/json',
        }
    )

    const success = navigator.sendBeacon(
        '/api/v1/track',
        blob
    )

    if (!success) {
        fetch('/api/v1/track', {
            method: 'POST',
            body: blob,
            keepalive: true,
        }).catch(() => {})
    }
}
