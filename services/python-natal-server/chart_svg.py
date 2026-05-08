"""
chart_svg.py — SVG Natal Chart Renderer  v2
============================================

PATCH для ephemeris.py — добавь в return calculate_chart():
    "asc": round(ascmc[0], 4),
    "mc":  round(ascmc[1], 4),

ИКОНКИ (опционально):
    icons/planets/Sun.svg, Moon.svg, ...
    icons/signs/Aries.svg, Taurus.svg, ...

ИСПОЛЬЗОВАНИЕ:
    from chart_svg import render_chart, configure_aspect

    configure_aspect("Trine",      color="#00ff88", width=2.5)
    configure_aspect("Opposition", dash="4,4",      opacity=0.6)

    chart = calculate_chart(birth_dt, lat, lon)
    svg   = render_chart(chart)                   # строка
    render_chart(chart, output_path="natal.svg")  # строка + файл
"""

import math
import re
from pathlib import Path
from typing import Optional

# ══════════════════════════════════════════════════════════════════════════════
#  Layout
# ══════════════════════════════════════════════════════════════════════════════

SIZE = 900
CX = CY = SIZE / 2

R_RIM         = 444
R_ZODIAC_OUT  = 434
R_ZODIAC_IN   = 390
R_TICK_OUT    = 390
R_TICK_MED    = 381
R_TICK_5      = 376
R_TICK_1      = 373
R_TICK_IN     = 365
R_HOUSE_OUT   = 365
R_HOUSE_IN    = 308
R_PLANET_HI   = 300
R_PLANET      = 280
R_PLANET_LO   = 260
R_INNER       = 250
R_CENTER      = 54
PLANET_ICON_R = 13
SIGN_ICON_R   = 15
ICONS_PATH    = Path(__file__).parent / "icons"

# ══════════════════════════════════════════════════════════════════════════════
#  Тема — surface palette
# ══════════════════════════════════════════════════════════════════════════════

T: dict[str, str] = {
    "bg":         "#030712",
    "bg2":        "#111827",
    "rim":        "#1f2937",
    "grid":       "#374151",
    "grid2":      "#4b5567",
    "text":       "#dadfea",
    "text_dim":   "#8d97aa",
    "tick_hi":    "#b8c0cf",
    "tick_lo":    "#6a7589",
    "accent":     "#2a7dfa",
    "danger":     "#f92b35",
    "cream":      "#dedacd",
    "house_tick": "#dadfea",

    "retro_label": "#dadfea",
    "asc_label": "#e8c060",
    "desc_label": "#e8c060",
    "ic_label": "#36d9d3",
    "mc_label": "#36d9d3",
    "house_number_label": "#6a7589",

    "cusp_angle": "#6e5722",
    "cusp_mc":    "#1b6663",
    "cusp_house": "#1f2937",
    "cusp_house_line": "#4b5567",
}

ELEMENT_BG: dict[str, str] = {
    "Aries":       "#180606", "Leo":         "#180606", "Sagittarius": "#180606",
    "Taurus":      "#121212", "Virgo":       "#121212", "Capricorn":   "#121212",
    "Gemini":      "#000F00", "Libra":       "#000F00", "Aquarius":    "#000F00",
    "Cancer":      "#060c18", "Scorpio":     "#060c18", "Pisces":      "#060c18",
}
ELEMENT_STROKE: dict[str, str] = {
    "Aries":       "#a83020", "Leo":         "#a83020", "Sagittarius": "#a83020",
    "Taurus":      "#828282", "Virgo":       "#828282", "Capricorn":   "#828282",
    "Gemini":      "#009C00", "Libra":       "#009C00", "Aquarius":    "#009C00",
    "Cancer":      "#1860a8", "Scorpio":     "#1860a8", "Pisces":      "#1860a8",
}
ELEMENT_TEXT: dict[str, str] = {
    "Aries":       "#e06050", "Leo":         "#e06050", "Sagittarius": "#e06050",
    "Taurus":      "#b0b0b0", "Virgo":       "#b0b0b0", "Capricorn":   "#b0b0b0",
    "Gemini":      "#50d050", "Libra":       "#50d050", "Aquarius":    "#50d050",
    "Cancer":      "#50a0e0", "Scorpio":     "#50a0e0", "Pisces":      "#50a0e0",
}

