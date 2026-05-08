"""
chart_svg.py — SVG Natal Chart Renderer
========================================
Generates a complete SVG natal wheel: zodiac ring, degree ticks,
house cusps, aspect lines, planet symbols.

SETUP
-----
1. Optionally place SVG icons:
       icons/planets/Sun.svg, Moon.svg, Mercury.svg ...
       icons/signs/Aries.svg, Taurus.svg ...
   Falls back to Unicode glyphs if icons are missing.

USAGE
-----
    from astro_core import calculate_chart
    from chart_svg import render_chart
    import datetime

    chart = calculate_chart(
        datetime.datetime(1990, 6, 15, 14, 30),
        lat=50.45, lon=30.52
    )
    render_chart(chart, output_path="natal.svg")
"""

import math
import re
from pathlib import Path
from typing import Optional

# ══════════════════════════════════════════════════════════════════════════════
#  Layout — all radii relative to SIZE
# ══════════════════════════════════════════════════════════════════════════════

SIZE = 900
CX = CY = SIZE / 2

# Outer → inner
R_RIM         = 444   # decorative outer rim stroke
R_ZODIAC_OUT  = 434   # outer edge of zodiac sign band
R_ZODIAC_IN   = 390   # inner edge of zodiac band / outer of tick band
R_TICK_OUT    = 390
R_TICK_MED    = 381   # 10° tick inner
R_TICK_5      = 376   # 5° tick inner
R_TICK_1      = 373   # 1° tick inner
R_TICK_IN     = 365   # inner of tick band / outer of house band

R_HOUSE_OUT   = 365
R_HOUSE_IN    = 308   # inner edge of house band

R_PLANET_HI   = 300   # pushed-out cluster position
R_PLANET      = 280   # standard planet position
R_PLANET_LO   = 260   # pushed-in cluster position

R_INNER       = 250   # inner circle / aspect endpoint
R_CENTER      = 54    # decorative inner knot

PLANET_ICON_R = 13    # half-size of planet icon/glyph
SIGN_ICON_R   = 15    # half-size of sign icon/glyph

ICONS_PATH = Path(__file__).parent / "icons"

# ══════════════════════════════════════════════════════════════════════════════
#  Theme
# ══════════════════════════════════════════════════════════════════════════════

T = {
    "bg":         "#030712",
    "bg2":        "#0a0a1e",
    "rim":        "#1c1c38",
    "grid":       "#374151",
    "grid2":      "#4b5567",
    "cusp_angle": "#4b5567",   # ASC / DSC lines
    "cusp_mc":    "#8ab0d8",   # MC / IC lines
    "cusp_house": "#222240",
    "asc_label":  "#e8c060",
    "mc_label":   "#90b8e0",
    "text":       "#dadfea",
    "text_dim":   "#8d97aa",
    "tick_hi":    "#b8c0cf",
    "tick_lo":    "#6a7589",
}

ELEMENT_BG = {
    "Aries":       "#180606", "Leo":         "#180606", "Sagittarius": "#180606",
    "Taurus":      "#121212", "Virgo":       "#121212", "Capricorn":   "#121212",
    "Gemini":      "#000F00", "Libra":       "#000F00", "Aquarius":    "#000F00",
    "Cancer":      "#060c18", "Scorpio":     "#060c18", "Pisces":      "#060c18",
}
ELEMENT_STROKE = {
    "Aries":       "#a83020", "Leo":         "#a83020", "Sagittarius": "#a83020",
    "Taurus":      "#828282", "Virgo":       "#828282", "Capricorn":   "#828282",
    "Gemini":      "#009C00", "Libra":       "#009C00", "Aquarius":    "#009C00",
    "Cancer":      "#1860a8", "Scorpio":     "#1860a8", "Pisces":      "#1860a8",
}
ELEMENT_TEXT = {
    "Aries":       "#e06050", "Leo":         "#e06050", "Sagittarius": "#e06050",
    "Taurus":      "#50d080", "Virgo":       "#50d080", "Capricorn":   "#50d080",
    "Gemini":      "#e0c040", "Libra":       "#e0c040", "Aquarius":    "#e0c040",
    "Cancer":      "#50a0e0", "Scorpio":     "#50a0e0", "Pisces":      "#50a0e0",
}

