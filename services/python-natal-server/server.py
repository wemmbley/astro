from fastapi import FastAPI, Request, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from slowapi import Limiter, _rate_limit_exceeded_handler
from slowapi.util import get_remote_address
from slowapi.errors import RateLimitExceeded
from pydantic import BaseModel, field_validator
from typing import Optional
import datetime
import logging
import time

from config import ALLOWED_IPS, RATE_LIMIT
from astro_core import calculate_chart, VALID_PLANETS, VALID_ASPECTS

# Логирование
logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s [%(levelname)s] %(message)s"
)
logger = logging.getLogger(__name__)

# Rate limiter — ключ по IP
limiter = Limiter(key_func=get_remote_address)

app = FastAPI(
    title="Astro API",
    docs_url=None,   # скрыть /docs от чужих (или оставить для себя)
    redoc_url=None,
)

app.state.limiter = limiter
app.add_exception_handler(RateLimitExceeded, _rate_limit_exceeded_handler)

# CORS — разрешаем только свой фронт
app.add_middleware(
    CORSMiddleware,
    allow_origins=["https://frontend.loc"],
    allow_methods=["POST"],
    allow_headers=["Content-Type"],
)

# ── Middleware: IP whitelist ──────────────────────────────────────────────────
@app.middleware("http")
async def ip_whitelist(request: Request, call_next):
    # Учитываем прокси (nginx передаёт X-Forwarded-For)
    forwarded_for = request.headers.get("X-Forwarded-For")
    client_ip = forwarded_for.split(",")[0].strip() if forwarded_for else request.client.host

    if client_ip not in ALLOWED_IPS:
        logger.warning(f"Blocked request from {client_ip}")
        raise HTTPException(status_code=403, detail="Forbidden")

    response = await call_next(request)
    return response


# ── Схема запроса ─────────────────────────────────────────────────────────────
class ChartRequest(BaseModel):
    # "DD-MM-YYYY HH:MM"
    birth_datetime: str
    lat: float
    lon: float
    planets: Optional[list[str]] = None   # None = все
    aspects: Optional[list[str]] = None   # None = все

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


# ── Эндпоинт ──────────────────────────────────────────────────────────────────
@app.post("/chart")
@limiter.limit(RATE_LIMIT)
async def get_chart(request: Request, body: ChartRequest):
    try:
        start = time.time()
        birth_dt = datetime.datetime.strptime(body.birth_datetime, "%d-%m-%Y %H:%M")
        result = calculate_chart(
            birth_dt_local=birth_dt,
            lat=body.lat,
            lon=body.lon,
            requested_planets=body.planets,
            requested_aspects=body.aspects,
        )
        end = time.time()
        print(f"time: {end - start}")
        return result
    except Exception as e:
        logger.error(f"Calculation error: {e}")
        raise HTTPException(status_code=500, detail="Ошибка расчёта карты")


@app.get("/health")
async def health():
    return {"status": "ok"}
