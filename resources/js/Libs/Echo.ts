import Echo from 'laravel-echo'

let echo = null

export function getEcho() {
    if (!echo) {
        echo = new Echo({
            broadcaster: 'reverb',
            wsHost: window.location.hostname,
            wsPort: 8080,
            forceTLS: false,
        })
    }

    return echo
}