PLANET_COLOR = {
    "Sun":       "#f5c842", "Moon":      "#bcc8e8", "Mercury":   "#7ad080",
    "Venus":     "#e080b8", "Mars":      "#e04848", "Jupiter":   "#9870e0",
    "Saturn":    "#c0a050", "Uranus":    "#58c8c8", "Neptune":   "#5878e0",
    "Pluto":     "#c05878", "Chiron":    "#78a898", "Lilith":    "#a85880",
    "TrueLilith":"#a85880", "NorthNode": "#f0d070", "SouthNode": "#c0a858",
    "MeanNode":  "#f0d070", "TrueNode":  "#f0d070", "Fortune":   "#f0e090",
}

ASPECT_STYLE = {
    "Conjunction":    {"c": "#f0c040", "w": 1.8, "d": "",          "o": 0.90},
    "Opposition":     {"c": "#e04848", "w": 1.8, "d": "",          "o": 0.90},
    "Square":         {"c": "#e04848", "w": 1.3, "d": "",          "o": 0.80},
    "Trine":          {"c": "#3878e0", "w": 1.8, "d": "",          "o": 0.88},
    "Sextile":        {"c": "#38b878", "w": 1.3, "d": "6,3",       "o": 0.80},
    "Semisextile":    {"c": "#707080", "w": 0.8, "d": "3,4",       "o": 0.55},
    "Quincunx":       {"c": "#8850c0", "w": 0.8, "d": "5,3",       "o": 0.55},
    "Semisquare":     {"c": "#d07828", "w": 0.8, "d": "3,3",       "o": 0.55},
    "Sesquiquadrate": {"c": "#d07828", "w": 0.8, "d": "3,3",       "o": 0.55},
    "Quintile":       {"c": "#28b8b8", "w": 0.8, "d": "6,2,2,2",  "o": 0.55},
    "Biquintile":     {"c": "#28b8b8", "w": 0.8, "d": "6,2,2,2",  "o": 0.55},
}

ZODIAC_SIGNS = [
    "Aries","Taurus","Gemini","Cancer","Leo","Virgo",
    "Libra","Scorpio","Sagittarius","Capricorn","Aquarius","Pisces",
]
ZODIAC_GLYPHS = {
    "Aries":"♈","Taurus":"♉","Gemini":"♊","Cancer":"♋",
    "Leo":"♌","Virgo":"♍","Libra":"♎","Scorpio":"♏",
    "Sagittarius":"♐","Capricorn":"♑","Aquarius":"♒","Pisces":"♓",
}
PLANET_GLYPHS = {
    "Sun":"☉","Moon":"☽","Mercury":"☿","Venus":"♀","Mars":"♂",
    "Jupiter":"♃","Saturn":"♄","Uranus":"♅","Neptune":"♆","Pluto":"♇",
    "Chiron":"⚷","Lilith":"⚸","TrueLilith":"⚸","NorthNode":"☊",
    "SouthNode":"☋","Fortune":"⊕","MeanNode":"☊","TrueNode":"☊",
}
# Declination aspects — cannot be drawn on the wheel, skip
_SKIP_ASPECTS = {"Parallel", "Contraparallel"}


# ══════════════════════════════════════════════════════════════════════════════
#  Icon loader
# ══════════════════════════════════════════════════════════════════════════════

def _load_svg_symbols() -> tuple[str, set[str]]:
    """
    Scan icons/planets/*.svg and icons/signs/*.svg.
    Returns a <defs> fragment string and a set of available symbol IDs.
    IDs: "planet-Sun", "planet-Moon" ... "sign-Aries" ...
    """
    parts: list[str] = []
    available: set[str] = set()

    for subdir, names in [
        ("planets", list(PLANET_GLYPHS.keys())),
        ("signs",   ZODIAC_SIGNS),
    ]:
        folder = ICONS_PATH / subdir
        if not folder.is_dir():
            continue
        prefix = "planet" if subdir == "planets" else "sign"
        for name in names:
            path = folder / f"{name}.svg"
            if not path.exists():
                continue
            try:
                raw = path.read_text(encoding="utf-8")
                vb  = re.search(r'viewBox=["\']([^"\']+)["\']', raw)
                viewbox = vb.group(1) if vb else "0 0 24 24"
                inner = re.sub(r'(?s)<svg[^>]*>', '', raw, count=1)
                inner = re.sub(r'</svg>', '', inner).strip()
                sym_id = f"{prefix}-{name}"
                parts.append(
                    f'  <symbol id="{sym_id}" viewBox="{viewbox}" '
                    f'overflow="visible">{inner}</symbol>'
                )
                available.add(sym_id)
            except Exception:
                pass

    return "\n".join(parts), available


