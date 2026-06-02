/**
 * glow-plugin.ts
 * Tailwind CSS v4 plugin — drop-shadow glow utilities
 *
 * Usage:
 *   glow-20        → sets spread size (replaces drama-20)
 *   glow-red-500   → sets color (replaces drama-red-500)
 *   border-glow-*  → glowing border + box-shadow
 *   text-glow-*    → glowing text-shadow
 */
/* @ts-ignore */
import type { PluginAPI } from "tailwindcss/types/config";

// In Tailwind v4 plugins are plain functions (no plugin.withOptions wrapper needed)
export default function tailwindGlowPlugin({ matchUtilities, theme }: PluginAPI) {
    // ─── Flatten color palette ──────────────────────────────────────────────────
    // flattenColorPalette is internal in v3; in v4 use CSS theme vars directly
    // or flatten manually. We use the standard approach that works in both.
    const colors = flatColors(theme("colors") as Record<string, unknown>);

    // ─── glow-<color>  (drop-shadow color + filter stack) ──────────────────────
    matchUtilities(
        {
            glow: (value: string) => ({
                "--tw-drop-shadow": `drop-shadow(0px 0px var(--glow-spread, 0.5rem) ${value})`,
                filter: [
                    "var(--tw-blur,)",
                    "var(--tw-brightness,)",
                    "var(--tw-contrast,)",
                    "var(--tw-grayscale,)",
                    "var(--tw-hue-rotate,)",
                    "var(--tw-invert,)",
                    "var(--tw-saturate,)",
                    "var(--tw-sepia,)",
                    "var(--tw-drop-shadow,)",
                ].join(" "),
            }),
        },
        { values: colors, type: "color" }
    );

    // ─── glow-<size>  (sets spread + derived blur via CSS custom property) ──────
    matchUtilities(
        {
            glow: (spread: string) => {
                const n = parseFloat(spread);
                const unit = spread.replace(/[\d.]/g, "") || "px";
                const inRem = unit === "rem" ? n : n / 16;

                let blurRem: number;
                if (inRem <= 0.25) blurRem = inRem * 15;
                else if (inRem <= 1) blurRem = inRem * 10;
                else blurRem = inRem * 7;

                return {
                    "--glow-spread": spread,
                    "--glow-blur": `${blurRem}rem`,
                };
            },
        },
        { values: theme("spacing") }
    );

    // ─── border-glow-<color> ────────────────────────────────────────────────────
    matchUtilities(
        {
            "border-glow": (value: string) => ({
                "border-color": value,
                "box-shadow": `inset 0 0 0.5em 0 ${value}, 0 0 0.5em 0 ${value}`,
            }),
        },
        { values: colors, type: "color" }
    );

    // ─── text-glow-<color> ──────────────────────────────────────────────────────
    matchUtilities(
        {
            "text-glow": (value: string) => ({
                "text-shadow": `0 0 0.125em ${value}, 0 0 0.45em ${value}`,
            }),
        },
        { values: colors, type: "color" }
    );
}

// ─── Helper: flatten nested color palette ──────────────────────────────────────
function flatColors(
    colors: Record<string, unknown>,
    prefix = ""
): Record<string, string> {
    const result: Record<string, string> = {};
    for (const [key, value] of Object.entries(colors)) {
        const name = prefix ? `${prefix}-${key}` : key;
        if (typeof value === "string") {
            result[name] = value;
        } else if (typeof value === "object" && value !== null) {
            Object.assign(result, flatColors(value as Record<string, unknown>, name));
        }
    }
    return result;
}