PLANET_COLOR: dict[str, str] = {
    "Sun":        "#FF332D", "Moon":       "#3090FF", "Mercury":    "#27C81F",
    "Venus":      "#27C81F", "Mars":       "#FF332D", "Jupiter":    "#FF332D",
    "Saturn":     "#676767", "Uranus":     "#27C81F", "Neptune":    "#3090FF",
    "Pluto":      "#3090FF", "Chiron":     "#676767", "Lilith":     "#676767",
    "TrueLilith": "#676767", "NorthNode":  "#676767", "SouthNode":  "#676767",
    "MeanNode":   "#676767", "TrueNode":   "#676767", "Fortune":    "#676767",
}

# ══════════════════════════════════════════════════════════════════════════════
#  Аспекты — настраивай через configure_aspect()
# ══════════════════════════════════════════════════════════════════════════════

ASPECT_CONFIG: dict[str, dict] = {
    "Conjunction":    {"color": "#f0c040", "width": 1.8, "dash": "",         "opacity": 0.90},
    "Opposition":     {"color": "#f92b35", "width": 1.8, "dash": "",         "opacity": 0.90},
    "Square":         {"color": "#f92b35", "width": 1.3, "dash": "",         "opacity": 0.80},
    "Trine":          {"color": "#2a7dfa", "width": 1.8, "dash": "",         "opacity": 0.88},
    "Sextile":        {"color": "#38b878", "width": 1.3, "dash": "6,3",      "opacity": 0.80},
    "Semisextile":    {"color": "#6a7589", "width": 0.8, "dash": "3,4",      "opacity": 0.55},
    "Quincunx":       {"color": "#8850c0", "width": 0.8, "dash": "5,3",      "opacity": 0.55},
    "Semisquare":     {"color": "#d07828", "width": 0.8, "dash": "3,3",      "opacity": 0.55},
    "Sesquiquadrate": {"color": "#d07828", "width": 0.8, "dash": "3,3",      "opacity": 0.55},
    "Quintile":       {"color": "#28b8b8", "width": 0.8, "dash": "6,2,2,2", "opacity": 0.55},
    "Biquintile":     {"color": "#28b8b8", "width": 0.8, "dash": "6,2,2,2", "opacity": 0.55},
}


def configure_aspect(
    name:    str,
    color:   Optional[str]   = None,
    width:   Optional[float] = None,
    dash:    Optional[str]   = None,
    opacity: Optional[float] = None,
) -> None:
    """
    Изменить визуал аспекта. Можно вызывать до render_chart().

    configure_aspect("Trine",      color="#00ff88", width=2.5)
    configure_aspect("Opposition", dash="4,4",      opacity=0.6)
    configure_aspect("Square",     color="#ff0000", width=2.0, dash="")
    """
    if name not in ASPECT_CONFIG:
        raise ValueError(f"Неизвестный аспект '{name}'. Доступные: {list(ASPECT_CONFIG)}")
    cfg = ASPECT_CONFIG[name]
    if color   is not None: cfg["color"]   = color
    if width   is not None: cfg["width"]   = width
    if dash    is not None: cfg["dash"]    = dash
    if opacity is not None: cfg["opacity"] = opacity


# ══════════════════════════════════════════════════════════════════════════════
#  Константы знаков / планет
# ══════════════════════════════════════════════════════════════════════════════