# ══════════════════════════════════════════════════════════════════════════════
#  Geometry helpers
# ══════════════════════════════════════════════════════════════════════════════

def _to_svg_angle(lon: float, asc_lon: float) -> float:
    """
    Ecliptic longitude → SVG display angle (degrees, 0=right, clockwise).
    ASC always lands at 180° (9 o'clock / left side).
    """
    return (asc_lon - lon + 180.0) % 360.0


def _polar(r: float, angle_deg: float) -> tuple[float, float]:
    a = math.radians(angle_deg)
    return CX + r * math.cos(a), CY + r * math.sin(a)


def _arc(r_out: float, r_in: float, a1: float, a2: float) -> str:
    """
    SVG path for a donut arc from SVG angle a1 to a2 (degrees CW).
    Handles wrap-around; a1 is the start and a2 the end going clockwise.
    """
    span = (a2 - a1) % 360
    if span < 0.001:
        span = 360
    large = 1 if span > 180 else 0

    a1r = math.radians(a1)
    a2r = math.radians(a2)

    ox1 = CX + r_out * math.cos(a1r);  oy1 = CY + r_out * math.sin(a1r)
    ox2 = CX + r_out * math.cos(a2r);  oy2 = CY + r_out * math.sin(a2r)
    ix1 = CX + r_in  * math.cos(a2r);  iy1 = CY + r_in  * math.sin(a2r)
    ix2 = CX + r_in  * math.cos(a1r);  iy2 = CY + r_in  * math.sin(a1r)

    return (
        f"M {ox1:.2f},{oy1:.2f} "
        f"A {r_out:.1f},{r_out:.1f} 0 {large},1 {ox2:.2f},{oy2:.2f} "
        f"L {ix1:.2f},{iy1:.2f} "
        f"A {r_in:.1f},{r_in:.1f} 0 {large},0 {ix2:.2f},{iy2:.2f} Z"
    )


def _circle(r: float, fill: str = "none",
            stroke: Optional[str] = None, sw: float = 1.0,
            opacity: float = 1.0) -> str:
    s   = f' stroke="{stroke}" stroke-width="{sw}"' if stroke else ""
    op  = f' opacity="{opacity}"' if opacity < 1.0 else ""
    return f'<circle cx="{CX}" cy="{CY}" r="{r:.1f}" fill="{fill}"{s}{op}/>'


def _place_icon(sym_id: str, x: float, y: float, r: float,
                available: set[str], color: str, fallback: str) -> str:
    """Place an icon (SVG symbol) or a Unicode glyph fallback."""
    if sym_id in available:
        return (
            f'<use href="#{sym_id}" '
            f'x="{x - r:.1f}" y="{y - r:.1f}" '
            f'width="{r*2:.0f}" height="{r*2:.0f}"/>'
        )
    return (
        f'<text x="{x:.1f}" y="{y:.1f}" '
        f'text-anchor="middle" dominant-baseline="central" '
        f'fill="{color}" font-size="{int(r * 1.5)}" '
        f'font-family="serif,symbola,unifont">{fallback}</text>'
    )


# ══════════════════════════════════════════════════════════════════════════════
#  Longitude reconstruction from chart data
# ══════════════════════════════════════════════════════════════════════════════

def _build_lons(planets_data: dict) -> dict[str, float]:
    """Reconstruct ecliptic longitudes from planet sign+degree data."""
    lons: dict[str, float] = {}
    for name, pdata in planets_data.items():
        if "longitude" in pdata:
            lons[name] = pdata["longitude"]
        else:
            sign  = pdata["sign"]["name"]
            deg   = pdata["sign"]["degree"]
            idx   = ZODIAC_SIGNS.index(sign) if sign in ZODIAC_SIGNS else 0
            lons[name] = idx * 30.0 + deg
    return lons


# ══════════════════════════════════════════════════════════════════════════════
#  Planet de-overlap
# ══════════════════════════════════════════════════════════════════════════════

