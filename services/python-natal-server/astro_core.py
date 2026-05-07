import swisseph as swe
import datetime
import math

from config import (
    EPHE_PATH, UTC_OFFSET, PARALLEL_ORB,
    ZODIAC,
    PLANETS, ASPECTS,
)

swe.set_ephe_path(EPHE_PATH)

# ── Internal tables ───────────────────────────────────────────────────────────

_PLANET_CODES: dict[str, int] = {
    "Sun":         swe.SUN,
    "Moon":        swe.MOON,
    "Mercury":     swe.MERCURY,
    "Venus":       swe.VENUS,
    "Mars":        swe.MARS,
    "Jupiter":     swe.JUPITER,
    "Saturn":      swe.SATURN,
    "Uranus":      swe.URANUS,
    "Neptune":     swe.NEPTUNE,
    "Pluto":       swe.PLUTO,
    "Chiron":      swe.CHIRON,
    "Lilith":      swe.MEAN_APOG,
    "TrueLilith":  swe.OSCU_APOG,
    "MeanNode":    swe.MEAN_NODE,
    "TrueNode":    swe.TRUE_NODE,
    "Pholus":      swe.PHOLUS,
    "Ceres":       swe.CERES,
    "Pallas":      swe.PALLAS,
    "Juno":        swe.JUNO,
    "Vesta":       swe.VESTA,
    "Eris":        swe.AST_OFFSET + 136199,
    "Sedna":       swe.AST_OFFSET + 90377,
    "Haumea":      swe.AST_OFFSET + 136108,
    "Makemake":    swe.AST_OFFSET + 136472,
    "Quaoar":      swe.AST_OFFSET + 50000,
    "Orcus":       swe.AST_OFFSET + 90482,
}

_ASPECT_DEGREES: dict[str, float] = {
    "Conjunction":      0,
    "Opposition":     180,
    "Square":          90,
    "Trine":          120,
    "Sextile":         60,
    "Semisextile":     30,
    "Quincunx":       150,
    "Semisquare":      45,
    "Sesquiquadrate": 135,
    "Quintile":        72,
    "Biquintile":     144,
}

_LUMINARIES: frozenset[str] = frozenset({"Sun", "Moon"})

# Элементы знаков зодиака
_SIGN_ELEMENTS: dict[str, str] = {
    "Aries":       "Fire",
    "Taurus":      "Earth",
    "Gemini":      "Air",
    "Cancer":      "Water",
    "Leo":         "Fire",
    "Virgo":       "Earth",
    "Libra":       "Air",
    "Scorpio":     "Water",
    "Sagittarius": "Fire",
    "Capricorn":   "Earth",
    "Aquarius":    "Air",
    "Pisces":      "Water",
}

# Active aspects ordered as defined in config
_active_aspects: dict[str, float] = {
    name: _ASPECT_DEGREES[name]
    for name in ASPECTS
    if name in _ASPECT_DEGREES
}

# Validation sets (for server.py)
VALID_PLANETS = set(PLANETS)
VALID_ASPECTS  = set(ASPECTS)


# ── Helpers ───────────────────────────────────────────────────────────────────

def _ecliptic_to_equatorial(longitude: float, year: int, latitude: float = 0) -> float:
    eps = math.radians(23.439291 - 0.0130042 * (year - 2000) / 100)
    lon = math.radians(longitude)
    lat = math.radians(latitude)
    sin_decl = math.sin(lat) * math.cos(eps) + math.cos(lat) * math.sin(eps) * math.sin(lon)
    return math.degrees(math.asin(sin_decl))


def _format_angle(degrees: float) -> str:
    d = int(degrees)
    m = int((degrees - d) * 60)
    return f"{d}°{m:02d}'"