ZODIAC_SIGNS = [
    "Aries","Taurus","Gemini","Cancer","Leo","Virgo",
    "Libra","Scorpio","Sagittarius","Capricorn","Aquarius","Pisces",
]
ZODIAC_GLYPHS: dict[str, str] = {
    "Aries":"♈","Taurus":"♉","Gemini":"♊","Cancer":"♋",
    "Leo":"♌","Virgo":"♍","Libra":"♎","Scorpio":"♏",
    "Sagittarius":"♐","Capricorn":"♑","Aquarius":"♒","Pisces":"♓",
}
PLANET_GLYPHS: dict[str, str] = {
    "Sun":"☉","Moon":"☽","Mercury":"☿","Venus":"♀","Mars":"♂",
    "Jupiter":"♃","Saturn":"♄","Uranus":"♅","Neptune":"♆","Pluto":"♇",
    "Chiron":"⚷","Lilith":"⚸","TrueLilith":"⚸","NorthNode":"☊",
    "SouthNode":"☋","Fortune":"⊕","MeanNode":"☊","TrueNode":"☊",
}
_SKIP_ASPECTS = {"Parallel", "Contraparallel"}

# ══════════════════════════════════════════════════════════════════════════════
#  Загрузка SVG-иконок
# ══════════════════════════════════════════════════════════════════════════════