_OVERLAP_THRESH = 9.0   # degrees — cluster threshold
_RING_OPTIONS   = [R_PLANET_HI, R_PLANET, R_PLANET_LO, R_PLANET_HI - 12]


def _deoverlap(planet_angles: dict[str, float]) -> dict[str, float]:
    """
    Assign display radii so clustered planets alternate between
    R_PLANET_HI / R_PLANET / R_PLANET_LO instead of stacking.
    """
    radii = {n: R_PLANET for n in planet_angles}
    if len(planet_angles) < 2:
        return radii

    items = sorted(planet_angles.items(), key=lambda x: x[1])
    cluster: list[str] = [items[0][0]]
    clusters: list[list[str]] = []

    for i in range(1, len(items)):
        prev_a = items[i - 1][1]
        curr_a = items[i][1]
        diff = min((curr_a - prev_a) % 360, (prev_a - curr_a) % 360)
        if diff < _OVERLAP_THRESH:
            cluster.append(items[i][0])
        else:
            clusters.append(cluster)
            cluster = [items[i][0]]
    clusters.append(cluster)

    # Also check wrap-around: last and first cluster
    if len(clusters) > 1:
        last_a  = planet_angles[clusters[-1][-1]]
        first_a = planet_angles[clusters[0][0]]
        diff    = min((first_a - last_a) % 360, (last_a - first_a) % 360)
        if diff < _OVERLAP_THRESH:
            clusters[0] = clusters[-1] + clusters[0]
            clusters.pop()

    for cl in clusters:
        for j, name in enumerate(cl):
            radii[name] = _RING_OPTIONS[j % len(_RING_OPTIONS)]

    return radii


# ══════════════════════════════════════════════════════════════════════════════
#  Section renderers
# ══════════════════════════════════════════════════════════════════════════════

def _render_background() -> list[str]:
    out = [
        f'<rect width="{SIZE}" height="{SIZE}" fill="{T["bg"]}"/>',
        # subtle gradient overlay
        '<defs><radialGradient id="bg-grad" cx="50%" cy="50%" r="50%">'
        f'<stop offset="0%" stop-color="{T["bg2"]}" stop-opacity="0"/>'
        f'<stop offset="100%" stop-color="{T["bg"]}" stop-opacity="1"/>'
        '</radialGradient></defs>',
        f'<circle cx="{CX}" cy="{CY}" r="{R_RIM + 6}" fill="url(#bg-grad)"/>',
        # rings
        _circle(R_RIM,        stroke=T["rim"],   sw=1.5),
        _circle(R_ZODIAC_OUT, stroke=T["grid"],  sw=0.8),
        _circle(R_ZODIAC_IN,  stroke=T["grid"],  sw=0.8),
        _circle(R_TICK_IN,    stroke=T["grid2"], sw=0.5),
        _circle(R_HOUSE_OUT,  stroke=T["grid2"], sw=0.5),
        _circle(R_HOUSE_IN,   stroke=T["rim"],   sw=1.0),
        _circle(R_INNER,      stroke=T["grid"],  sw=1.2),
        _circle(R_CENTER,     fill=T["bg2"], stroke=T["rim"], sw=1.2),
    ]
    return out


def _render_zodiac_ring(asc_lon: float, available: set[str]) -> list[str]:
    out = []
    for i, sign in enumerate(ZODIAC_SIGNS):
        lon_start = i * 30.0
        lon_end   = lon_start + 30.0

        # Arc angles — ecliptic goes CCW, SVG goes CW, hence swap
        a1 = _to_svg_angle(lon_end,   asc_lon)
        a2 = _to_svg_angle(lon_start, asc_lon)

        # Coloured sector
        path = _arc(R_ZODIAC_OUT, R_ZODIAC_IN, a1, a2)
        es   = ELEMENT_STROKE[sign]
        out.append(
            f'<path d="{path}" fill="{ELEMENT_BG[sign]}" '
            f'stroke="{es}" stroke-width="0.6" opacity="0.95"/>'
        )

        # Sign boundary spoke
        a_b = _to_svg_angle(lon_start, asc_lon)
        x1, y1 = _polar(R_ZODIAC_OUT, a_b)
        x2, y2 = _polar(R_ZODIAC_IN,  a_b)
        out.append(
            f'<line x1="{x1:.1f}" y1="{y1:.1f}" x2="{x2:.1f}" y2="{y2:.1f}" '
            f'stroke="{es}" stroke-width="1.2"/>'
        )

        # Sign glyph / icon at mid-sign
        mid_a  = _to_svg_angle(lon_start + 15.0, asc_lon)
        r_mid  = (R_ZODIAC_OUT + R_ZODIAC_IN) / 2
        sx, sy = _polar(r_mid, mid_a)
        out.append(_place_icon(
            f"sign-{sign}", sx, sy, SIGN_ICON_R,
            available, ELEMENT_TEXT[sign], ZODIAC_GLYPHS[sign]
        ))

    return out


