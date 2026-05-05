<script setup>
const params = Object.fromEntries(new URLSearchParams(location.search))

navigator.sendBeacon('/api/v1/track', JSON.stringify({
    url:          location.pathname,
    utm_source:   params.utm_source,
    utm_medium:   params.utm_medium,
    utm_campaign: params.utm_campaign,
}))
</script>
