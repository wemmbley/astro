from fastapi import FastAPI, Request, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from slowapi import Limiter, _rate_limit_exceeded_handler
from slowapi.util import get_remote_address
from slowapi.errors import RateLimitExceeded
from pydantic import BaseModel, field_validator
from typing import Optional
from chart_svg import render_chart
import datetime
import logging
import time

from config import ALLOWED_IPS, RATE_LIMIT
from astro_core import calculate_chart, VALID_PLANETS, VALID_ASPECTS

logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s [%(levelname)s] %(message)s"
)
logger = logging.getLogger(__name__)

limiter = Limiter(key_func=get_remote_address)

app = FastAPI(title="Astro API", docs_url="/docs", redoc_url="/redoc")

app.state.limiter = limiter
app.add_exception_handler(RateLimitExceeded, _rate_limit_exceeded_handler)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["https://frontend.loc"],
    allow_methods=["POST"],
    allow_headers=["Content-Type"],
)


# ── Middleware: IP whitelist ──────────────────────────────────────────────────

@app.middleware("http")
async def ip_whitelist(request: Request, call_next):
    forwarded_for = request.headers.get("X-Forwarded-For")
    client_ip = forwarded_for.split(",")[0].strip() if forwarded_for else request.client.host

    if client_ip not in ALLOWED_IPS:
        logger.warning(f"Blocked request from {client_ip}")
        raise HTTPException(status_code=403, detail="Forbidden")

    return await call_next(request)


# ── Схема запроса ─────────────────────────────────────────────────────────────

class ChartRequest(BaseModel):
    birth_datetime: str   # "DD-MM-YYYY HH:MM"
    lat: float
    lon: float
    planets: Optional[list[str]] = None
    aspects: Optional[list[str]] = None

    @field_validator("birth_datetime")
    @classmethod
    def validate_datetime(cls, v):
        try:
            datetime.datetime.strptime(v, "%d-%m-%Y %H:%M")
        except ValueError:
            raise ValueError("Формат: DD-MM-YYYY HH:MM")
        return v

    @field_validator("lat")
    @classmethod
    def validate_lat(cls, v):
        if not -90 <= v <= 90:
            raise ValueError("Широта: -90..90")
        return v

    @field_validator("lon")
    @classmethod
    def validate_lon(cls, v):
        if not -180 <= v <= 180:
            raise ValueError("Долгота: -180..180")
        return v

    @field_validator("planets")
    @classmethod
    def validate_planets(cls, v):
        if v is not None:
            invalid = set(v) - VALID_PLANETS
            if invalid:
                raise ValueError(f"Неизвестные планеты: {invalid}")
        return v

    @field_validator("aspects")
    @classmethod
    def validate_aspects(cls, v):
        if v is not None:
            invalid = set(v) - VALID_ASPECTS
            if invalid:
                raise ValueError(f"Неизвестные аспекты: {invalid}")
        return v


# ── Общая логика расчёта ──────────────────────────────────────────────────────

def _compute_chart(body: ChartRequest) -> dict:
    """Чистый расчёт без SVG. Вызывается обоими эндпоинтами."""
    birth_dt = datetime.datetime.strptime(body.birth_datetime, "%d-%m-%Y %H:%M")
    return calculate_chart(
        birth_dt_local=birth_dt,
        lat=body.lat,
        lon=body.lon,
        requested_planets=body.planets,
        requested_aspects=body.aspects,
    )


# ── Эндпоинт 1: только данные — быстро ───────────────────────────────────────

@app.post("/chart/data")
@limiter.limit(RATE_LIMIT)
async def get_chart_data(request: Request, body: ChartRequest):
    """
    Возвращает планеты, дома, алхимию, ASC, MC.
    Без SVG — грузится первым, отдаёт данные для таблиц и текста.
    """
    try:
        start = time.time()
        result = _compute_chart(body)
        logger.info(f"/chart/data — {round(time.time() - start, 3)}s")
        return result
    except Exception as e:
        logger.error(f"Calculation error: {e}")
        raise HTTPException(status_code=500, detail="Ошибка расчёта карты")


# ── Эндпоинт 2: только SVG — медленнее, грузится лениво ──────────────────────

@app.post("/chart/svg")
@limiter.limit(RATE_LIMIT)
async def get_chart_svg(request: Request, body: ChartRequest):
    """
    Считает карту + рендерит SVG-колесо.
    Вызывается со фронта после onMounted — не блокирует LCP.
    """
    try:
        start = time.time()
        result = _compute_chart(body)
        svg    = render_chart(result)
        logger.info(f"/chart/svg  — {round(time.time() - start, 3)}s")
        return {"chart_svg": svg}
    except Exception as e:
        logger.error(f"SVG render error: {e}")
        raise HTTPException(status_code=500, detail="Ошибка рендера SVG")


# ── Health ────────────────────────────────────────────────────────────────────

@app.get("/health")
async def health():
    return {"status": "ok"}