def _render_degree_ticks(asc_lon: float) -> list[str]:
    out = []
    for deg in range(360):
        if deg % 30 == 0:
            continue  # sign boundary — already drawn
        svg_a = _to_svg_angle(float(deg), asc_lon)
        if deg % 10 == 0:
            r_in, sw, col = R_TICK_MED, 1.3, T["tick_hi"]
        elif deg % 5 == 0:
            r_in, sw, col = R_TICK_5,   0.9, T["tick_hi"]
        else:
            r_in, sw, col = R_TICK_1,   0.5, T["tick_lo"]
        x1, y1 = _polar(R_TICK_OUT, svg_a)
        x2, y2 = _polar(r_in,       svg_a)
        out.append(
            f'<line x1="{x1:.1f}" y1="{y1:.1f}" '
            f'x2="{x2:.1f}" y2="{y2:.1f}" '
            f'stroke="{col}" stroke-width="{sw}"/>'
        )
    return out


def _render_house_ring(houses_data: dict, asc_lon: float) -> list[str]:
    out = []
    cusps: dict[int, float] = {
        int(k.replace("House", "")): v["cusp_longitude"]
        for k, v in houses_data.items()
    }

    for house_num in range(1, 13):
        lon = cusps[house_num]
        svg_a = _to_svg_angle(lon, asc_lon)

        is_axis = house_num in (1, 4, 7, 10)
        sw    = 2.0 if is_axis else 1.0
        color = (
            T["cusp_angle"] if house_num in (1, 7)  else
            T["cusp_mc"]    if house_num in (4, 10) else
            T["cusp_house"]
        )
        r_end = R_CENTER if is_axis else R_INNER

        x1, y1 = _polar(R_HOUSE_OUT, svg_a)
        x2, y2 = _polar(r_end,       svg_a)
        dash = '' if is_axis else ' stroke-dasharray="4,3"'
        out.append(
            f'<line x1="{x1:.1f}" y1="{y1:.1f}" x2="{x2:.1f}" y2="{y2:.1f}" '
            f'stroke="{color}" stroke-width="{sw}"{dash} opacity="0.85"/>'
        )

        # House number at mid-span
        next_lon  = cusps[(house_num % 12) + 1]
        span      = (next_lon - lon) % 360
        mid_lon   = (lon + span / 2) % 360
        mid_a     = _to_svg_angle(mid_lon, asc_lon)
        r_label   = (R_HOUSE_OUT + R_HOUSE_IN) / 2
        lx, ly    = _polar(r_label, mid_a)
        out.append(
            f'<text x="{lx:.1f}" y="{ly:.1f}" text-anchor="middle" '
            f'dominant-baseline="central" fill="{T["text_dim"]}" '
            f'font-size="12" font-family="sans-serif">{house_num}</text>'
        )

    return out


def _render_aspect_lines(planets_data: dict, lons: dict[str, float],
                          asc_lon: float) -> list[str]:
    out = []
    seen: set[frozenset] = set()

    for p_name, pdata in planets_data.items():
        if p_name not in lons:
            continue
        for asp in pdata.get("aspects", []):
            target   = asp["target"]
            asp_type = asp["type"]
            if target not in lons or asp_type in _SKIP_ASPECTS:
                continue
            pair = frozenset({p_name, target})
            if pair in seen:
                continue
            seen.add(pair)

            style = ASPECT_STYLE.get(asp_type)
            if not style:
                continue

            a1 = _to_svg_angle(lons[p_name], asc_lon)
            a2 = _to_svg_angle(lons[target], asc_lon)
            x1, y1 = _polar(R_INNER, a1)
            x2, y2 = _polar(R_INNER, a2)

            dash = f' stroke-dasharray="{style["d"]}"' if style["d"] else ""
            out.append(
                f'<line x1="{x1:.1f}" y1="{y1:.1f}" '
                f'x2="{x2:.1f}" y2="{y2:.1f}" '
                f'stroke="{style["c"]}" stroke-width="{style["w"]}" '
                f'opacity="{style["o"]}"{dash}/>'
            )
    return out


