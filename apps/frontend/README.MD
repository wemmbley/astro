<br>

<img src="branding.png" alt="branding">

# React Basic Infrastructure
> **"The frontend knows nothing about the backend."**  
> All architecture and infrastructure is built around this principle.

## Architecture

The project follows a progressive architecture roadmap: <br>

| Stage   | Approach | Status |
|---------|----------|--------|
| **now** | Clean "Layered" Architecture | current |
| next    | MVC Modules | next |
| future  | DDD Microfrontends | far future |

If you used our architecture, that's mean you are bored from feature-hooks-components style. <br>
Our architecture is progressive step for your future infrastructure.


## Prerequisites

| Tool | Version |
|------|---------|
| Node.js | v22+ |

## Getting Started

```bash
npm i
npm run dev
```

# Framework Docs

## Routing

The framework follows a **declarative, explicit routing** approach — every route is registered manually and maps directly to a Controller.

```tsx
<Routes>
    <Route path="/"      element={<IndexController />} />
    <Route path="/about" element={<AboutController />} />
    <Route path="*"      element={<NotFound />} />
</Routes>
```

Controllers are intentionally thin. Their only job is to configure the page (SEO, data) and delegate rendering to a View:

```tsx
export const IndexController = () => {
    useHead({ title: 'Main page' })
 
    return <Index />
}
```

Views live in `resources/views/` as `.tsx` files and know nothing about routing, data fetching, or SEO — pure presentation.

```
app/
  Controllers/      ← thin, hooks + useHead + render
  Models/           ← data fetching + validation
  Requests/         ← yup schemas
 
resources/
  views/
    Pages/          ← tsx views, pure presentation
```
 
---

## Head Tags — `useHead()`

Call `useHead()` inside any Controller. All fields are optional.

| Field | Meta tag | Notes |
|---|---|---|
| `title` | `<title>` | Also fallback for `og:title`, `twitter:title` |
| `description` | `<meta name="description">` | Also fallback for og/twitter description |
| `ogTitle` | `<meta property="og:title">` | Falls back to `title` |
| `ogDescription` | `<meta property="og:description">` | Falls back to `description` |
| `ogImage` | `<meta property="og:image">` | Full URL recommended |
| `ogUrl` | `<meta property="og:url">` | Canonical page URL |
| `ogType` | `<meta property="og:type">` | Default: `website` |
| `siteName` | `<meta property="og:site_name">` | |
| `twitterCard` | `<meta name="twitter:card">` | Default: `summary_large_image` |
| `twitterTitle` | `<meta name="twitter:title">` | Falls back to `ogTitle` → `title` |
| `twitterDescription` | `<meta name="twitter:description">` | Falls back to `ogDescription` → `description` |
| `twitterImage` | `<meta name="twitter:image">` | Falls back to `ogImage` |
| `twitterSite` | `<meta name="twitter:site">` | Your `@handle` |

**Example:**

```tsx
useHead({
    title: 'About — My Blog',
    description: 'Learn more about us',
    ogImage: 'https://example.com/og/about.jpg',
    ogUrl: 'https://example.com/about',
    siteName: 'My Blog',
    twitterSite: '@myblog',
})
```
 
---

## Data Fetching — `$fetch` + Yup

Data fetching is split into two layers: **Requests** (schema validation) and **Models** (fetch logic).

### Request — schema definition

```ts
// app/Requests/About.ts
import { object, string, InferType } from 'yup'
 
export const aboutSchema = object({
    title:   string().required(),
    content: string().required(),
})
```

### Model — fetch + validate

```ts
// app/Models/About.ts
import { $fetch } from '@/helpers/Utils/helpers'
import { aboutSchema } from '@/app/Requests/About'
 
export async function getAboutPage() {
    return await $fetch(
        'https://api.example.com/about',
        aboutSchema
    )
}
```

`$fetch` calls the endpoint and runs the response through the Yup schema. If validation fails — it throws. The Controller receives typed, validated data or nothing at all.

### Controller usage

```tsx
export const AboutController = () => {
    const [data, setData] = useState(null)
 
    useHead({ title: 'About' })
 
    useEffect(() => {
        getAboutPage().then(setData)
    }, [])
 
    return <About data={data} />
}
```

Views receive only validated, typed props — they never know where data comes from.

## License

MIT.