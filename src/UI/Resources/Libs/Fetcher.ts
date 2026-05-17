const API_URL = import.meta.env.VITE_API_URL

export async function api<T>(
    url: string,
    options: RequestInit = {}
): Promise<T> {
    const response = await fetch(`${API_URL}${url}`, {
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
        },
        credentials: 'include',
        ...options,
    })

    if (!response.ok) {
        throw await response.json()
    }

    return response.json()
}