def _render_planets(planets_data: dict, lons: dict[str, float],
                     asc_lon: float, available: set[str]) -> list[str]:
    out = []

    # Display angles for all planets present
    p_angles = {
        n: _to_svg_angle(lon, asc_lon)
        for n, lon in lons.items()
        if n in planets_data
    }
    radii = _deoverlap(p_angles)

    for name in lons:
        if name not in planets_data:
            continue
        pdata  = planets_data[name]
        svg_a  = p_angles[name]
        r      = radii.get(name, R_PLANET)
        x, y   = _polar(r, svg_a)
        color  = PLANET_COLOR.get(name, "#b0b0d0")
        glyph  = PLANET_GLYPHS.get(name, "?")
        retro  = pdata.get("retrograde", False)

        # Anchor dot on inner ring
        dx, dy = _polar(R_INNER, svg_a)
        out.append(
            f'<circle cx="{dx:.1f}" cy="{dy:.1f}" r="2.8" '
            f'fill="{color}" opacity="0.75"/>'
        )

        # Connector from inner ring to planet body (only if not at default radius)
        if abs(r - R_INNER) > 5:
            out.append(
                f'<line x1="{dx:.1f}" y1="{dy:.1f}" x2="{x:.1f}" y2="{y:.1f}" '
                f'stroke="{color}" stroke-width="0.7" opacity="0.35" '
                f'stroke-dasharray="2,2"/>'
            )

        # Planet icon or glyph
        out.append(_place_icon(
            f"planet-{name}", x, y, PLANET_ICON_R,
            available, color, glyph
        ))

        # Retrograde ℞
        if retro:
            rx, ry = _polar(r + PLANET_ICON_R + 9, svg_a)
            out.append(
                f'<text x="{rx:.1f}" y="{ry:.1f}" '
                f'text-anchor="middle" dominant-baseline="central" '
                f'fill="{color}" font-size="14" font-family="sans-serif" '
                f'opacity="0.85">℞</text>'
            )

        # Degree label
        fmt = pdata["sign"].get("formatted", "")
        if fmt:
            lx, ly = _polar(r + PLANET_ICON_R + 18, svg_a)
            out.append(
                f'<text x="{lx:.1f}" y="{ly:.1f}" '
                f'text-anchor="middle" dominant-baseline="central" '
                f'fill="{T["text_dim"]}" font-size="9.5" '
                f'font-family="monospace,courier">{fmt}</text>'
            )

    return out


def _render_angle_labels(asc_lon: float, mc_lon: float) -> list[str]:
    """ASC / DSC / MC / IC labels just inside the house ring outer edge."""
    out = []
    dsc_lon = (asc_lon + 180) % 360
    ic_lon  = (mc_lon  + 180) % 360

    r_label = R_TICK_IN - 16

    for label, lon, color in [
        ("ASC", asc_lon,  T["asc_label"]),
        ("DSC", dsc_lon,  T["asc_label"]),
        ("MC",  mc_lon,   T["mc_label"]),
        ("IC",  ic_lon,   T["mc_label"]),
    ]:
        svg_a = _to_svg_angle(lon, asc_lon)
        lx, ly = _polar(r_label, svg_a)
        out.append(
            f'<text x="{lx:.1f}" y="{ly:.1f}" '
            f'text-anchor="middle" dominant-baseline="central" '
            f'fill="{color}" font-size="11.5" '
            f'font-family="sans-serif" font-weight="700" '
            f'letter-spacing="0.5">{label}</text>'
        )
    return out