def _get_sign(deg: float) -> tuple[str, float]:
    return ZODIAC[int(deg // 30) % 12], deg % 30


def _get_house(deg: float, cusps: list) -> int | None:
    for i in range(12):
        start, end = cusps[i], cusps[(i + 1) % 12]
        if start < end:
            if start <= deg < end:
                return i + 1
        else:
            if deg >= start or deg < end:
                return i + 1
    return None


def _get_orb(aspect: str, p1: str, p2: str) -> float:
    if aspect in ("Conjunction", "Opposition", "Square", "Trine"):
        return 10.0 if (p1 in _LUMINARIES or p2 in _LUMINARIES) else 7.0
    if aspect == "Sextile":
        return 5.5 if (p1 in _LUMINARIES or p2 in _LUMINARIES) else 4.0
    return 2.5


def _is_applying(p1_lon, p2_lon, p1_spd, p2_spd, angle) -> bool:
    diff = (p2_lon - p1_lon) % 360
    if diff > 180:
        diff -= 360
    exact_diff = abs(abs(diff) - angle)
    rel_spd = p2_spd - p1_spd
    if angle == 0:
        return (diff > 0 and rel_spd < 0) or (diff < 0 and rel_spd > 0)
    if angle == 180:
        return ((0 < diff < 180 and rel_spd > 0) or (-180 < diff < 0 and rel_spd < 0))
    future_diff = abs(abs(diff + rel_spd * 0.01) - angle)
    return future_diff < exact_diff


def _calc_aspects(p1_lon, p2_lon, p1_name, p2_name, p1_spd, p2_spd,
                  override: dict | None = None) -> list:
    table = override if override is not None else _active_aspects
    results = []
    for asp_name, asp_angle in table.items():
        orb = _get_orb(asp_name, p1_name, p2_name)
        delta = min(abs(p1_lon - p2_lon) % 360, 360 - abs(p1_lon - p2_lon) % 360)
        if abs(delta - asp_angle) <= orb:
            diff = (p2_lon - p1_lon) % 360
            if diff > 180:
                diff -= 360
            orb_exact = abs(abs(diff) - asp_angle)
            applying = _is_applying(p1_lon, p2_lon, p1_spd, p2_spd, asp_angle)
            results.append((asp_name, round(orb_exact, 2), "applying" if applying else "separating"))
    return results


def _calc_parallels(decl1, decl2, name1, name2, decl_speed) -> list:
    spd1 = decl_speed.get(name1, 0)
    spd2 = decl_speed.get(name2, 0)
    diff = abs(abs(decl1) - abs(decl2))
    if diff > PARALLEL_ORB:
        return []
    applying = abs(abs(decl1 + spd1 * 0.01) - abs(decl2 + spd2 * 0.01)) < diff
    asp = "Parallel" if (decl1 > 0) == (decl2 > 0) else "Contraparallel"
    return [(asp, round(diff, 2), "applying" if applying else "separating")]


def _calc_house_aspects(house_lon: float, house_num: int,
                        lons: dict, speeds: dict,
                        override: dict | None = None) -> list:
    """Аспекты куспида дома к планетам (орбы фиксированные — как у минорных)."""
    table = override if override is not None else _active_aspects
    results = []
    house_name = f"House{house_num}"
    for planet_name, planet_lon in lons.items():
        for asp_name, asp_angle in table.items():
            orb = _get_orb(asp_name, house_name, planet_name)
            delta = min(
                abs(house_lon - planet_lon) % 360,
                360 - abs(house_lon - planet_lon) % 360,
            )
            if abs(delta - asp_angle) <= orb:
                diff = (planet_lon - house_lon) % 360
                if diff > 180:
                    diff -= 360
                orb_exact = abs(abs(diff) - asp_angle)
                applying = _is_applying(
                    house_lon, planet_lon,
                    0, speeds.get(planet_name, 0),
                    asp_angle,
                )
                results.append({
                    "type":     asp_name,
                    "target":   planet_name,
                    "orb":      round(orb_exact, 2),
                    "applying": "applying" if applying else "separating",
                })
    return results


# ── Main ──────────────────────────────────────────────────────────────────────

def calculate_chart(
    birth_dt_local: datetime.datetime,
    lat: float,
    lon: float,
    requested_planets: list | None = None,
    requested_aspects: list | None = None,
) -> dict:

    utc_dt = birth_dt_local - datetime.timedelta(hours=UTC_OFFSET)
    year, month, day = utc_dt.year, utc_dt.month, utc_dt.day
    hour = utc_dt.hour + utc_dt.minute / 60

    jd      = swe.julday(year, month, day, hour)
    jd_next = jd + 1 / 24

    cusps, ascmc = swe.houses(jd, lat, lon)
    house_cusps = cusps[:12]

    # Which planets to compute
    want_planets = set(requested_planets) if requested_planets else set(PLANETS)

    lons:       dict[str, float] = {}
    speeds:     dict[str, float] = {}
    decls:      dict[str, float] = {}
    decl_spds:  dict[str, float] = {}
    retrogrades: dict[str, bool] = {}

    for name in PLANETS:
        if name not in want_planets or name not in _PLANET_CODES:
            continue
        try:
            r     = swe.calc_ut(jd,      _PLANET_CODES[name], swe.FLG_SWIEPH | swe.FLG_SPEED)
            r_nxt = swe.calc_ut(jd_next, _PLANET_CODES[name], swe.FLG_SWIEPH | swe.FLG_SPEED)
            lons[name]        = r[0][0]
            decls[name]       = r[0][1]
            retrogrades[name] = r[0][3] < 0
            spd = r_nxt[0][0] - r[0][0]
            if spd >  180: spd -= 360
            if spd < -180: spd += 360
            speeds[name]    = spd
            decl_spds[name] = r_nxt[0][1] - r[0][1]
        except Exception:
            pass

    # Aspect table override from request
    asp_override = None
    if requested_aspects is not None:
        asp_override = {
            name: _ASPECT_DEGREES[name]
            for name in requested_aspects
            if name in _ASPECT_DEGREES
        }

    # ── Planets ───────────────────────────────────────────────────────────────
    planets_result: dict = {}

    for planet_name in [p for p in PLANETS if p in lons]:
        deg = lons[planet_name]
        sign, deg_in_sign = _get_sign(deg)

        planet_data = {
            "sign": {
                "name": sign,
                "degree": round(deg_in_sign, 2),
                "formatted": _format_angle(deg_in_sign),
            },
            "house":      _get_house(deg, house_cusps),
            "retrograde": retrogrades.get(planet_name, False),
            "aspects":    [],
        }

        for other_name, other_deg in lons.items():
            if other_name == planet_name:
                continue

            for asp_name, orb_exact, direction in _calc_aspects(
                deg, other_deg, planet_name, other_name,
                speeds.get(planet_name, 0),
                speeds.get(other_name, 0),
                asp_override,
            ):
                planet_data["aspects"].append({
                    "type":     asp_name,
                    "target":   other_name,
                    "orb":      orb_exact,
                    "applying": direction,
                })

            if planet_name in decls and other_name in decls:
                for asp_name, orb_exact, direction in _calc_parallels(
                    decls[planet_name], decls[other_name],
                    planet_name, other_name, decl_spds,
                ):
                    planet_data["aspects"].append({
                        "type":     asp_name,
                        "target":   other_name,
                        "orb":      orb_exact,
                        "applying": direction,
                    })

        planets_result[planet_name] = planet_data

    # ── Houses ────────────────────────────────────────────────────────────────
    houses_result: dict = {}

    for i, cusp_lon in enumerate(house_cusps):
        house_num  = i + 1
        sign, deg_in_sign = _get_sign(cusp_lon)
        house_aspects = _calc_house_aspects(cusp_lon, house_num, lons, speeds, asp_override)

        houses_result[f"House{house_num}"] = {
            "cusp_longitude": round(cusp_lon, 4),
            "sign": {
                "name":      sign,
                "degree":    round(deg_in_sign, 2),
                "formatted": _format_angle(deg_in_sign),
            },
            "aspects": house_aspects,
        }

    # ── Alchemy ───────────────────────────────────────────────────────────────
    element_counts: dict[str, int] = {"Fire": 0, "Earth": 0, "Air": 0, "Water": 0}
    sign_counts:    dict[str, int] = {}

    for planet_name in lons:
        deg  = lons[planet_name]
        sign = _get_sign(deg)[0]
        element = _SIGN_ELEMENTS[sign]
        element_counts[element] = element_counts.get(element, 0) + 1
        sign_counts[sign]       = sign_counts.get(sign, 0) + 1

    dominant_element = max(element_counts, key=lambda e: element_counts[e])
    dominant_sign    = max(sign_counts,    key=lambda s: sign_counts[s])
    dominant = {
        "sign": dominant_sign,
        "count": sign_counts[dominant_sign]
    }

    alchemy_result = {
        "elements":         element_counts,
        "dominant_element": dominant_element,
        "signs":            sign_counts,
        "dominant_sign":    dominant,
    }

    return {
        "planets": planets_result,
        "houses":  houses_result,
        "alchemy": alchemy_result,
    }
