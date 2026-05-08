# Используем slim версию для уменьшения веса, но нам понадобятся инструменты сборки
FROM python:3.11-slim

# Установка системных зависимостей для компиляции swissephe и других библиотек
RUN apt-get update && apt-get install -y --no-install-recommends \
    gcc \
    python3-dev \
    libc6-dev \
    && rm -rf /var/lib/apt/lists/*

# Создаем рабочую директорию (согласно вашей доке /opt/python-natal-server)
WORKDIR /app

# Сначала копируем только requirements, чтобы закэшировать установку библиотек
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Копируем исходный код приложения
# Убедитесь, что в папке с Dockerfile лежат: server.py, astro-core.py, config.py и т.д.
COPY . .

# Создаем логи, о которых упоминалось в документации (опционально для контейнера)
RUN touch /var/log/python-natal.log /var/log/python-natal-error.log

# Открываем порт, указанный в доке
EXPOSE 8020

# Запуск через uvicorn.
# Используем --workers 2, как было указано в вашем systemd конфиге.
CMD ["uvicorn", "server:app", "--host", "0.0.0.0", "--port", "8020", "--workers", "2"]