def _load_svg_symbols() -> tuple[str, set[str]]:
    """
    Читает icons/planets/*.svg и icons/signs/*.svg.
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

                # Парсим viewBox и добавляем padding
                vb = re.search(r'viewBox=["\']([^"\']+)["\']', raw)
                viewbox = vb.group(1) if vb else "0 0 24 24"
                try:
                    x, y, w, h = (float(v) for v in viewbox.split())
                    pad = 5
                    viewbox = f"{x - pad} {y - pad} {w + pad*2} {h + pad*2}"
                except ValueError:
                    pass

                # Вырезаем содержимое SVG
                inner = re.sub(r'(?s)<\?xml[^?]*\?>', '', raw)
                inner = re.sub(r'(?s)<!DOCTYPE[^>]*>', '', inner)
                inner = re.sub(r'(?s)<svg[^>]*>', '', inner, count=1)
                inner = re.sub(r'</svg>', '', inner).strip()

                sym_id = f"{prefix}-{name}"
                parts.append(
                    f'<symbol id="{sym_id}" viewBox="{viewbox}" '
                    f'overflow="visible">{inner}</symbol>'
                )
                available.add(sym_id)
            except Exception as e:
                print(f"[chart_svg] warn: {path.name}: {e}")

    return "\n".join(parts), available

# ══════════════════════════════════════════════════════════════════════════════
#  Геометрия
# ══════════════════════════════════════════════════════════════════════════════

def _to_svg_angle(lon: float, asc_lon: float) -> float:
    return (asc_lon - lon + 180.0) % 360.0


def _polar(r: float, angle_deg: float) -> tuple[float, float]:
    a = math.radians(angle_deg)
    return CX + r * math.cos(a), CY + r * math.sin(a)


def _arc(r_out: float, r_in: float, a1: float, a2: float) -> str:
    span  = (a2 - a1) % 360
    if span < 0.001:
        span = 360
    large = 1 if span > 180 else 0
    a1r, a2r = math.radians(a1), math.radians(a2)
    ox1 = CX + r_out*math.cos(a1r); oy1 = CY + r_out*math.sin(a1r)
    ox2 = CX + r_out*math.cos(a2r); oy2 = CY + r_out*math.sin(a2r)
    ix1 = CX + r_in *math.cos(a2r); iy1 = CY + r_in *math.sin(a2r)
    ix2 = CX + r_in *math.cos(a1r); iy2 = CY + r_in *math.sin(a1r)
    return (
        f"M {ox1:.2f},{oy1:.2f} "
        f"A {r_out:.1f},{r_out:.1f} 0 {large},1 {ox2:.2f},{oy2:.2f} "
        f"L {ix1:.2f},{iy1:.2f} "
        f"A {r_in:.1f},{r_in:.1f} 0 {large},0 {ix2:.2f},{iy2:.2f} Z"
    )


def _circle(r: float, fill: str = "none",
            stroke: Optional[str] = None, sw: float = 1.0,
            opacity: float = 1.0) -> str:
    s  = f' stroke="{stroke}" stroke-width="{sw}"' if stroke else ""
    op = f' opacity="{opacity}"' if opacity < 1.0 else ""
    return f'<circle cx="{CX}" cy="{CY}" r="{r:.1f}" fill="{fill}"{s}{op}/>'


def _place_icon(sym_id: str, x: float, y: float, r: float,
                available: set[str], color: str, fallback: str) -> str:
    if sym_id in available:
        return (
            f'<use href="#{sym_id}" overflow="visible" '
            f'x="{x - r:.1f}" y="{y - r:.1f}" '
            f'width="{r*2:.0f}" height="{r*2:.0f}"/>'
        )
    return (
        f'<text x="{x:.1f}" y="{y:.1f}" '
        f'text-anchor="middle" dominant-baseline="central" '
        f'fill="{color}" font-size="{int(r*1.5)}" '
        f'font-family="serif,symbola,unifont">{fallback}</text>'
    )

# ══════════════════════════════════════════════════════════════════════════════
#  Восстановление долгот
# ══════════════════════════════════════════════════════════════════════════════

def _build_lons(planets_data: dict) -> dict[str, float]:
    lons: dict[str, float] = {}
    for name, pdata in planets_data.items():
        if "longitude" in pdata:
            lons[name] = float(pdata["longitude"])
        else:
            sign = pdata["sign"]["name"]
            deg  = pdata["sign"]["degree"]
            idx  = ZODIAC_SIGNS.index(sign) if sign in ZODIAC_SIGNS else 0
            lons[name] = idx * 30.0 + float(deg)
    return lons

# ══════════════════════════════════════════════════════════════════════════════
#  Деоверлап
# ══════════════════════════════════════════════════════════════════════════════

_CLUSTER_THR  = 9.0
_RING_OPTIONS = [R_PLANET_HI, R_PLANET, R_PLANET_LO, R_PLANET_HI - 12]


def _deoverlap(planet_angles: dict[str, float]) -> dict[str, float]:
    radii = {n: R_PLANET for n in planet_angles}
    if len(planet_angles) < 2:
        return radii

    items = sorted(planet_angles.items(), key=lambda x: x[1])
    cluster: list[str] = [items[0][0]]
    clusters: list[list[str]] = []

    for i in range(1, len(items)):
        diff = min((items[i][1] - items[i-1][1]) % 360,
                   (items[i-1][1] - items[i][1]) % 360)
        if diff < _CLUSTER_THR:
            cluster.append(items[i][0])
        else:
            clusters.append(cluster)
            cluster = [items[i][0]]
    clusters.append(cluster)

    if len(clusters) > 1:
        la = planet_angles[clusters[-1][-1]]
        fa = planet_angles[clusters[0][0]]
        if min((fa - la) % 360, (la - fa) % 360) < _CLUSTER_THR:
            clusters[0] = clusters[-1] + clusters[0]
            clusters.pop()

    for cl in clusters:
        for j, name in enumerate(cl):
            radii[name] = _RING_OPTIONS[j % len(_RING_OPTIONS)]

    return radii

# ══════════════════════════════════════════════════════════════════════════════
#  Слои
# ══════════════════════════════════════════════════════════════════════════════

def _render_background() -> list[str]:
    return [
        f'<rect width="{SIZE}" height="{SIZE}" fill="{T["bg"]}"/>',
        _circle(R_RIM,        stroke=T["rim"],   sw=1.5),
        _circle(R_ZODIAC_OUT, stroke=T["grid"],  sw=0.8),
        _circle(R_ZODIAC_IN,  stroke=T["grid"],  sw=0.8),
        _circle(R_TICK_IN,    stroke=T["grid2"], sw=0.5),
        _circle(R_HOUSE_OUT,  stroke=T["grid2"], sw=0.5),
        _circle(R_HOUSE_IN,   stroke=T["rim"],   sw=1.0),
        _circle(R_INNER,      stroke=T["grid"],  sw=1.2),
        _circle(R_CENTER,     fill=T["bg2"], stroke=T["rim"], sw=1.2),
    ]


def _render_zodiac_ring(asc_lon: float, available: set[str]) -> list[str]:
    out = []
    for i, sign in enumerate(ZODIAC_SIGNS):
        lon_s = i * 30.0
        a1 = _to_svg_angle(lon_s + 30.0, asc_lon)
        a2 = _to_svg_angle(lon_s,        asc_lon)
        path = _arc(R_ZODIAC_OUT, R_ZODIAC_IN, a1, a2)

        # Рендер зодиака, оконтовка
        out.append(
            f'<path d="{path}" fill="{ELEMENT_BG[sign]}" '
            f'stroke="{ELEMENT_STROKE[sign]}" stroke-width="1.9" opacity="0.95"/>'
        )

        ab = _to_svg_angle(lon_s, asc_lon)
        x1, y1 = _polar(R_ZODIAC_OUT, ab)
        x2, y2 = _polar(R_ZODIAC_IN,  ab)
        out.append(
            f'<line x1="{x1:.1f}" y1="{y1:.1f}" x2="{x2:.1f}" y2="{y2:.1f}" '
            f'stroke="{ELEMENT_STROKE[sign]}" stroke-width="1.9"/>'
        )
        ma = _to_svg_angle(lon_s + 15.0, asc_lon)
        sx, sy = _polar((R_ZODIAC_OUT + R_ZODIAC_IN) / 2, ma)
        out.append(_place_icon(
            f"sign-{sign}", sx, sy, SIGN_ICON_R,
            available, ELEMENT_TEXT[sign], ZODIAC_GLYPHS[sign]
        ))
    return out


def _render_degree_ticks(asc_lon: float) -> list[str]:
    out = []
    for deg in range(360):
        if deg % 30 == 0:
            continue
        svg_a = _to_svg_angle(float(deg), asc_lon)
        if   deg % 10 == 0: r_in, sw, col = R_TICK_MED, 1.3, T["tick_hi"]
        elif deg % 5  == 0: r_in, sw, col = R_TICK_5,   0.9, T["tick_hi"]
        else:                r_in, sw, col = R_TICK_1,   0.5, T["tick_lo"]
        x1, y1 = _polar(R_TICK_OUT, svg_a)
        x2, y2 = _polar(r_in,       svg_a)
        out.append(
            f'<line x1="{x1:.1f}" y1="{y1:.1f}" x2="{x2:.1f}" y2="{y2:.1f}" '
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
        lon   = cusps[house_num]
        svg_a = _to_svg_angle(lon, asc_lon)

        is_axis = house_num in (1, 4, 7, 10)
        sw    = 3.2 if is_axis else 1.0
        color = (
            T["cusp_angle"] if house_num in (1, 7)  else
            T["cusp_mc"]    if house_num in (4, 10) else
            T["cusp_house_line"]
        )
        width = (
            2 if house_num in (1, 7)  else
            2 if house_num in (4, 10) else
            4
        )
        opacity = (
            1 if house_num in (1, 7)  else
            1 if house_num in (4, 10) else
            0.5
        )
        r_end = R_CENTER if is_axis else R_INNER
        x1, y1 = _polar(R_HOUSE_OUT, svg_a)
        x2, y2 = _polar(r_end,       svg_a)
        dash = "" if is_axis else ' stroke-dasharray="4,3"'
        out.append(
            f'<line x1="{x1:.1f}" y1="{y1:.1f}" x2="{x2:.1f}" y2="{y2:.1f}" '
            f'stroke="{color}" stroke-width="{width}" opacity="{opacity}"/>'
        )

        # Белая черта начала дома на тиковой полосе
        wx1, wy1 = _polar(R_TICK_OUT, svg_a)
        wx2, wy2 = _polar(R_TICK_IN,  svg_a)
        out.append(
            f'<line x1="{wx1:.1f}" y1="{wy1:.1f}" x2="{wx2:.1f}" y2="{wy2:.1f}" '
            f'stroke="{T["house_tick"]}" stroke-width="1.4" opacity="1"/>'
        )

        # Номер дома (крупнее)
        next_lon = cusps[(house_num % 12) + 1]
        span     = (next_lon - lon) % 360
        mid_a    = _to_svg_angle((lon + span / 2) % 360, asc_lon)
        lx, ly   = _polar((R_HOUSE_OUT + R_HOUSE_IN) / 2, mid_a)
        out.append(
            f'<text x="{lx:.1f}" y="{ly:.1f}" '
            f'text-anchor="middle" dominant-baseline="central" '
            f'fill="{T["house_number_label"]}" font-size="17" '
            f'font-family="sans-serif" font-weight="500">{house_num}</text>'
        )

    return out


def _render_aspect_lines(planets_data: dict, lons: dict[str, float],
                          asc_lon: float) -> list[str]:
    out  = []
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

            style = ASPECT_CONFIG.get(asp_type)
            if not style:
                continue

            a1 = _to_svg_angle(lons[p_name], asc_lon)
            a2 = _to_svg_angle(lons[target], asc_lon)
            x1, y1 = _polar(R_INNER, a1)
            x2, y2 = _polar(R_INNER, a2)
            dash = f' stroke-dasharray="{style["dash"]}"' if style["dash"] else ""
            out.append(
                f'<line x1="{x1:.1f}" y1="{y1:.1f}" x2="{x2:.1f}" y2="{y2:.1f}" '
                f'stroke="{style["color"]}" stroke-width="{style["width"]}" '
                f'opacity="{style["opacity"]}"{dash}/>'
            )
    return out


def _render_planets(planets_data: dict, lons: dict[str, float],
                     asc_lon: float, available: set[str]) -> list[str]:
    out = []
    p_angles = {
        n: _to_svg_angle(lon, asc_lon)
        for n, lon in lons.items()
        if n in planets_data
    }
    radii = _deoverlap(p_angles)

    for name in lons:
        if name not in planets_data:
            continue

        pdata = planets_data[name]
        svg_a = p_angles[name]
        r     = radii.get(name, R_PLANET)
        # Планета
        x, y = _polar(r, svg_a)

        color = PLANET_COLOR.get(name, "#b0b0d0")
        glyph = PLANET_GLYPHS.get(name, "?")
        retro = pdata.get("retrograde", False)

        # Конечная точка линии (не меняем)
        tx, ty = _polar(R_ZODIAC_IN, svg_a)

        # Смещаем старт линии чуть дальше от планеты
        line_offset = 12
        lx, ly = _polar(r + line_offset, svg_a)

        out.append(
            f'<line x1="{lx:.1f}" y1="{ly:.1f}" '
            f'x2="{tx:.1f}" y2="{ty:.1f}" '
            f'stroke="{color}" stroke-width="1.0" opacity="1"/>'
        )

        # Точка-якорь на внутреннем кольце
        dx, dy = _polar(R_INNER, svg_a)
        out.append(
            f'<circle cx="{dx:.1f}" cy="{dy:.1f}" r="2.5" fill="{color}" opacity="0.7"/>'
        )

        # Иконка / глиф (без гало-кружка)
        out.append(_place_icon(
            f"planet-{name}", x, y, PLANET_ICON_R,
            available, color, glyph
        ))

        # Ретроградный символ — белый, крупный
        if retro:
            rx = x + PLANET_ICON_R + 7
            ry = y - PLANET_ICON_R
            out.append(
                f'<text x="{rx:.1f}" y="{ry:.1f}" '
                f'text-anchor="middle" dominant-baseline="central" '
                f'fill="{T["retro_label"]}" font-size="11" font-weight="700" '
                f'font-family="sans-serif">R</text>'
            )

        # Градус внутри знака
        fmt = pdata["sign"].get("formatted", "")
        if fmt:
            lx, ly = _polar(r + PLANET_ICON_R + 17, svg_a)
            out.append(
                f'<text x="{lx:.1f}" y="{ly:.1f}" '
                f'text-anchor="middle" dominant-baseline="central" '
                f'fill="#6a7589" font-size="14" '
                f'font-family="monospace,courier">{fmt}</text>'
            )

    return out


def _render_angle_labels(asc_lon: float, mc_lon: float) -> list[str]:
    out     = []
    dsc_lon = (asc_lon + 180) % 360
    ic_lon  = (mc_lon  + 180) % 360
    r_label = R_TICK_IN - 16

    for label, lon, color in [
        ("ASC", asc_lon,  T["asc_label"]),
        ("DSC", dsc_lon,  T["desc_label"]),
        ("MC",  mc_lon,   T["mc_label"]),
        ("IC",  ic_lon,   T["ic_label"]),
    ]:
        svg_a  = _to_svg_angle(lon, asc_lon)
        lx, ly = _polar(r_label, svg_a)
        out.append(
            f'<text x="{lx:.1f}" y="{ly:.1f}" '
            f'text-anchor="middle" dominant-baseline="central" '
            f'fill="{color}" font-size="11.5" '
            f'font-family="sans-serif" font-weight="700">{label}</text>'
        )
    return out

# ══════════════════════════════════════════════════════════════════════════════
#  Публичный API
# ══════════════════════════════════════════════════════════════════════════════

def render_chart(
    chart_data: dict,
    output_path: Optional[str] = None,
) -> str:
    """
    Рендерит SVG натальной карты и возвращает строку.

    chart_data должен содержать:
        "planets", "houses", "asc", "mc"

    output_path (необязательно) — записать файл.

    Пример в эндпоинте (Flask/FastAPI):
        svg = render_chart(chart)
        return Response(svg, mimetype="image/svg+xml")
    """
    asc_lon = float(chart_data["asc"])
    mc_lon  = float(chart_data["mc"])
    planets = chart_data["planets"]
    houses  = chart_data["houses"]
    lons    = _build_lons(planets)

    icon_defs, available = _load_svg_symbols()
    if available:
        print(f"[chart_svg] иконок: {len(available)}")
    else:
        print("[chart_svg] иконки не найдены — Unicode глифы")

    parts: list[str] = [
        f'<svg xmlns="http://www.w3.org/2000/svg" '
        f'viewBox="0 0 {SIZE} {SIZE}" '
        f'width="{SIZE}" height="{SIZE}">',
        f'<defs>\n{icon_defs}\n</defs>',
    ]

    parts += _render_background()
    parts += _render_zodiac_ring(asc_lon, available)
    parts += _render_degree_ticks(asc_lon)
    parts += _render_house_ring(houses, asc_lon)
    parts += _render_aspect_lines(planets, lons, asc_lon)
    parts += _render_planets(planets, lons, asc_lon, available)
    parts += _render_angle_labels(asc_lon, mc_lon)

    parts.append("</svg>")
    svg = "\n".join(parts)

    if output_path:
        Path(output_path).write_text(svg, encoding="utf-8")
        print(f"[chart_svg] → {output_path}")

    return svg

# ══════════════════════════════════════════════════════════════════════════════
#  CLI
# ══════════════════════════════════════════════════════════════════════════════

if __name__ == "__main__":
    import sys, datetime
    sys.path.insert(0, str(Path(__file__).parent))
    try:
        from ephemeris import calculate_chart
    except ImportError:
        print("Не удаётся импортировать ephemeris.py"); sys.exit(1)

    chart = calculate_chart(datetime.datetime(1990, 6, 15, 14, 30), 50.45, 30.52)

    if "asc" not in chart:
        print(
            "Добавь в return ephemeris.py:\n"
            '    "asc": round(ascmc[0], 4),\n'
            '    "mc":  round(ascmc[1], 4),'
        )
        sys.exit(1)

    svg = render_chart(chart, output_path="natal.svg")
    print(f"SVG: {len(svg)} символов. Открой natal.svg в браузере.")
