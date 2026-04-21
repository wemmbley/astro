import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { fileURLToPath, URL } from "url";

export default defineConfig(({ mode }) => {
    const isSSR = mode === 'ssr'

    return {
        publicDir: isSSR ? false : 'public',
        plugins: [react()],
        resolve: {
            alias: {
                "@": fileURLToPath(new URL(".", import.meta.url)),
            },
        },
        build: {
            rollupOptions: {
                input: isSSR
                    ? undefined
                    : {
                        app: 'index.html',
                        client: 'bootstrap/Client.tsx'
                    },
                output: isSSR
                    ? { format: 'es', entryFileNames: '[name].js' }
                    : undefined,
            },
        },
        server: {
            host: true,
            allowedHosts: ["localhost", "frontend"],
            open: './public/index.html',
        },
        ssr: {
            noExternal: ['primereact']
        }
    }
})