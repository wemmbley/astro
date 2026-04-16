import { InferType, Schema, ValidationError } from "yup";

export async function $fetch<S extends Schema>(
    url: string,
    schema: S,
    options?: RequestInit
): Promise<InferType<S> | null> {
    let response: Response;

    try {
        response = await fetch(url, options);
    } catch (err) {
        console.error(`[$fetch] Network error → ${url}`, err);
        return null;
    }

    if (!response.ok) {
        console.error(`[$fetch] HTTP ${response.status} ${response.statusText} → ${url}`);
        return null;
    }

    let data: unknown;
    try {
        data = await response.json();
    } catch (err) {
        console.error(`[$fetch] Can't parse JSON → ${url}`, err);
        return null;
    }

    try {
        const validated = await schema.validate(data, {
            abortEarly: false,
            stripUnknown: true
        });
    } catch (err) {
        if (err instanceof ValidationError) {
            console.error(
                `[$fetch] Validation error → ${url}\n` +
                err.errors.map(e => `  • ${e}`).join("\n")
            );
            console.warn('Server output');
            console.warn(data);
        } else {
            console.error(`[$fetch] Unknown validation error → ${url}`, err);
        }

        return null;
    }
}