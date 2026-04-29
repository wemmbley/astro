# Астро-расчёт Натальный.

Здесь производится ручной расчёт натальной карты на основании Swiss Ephemeris.

Разработчики постарались максимально приблизить натальный расчёт с известным сайтом astro-seek.com

# Архитектура

| Имя файла       | Предназначение       |
|-----------------|----------------------|
| `astro-core.py` | Главный движок       |
| `config.py`     | Настройки приложения |
| `server.py`     | API-сервер           |
| `backup`        | Бэкап движка         |

## Запуск

```bash
uvicorn server:app --host 0.0.0.0 --port 8020
```
Windows:
```bash
py -m uvicorn server:app --host 0.0.0.0 --port 8020
```

# Ендпоинты

## Генерация натального расчёта.

`POST localhost:8020/chart`

| Параметр             | Пример             | Значение             | Статус      |
|----------------------|--------------------|----------------------|-------------|
| `birth_datetime`     | `22-12-2000 16:30` | Точная дата рождения | Обязательно |
| `lat`                | `49.46`            | Широта               | Обязательно |
| `lon`                | `36.06`            | Долгота              | Обязательно |
| `requested_planets`  | `Sun,Moon`         | Нужные планеты       | Опционально |
| `requested_aspects`  | `Square`           | Нужные аспекты       | Опционально |

# Архитектура падений

## Python Natal Service Deployment (systemd)

Сервис FastAPI запускается под systemd для авто-перезапуска при падениях, журналирования и автозапуска после reboot.

### 1. Создать systemd unit

Создать файл:

```bash
sudo nano /etc/systemd/system/python-natal.service
```

Содержимое:

```ini
[Unit]
Description=Python Natal API
After=network.target

[Service]
User=www-data
WorkingDirectory=/opt/python-natal-server

ExecStart=/usr/bin/python3 -m uvicorn server:app --host 0.0.0.0 --port 8020 --workers 2

Restart=always
RestartSec=5

StandardOutput=append:/var/log/python-natal.log
StandardError=append:/var/log/python-natal-error.log

StartLimitBurst=10
StartLimitIntervalSec=300

[Install]
WantedBy=multi-user.target
```

---

### 2. Активировать сервис

```bash
sudo systemctl daemon-reload
sudo systemctl enable python-natal
sudo systemctl start python-natal
```

Проверить статус:

```bash
sudo systemctl status python-natal
```

---

### 3. Просмотр логов

Live logs:

```bash
journalctl -u python-natal -f
```

Crash logs:

```bash
tail -f /var/log/python-natal-error.log
```

---

### 4. Поведение при аварии

Если процесс падает:

- systemd автоматически перезапустит сервис
- задержка между рестартами 5 секунд
- после 10 падений за 5 минут сработает защита от restart loop

---

### 5. Обновление после деплоя

После изменения кода:

```bash
sudo systemctl restart python-natal
```

---

## Health Check

Сервис должен предоставлять endpoint:

```http
GET /health
```

Ожидаемый ответ:

```json
{
  "status": "ok"
}
```

Используется для мониторинга и readiness checks.

---

## Failure Logging

В приложении должен быть включен глобальный fatal exception logging через `sys.excepthook`.

Это позволяет журналировать неожиданные падения до рестарта systemd.