def _render_legend(asc_lon: float, mc_lon: float,
                   chart_data: dict) -> list[str]:
    """Small text block bottom-right: birth data summary."""
    out = []
    # ASC sign
    asc_sign_idx = int(asc_lon // 30) % 12
    asc_sign     = ZODIAC_SIGNS[asc_sign_idx]
    asc_deg      = asc_lon % 30

    mc_sign_idx  = int(mc_lon // 30) % 12
    mc_sign      = ZODIAC_SIGNS[mc_sign_idx]
    mc_deg       = mc_lon % 30

    margin = 12
    bx     = SIZE - margin
    lines  = [
        (f"ASC  {int(asc_deg):02d}° {ZODIAC_GLYPHS.get(asc_sign, asc_sign)}", T["asc_label"]),
        (f"MC   {int(mc_deg):02d}° {ZODIAC_GLYPHS.get(mc_sign,  mc_sign)}",  T["mc_label"]),
    ]
    for i, (text, color) in enumerate(lines):
        y = SIZE - margin - (len(lines) - 1 - i) * 16
        out.append(
            f'<text x="{bx}" y="{y}" text-anchor="end" '
            f'fill="{color}" font-size="11" '
            f'font-family="monospace,courier" opacity="0.75">{text}</text>'
        )
    return out


# ══════════════════════════════════════════════════════════════════════════════
#  Main entry point
# ══════════════════════════════════════════════════════════════════════════════

def render_chart(chart_data: dict,
                 output_path: Optional[str] = None) -> str:
    """
    Render a natal chart SVG from calculate_chart() output.

    Required keys in chart_data:
        "planets"  — planets dict
        "houses"   — houses dict
        "asc"      — float, ASC ecliptic longitude (degrees)
        "mc"       — float, MC ecliptic longitude (degrees)

    Returns SVG as a string. Writes to output_path if given.
    """
    asc_lon = float(chart_data["asc"])
    mc_lon  = float(chart_data["mc"])
    planets = chart_data["planets"]
    houses  = chart_data["houses"]

    lons = _build_lons(planets)

    # Load custom icons (if any)
    icon_defs, available = _load_svg_symbols()
    if available:
        print(f"[chart_svg] Loaded {len(available)} custom icons: {sorted(available)[:5]} …")
    else:
        print("[chart_svg] No custom icons found — using Unicode glyphs")

    # ── Assemble SVG ─────────────────────────────────────────────────────────
    parts: list[str] = [
        f'<svg xmlns="http://www.w3.org/2000/svg" '
        f'viewBox="0 0 {SIZE} {SIZE}" '
        f'width="{SIZE}" height="{SIZE}">',

        # Defs: bg gradient + user icon symbols
        f'<defs>\n{icon_defs}\n</defs>',
    ]

    # Draw order: background → zodiac → ticks → house ring →
    #             aspect lines (deepest layer) → planets → labels
    parts += _render_background()
    parts += _render_zodiac_ring(asc_lon, available)
    parts += _render_degree_ticks(asc_lon)
    parts += _render_house_ring(houses, asc_lon)
    parts += _render_aspect_lines(planets, lons, asc_lon)
    parts += _render_planets(planets, lons, asc_lon, available)
    parts += _render_angle_labels(asc_lon, mc_lon)
    parts += _render_legend(asc_lon, mc_lon, chart_data)

    parts.append("</svg>")

    svg = "\n".join(parts)

    if output_path:
        Path(output_path).write_text(svg, encoding="utf-8")
        print(f"[chart_svg] Written → {output_path}")

    return svg


# ══════════════════════════════════════════════════════════════════════════════
#  CLI convenience
# ══════════════════════════════════════════════════════════════════════════════

if __name__ == "__main__":
    """
    Quick smoke-test. Adjust birth data and run:
        python chart_svg.py
    Requires ephemeris.py with "asc"/"mc" in its return dict.
    """
    import sys
    import datetime

    # Insert project root so imports work when run directly
    sys.path.insert(0, str(Path(__file__).parent))

    try:
        from ephemeris import calculate_chart
    except ImportError:
        print("ERROR: Could not import calculate_chart from ephemeris.py")
        sys.exit(1)

    birth = datetime.datetime(1990, 6, 15, 14, 30)
    lat, lon = 50.45, 30.52   # Kyiv

    chart = calculate_chart(birth, lat, lon)

    if "asc" not in chart:
        print(
            "ERROR: calculate_chart() does not return 'asc'/'mc'.\n"
            "Add these lines to the return dict in ephemeris.py:\n"
            '    "asc": round(ascmc[0], 4),\n'
            '    "mc":  round(ascmc[1], 4),'
        )
        sys.exit(1)

    render_chart(chart, output_path="natal.svg")
    print("Done! Open natal.svg in a browser.")
