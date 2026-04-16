import swisseph as swe
import datetime
import math
import sys
import datetime

sys.stdout.reconfigure(encoding='utf8')

def parse_arguments():
    if len(sys.argv) != 3:
        print("Usage: python script.py 'DD-MM-YYYY HH:MM' 'LAT LON'")
        sys.exit(1)

    birth_str = sys.argv[1]
    coords_str = sys.argv[2]

    # Разбираем дату и время
    try:
        birth_date = datetime.datetime.strptime(birth_str, '%d-%m-%Y %H:%M')
    except ValueError:
        print("Error: Date format must be 'DD-MM-YYYY HH:MM'")
        sys.exit(1)

    # Разбираем координаты
    try:
        lat_str, lon_str = coords_str.split()
        lat = float(lat_str)
        lon = float(lon_str)
    except Exception:
        print("Error: Coordinates format must be 'LAT LON' as floats.")
        sys.exit(1)

    return birth_date, lat, lon

def convert_to_utc(local_dt):
    """Преобразовать локальное время (EET) в UTC."""
    return local_dt - datetime.timedelta(hours=2)
    
def main():
    global year, month, day, hour, lat, lon
    
    birth_date_local, lat, lon = parse_arguments()

    # Переводим в UTC
    birth_date_utc = convert_to_utc(birth_date_local)

    # Получаем отдельные части даты
    year = birth_date_utc.year
    month = birth_date_utc.month
    day = birth_date_utc.day
    hour = birth_date_utc.hour + birth_date_utc.minute / 60  # поправил на корректное деление

    #print(f"Birth date (local, EET): {birth_date_local}")
    #print(f"Birth date (UTC): {birth_date_utc}")


if __name__ == "__main__":
    main()

    #print(f"Parsed for calculations:")
    #print(f"  Year: {year}")
    #print(f"  Month: {month}")
    #print(f"  Day: {day}")
    #print(f"  Hour: {hour:.2f}")
    #print(f"  Latitude: {lat}")
    #print(f"  Longitude: {lon}")

# Установка пути к эфемеридам
swe.set_ephe_path('./ephe')

# Дата и время рождения (в EET) — как ввёл пользователь
birth_date = datetime.datetime(year, month, day, int(hour), int((hour % 1) * 60))

# UTC-время — уже переведённое
utc_date = birth_date

# Обновляем переменные на основе UTC
year, month, day = utc_date.year, utc_date.month, utc_date.day
hour = utc_date.hour + utc_date.minute / 60

# Расчет юлианской даты
jd = swe.julday(year, month, day, hour)
jd_next = jd + 1/24  # для расчета скорости планет (1 час вперед)

# Расчет домов (Placidus)
houses, ascmc = swe.houses(jd, lat, lon)

# Куспиды домов
house_cusps = houses[:12]  # 12 домов

# Асцендент и MC (Медиум Коэли)
asc = ascmc[0]
mc = ascmc[1]

# Определение кодов планет и объектов
planet_codes = {
    "Sun": swe.SUN,
    "Moon": swe.MOON,
    "Mercury": swe.MERCURY,
    "Venus": swe.VENUS,
    "Mars": swe.MARS,
    "Jupiter": swe.JUPITER,
    "Saturn": swe.SATURN,
    "Uranus": swe.URANUS,
    "Neptune": swe.NEPTUNE,
    "Pluto": swe.PLUTO,
    "Chiron": swe.CHIRON,
    #"Pholus": swe.PHOLUS,  # Дополнительный кентавр
    #"Ceres": swe.CERES,    # Карликовая планета/астероид
    #"Pallas": swe.PALLAS,  # Астероид
    #"Juno": swe.JUNO,      # Астероид
    #"Vesta": swe.VESTA,    # Астероид
    "Lilith": swe.MEAN_APOG,  # Средняя Черная Луна
    #"True Lilith": swe.OSCU_APOG,  # Истинная Черная Луна
    #"True Node": swe.TRUE_NODE,  # Истинный Узел
    #"Mean Node": swe.MEAN_NODE,  # Средний Узел
    #"Eris": swe.AST_OFFSET + 136199,  # Карликовая планета Эрида
    #"Sedna": swe.AST_OFFSET + 90377,  # ТНО Седна
    #"Haumea": swe.AST_OFFSET + 136108,  # Карликовая планета Хаумеа
    #"Makemake": swe.AST_OFFSET + 136472,  # Карликовая планета Макемаке
    #"Quaoar": swe.AST_OFFSET + 50000,  # ТНО Квавар
    #"Orcus": swe.AST_OFFSET + 90482,  # ТНО Оркус
}

# Расчет позиций планет и их скоростей
planets = {}
planets_speed = {}
planets_decl = {}
planets_decl_speed = {}

for name, code in planet_codes.items():
    try:
        # Текущие координаты
        result = swe.calc_ut(jd, code, swe.FLG_SWIEPH)
        planets[name] = result[0][0]  # долгота
        planets_decl[name] = result[0][1]  # склонение

        # Расчет скорости для определения сходящихся/расходящихся аспектов
        result_next = swe.calc_ut(jd_next, code, swe.FLG_SWIEPH)
        planets_speed[name] = result_next[0][0] - result[0][0]
        if planets_speed[name] > 180:  # коррекция для перехода через 0°
            planets_speed[name] -= 360
        elif planets_speed[name] < -180:
            planets_speed[name] += 360

        planets_decl_speed[name] = result_next[0][1] - result[0][1]
    except:
        print(f"Не удалось рассчитать положение для {name}")

# Добавляем Асцендент и MC
planets["Ascendant"] = asc
planets["Midheaven"] = mc

# Вычисление склонения для Асцендента и MC через эклиптические координаты
def ecliptic_to_equatorial(longitude, latitude=0):
    # Наклонение эклиптики (для 2000 года)
    epsilon = 23.439291 - 0.0130042 * (year - 2000) / 100  # Учет изменения со временем
    epsilon_rad = math.radians(epsilon)
    lon_rad = math.radians(longitude)
    lat_rad = math.radians(latitude)

    # Преобразование в экваториальные координаты
    sin_decl = math.sin(lat_rad) * math.cos(epsilon_rad) + math.cos(lat_rad) * math.sin(epsilon_rad) * math.sin(lon_rad)
    decl = math.degrees(math.asin(sin_decl))
    return decl

planets_decl["Ascendant"] = ecliptic_to_equatorial(asc)
planets_decl["Midheaven"] = ecliptic_to_equatorial(mc)

# Знаки зодиака
zodiac = [
    "Овен", "Телец", "Близнецы", "Рак",
    "Лев", "Дева", "Весы", "Скорпион",
    "Стрелец", "Козерог", "Водолей", "Рыбы"
]

# Аспекты - согласно информации с astro-seek
aspects = {
    "Соединение": 0,   # Основной аспект
    "Оппозиция": 180,  # Основной аспект
    "Квадрат": 90,     # Основной аспект
    "Трин": 120,       # Основной аспект
    "Секстиль": 60,    # Особый аспект (другой орбис)
    "Полусекстиль": 30,  # Минорный аспект
    "Квинконс": 150,     # Минорный аспект
    "Полуквадрат": 45,   # Минорный аспект
    "Полутораквадрат": 135, # Минорный аспект
    "Квинтиль": 72,        # Минорный аспект
    "Биквинтиль": 144       # Минорный аспект
}

# Классификация планет для определения орбисов
luminaries = ["Sun", "Moon"]  # Светила
personal_planets = ["Mercury", "Venus", "Mars"]  # Персональные планеты
social_planets = ["Jupiter", "Saturn"]  # Социальные планеты
transpersonal_planets = ["Uranus", "Neptune", "Pluto"]  # Транс-персональные планеты
points = ["Ascendant", "Midheaven", "True Node", "Mean Node", "Lilith", "True Lilith"]  # Точки
asteroids = ["Chiron", "Ceres", "Pallas", "Juno", "Vesta", "Pholus"]  # Астероиды и кентавры
tno = ["Eris", "Sedna", "Haumea", "Makemake", "Quaoar", "Orcus"]  # TNO

# Орбисы согласно astro-seek
def get_orb(aspect_type, p1_name, p2_name):
    # Базовые орбисы согласно информации с сайта
    if aspect_type in ["Соединение", "Оппозиция", "Квадрат", "Трин"]:
        base_orb = 7.0  # 7°00' для основных аспектов
        # Увеличиваем орб до 10°, если одна из планет - светило
        if p1_name in luminaries or p2_name in luminaries:
            return 10.0
        return base_orb
    elif aspect_type == "Секстиль":
        base_orb = 4.0  # 4°00' для секстиля
        # Увеличиваем орб до 5°30', если одна из планет - светило
        if p1_name in luminaries or p2_name in luminaries:
            return 5.5
        return base_orb
    else:  # Все минорные аспекты
        return 2.5  # 2°30' фиксированный орб для минорных аспектов

# Орбис для параллелей и контрпараллелей (согласно информации с сайта)
parallel_orb = 1.2  # 1°12' для параллелей и контрпараллелей

def get_sign(deg):
    index = int(deg // 30) % 12
    deg_in_sign = deg % 30
    return zodiac[index], deg_in_sign

def get_house(deg):
    for i in range(12):
        start = house_cusps[i]
        end = house_cusps[(i + 1) % 12]
        if start < end:
            if start <= deg < end:
                return i + 1
        else:  # через 360 переход
            if deg >= start or deg < end:
                return i + 1
    return None

def is_applying(p1_lon, p2_lon, p1_speed, p2_speed, aspect_angle):
    # Определение, является ли аспект сходящимся или расходящимся
    # Сначала нормализуем разницу между планетами
    angle_diff = (p2_lon - p1_lon) % 360
    if angle_diff > 180:
        angle_diff -= 360

    # Вычисляем разницу между текущим углом и идеальным аспектом
    aspect_diff = abs(abs(angle_diff) - aspect_angle)

    # Вычисляем относительную скорость
    relative_speed = p2_speed - p1_speed

    # Проверяем, уменьшается ли разница между углами
    if aspect_angle == 0:  # Соединение
        if abs(angle_diff) <= 180:
            return (angle_diff > 0 and relative_speed < 0) or (angle_diff < 0 and relative_speed > 0)
    elif aspect_angle == 180:  # Оппозиция
        target_diff = 180
        closing = (angle_diff > 0 and angle_diff < target_diff and relative_speed > 0) or \
                 (angle_diff < 0 and angle_diff > -target_diff and relative_speed < 0)
        return closing
    else:  # Другие аспекты
        # Определяем, приближается ли угол к идеальному аспекту
        # Вычисляем, какой будет разница через небольшой промежуток времени
        future_angle_diff = angle_diff + relative_speed * 0.01
        future_aspect_diff = abs(abs(future_angle_diff) - aspect_angle)

        # Если будущая разница меньше текущей, аспект сходящийся
        return future_aspect_diff < aspect_diff

def get_aspect_details(p1_lon, p2_lon, p1_speed, p2_speed, aspect_name):
    aspect_angle = aspects[aspect_name]

    # Вычисляем точную разницу от идеального аспекта
    angle_diff = (p2_lon - p1_lon) % 360
    if angle_diff > 180:
        angle_diff -= 360

    orb_exact = abs(abs(angle_diff) - aspect_angle)

    # Определяем, сходящийся или расходящийся
    applying = is_applying(p1_lon, p2_lon, p1_speed, p2_speed, aspect_angle)

    return orb_exact, "сходящийся" if applying else "расходящийся"

def get_aspect(p1_lon, p2_lon, p1_name, p2_name):
    results = []

    for aspect_name, aspect_angle in aspects.items():
        # Получаем орбис для данного аспекта и пары планет
        orb = get_orb(aspect_name, p1_name, p2_name)

        # Вычисляем разницу между планетами
        delta = abs(p1_lon - p2_lon) % 360
        delta = min(delta, 360 - delta)

        # Проверяем, находится ли разница в пределах орбиса
        if abs(delta - aspect_angle) <= orb:
            # Получаем детали аспекта
            orb_exact, applying_status = get_aspect_details(
                p1_lon, p2_lon,
                planets_speed.get(p1_name, 0),
                planets_speed.get(p2_name, 0),
                aspect_name
            )

            results.append((aspect_name, orb_exact, applying_status))

    return results

def get_parallel_aspects(decl1, decl2, name1, name2):
    # Проверяем параллели и контрпараллели
    results = []

    # Если знаки склонений одинаковые - проверяем на параллель
    if (decl1 > 0 and decl2 > 0) or (decl1 < 0 and decl2 < 0):
        if abs(abs(decl1) - abs(decl2)) <= parallel_orb:
            # Определяем, сходящийся или расходящийся
            speed1 = planets_decl_speed.get(name1, 0)
            speed2 = planets_decl_speed.get(name2, 0)

            # Аспект сходящийся, если склонения сближаются
            future_diff = abs(abs(decl1 + speed1*0.01) - abs(decl2 + speed2*0.01))
            current_diff = abs(abs(decl1) - abs(decl2))
            applying = future_diff < current_diff

            orb_exact = abs(abs(decl1) - abs(decl2))
            results.append(("Параллель", orb_exact, "сходящийся" if applying else "расходящийся"))

    # Если знаки склонений разные - проверяем на контрпараллель
    elif (decl1 > 0 and decl2 < 0) or (decl1 < 0 and decl2 > 0):
        if abs(abs(decl1) - abs(decl2)) <= parallel_orb:
            # Определяем, сходящийся или расходящийся
            speed1 = planets_decl_speed.get(name1, 0)
            speed2 = planets_decl_speed.get(name2, 0)

            # Для контрпараллели сближение происходит, когда разные склонения становятся ближе по модулю
            future_diff = abs(abs(decl1 + speed1*0.01) - abs(decl2 + speed2*0.01))
            current_diff = abs(abs(decl1) - abs(decl2))
            applying = future_diff < current_diff

            orb_exact = abs(abs(decl1) - abs(decl2))
            results.append(("Контрпараллель", orb_exact, "сходящийся" if applying else "расходящийся"))

    return results

# Форматирование угла в градусы, минуты
def format_angle(degrees):
    d = int(degrees)
    m = int((degrees - d) * 60)
    return f"{d}°{m:02d}'"

# Вывод данных
#print("=" * 50)
#print(f"Астрологическая карта для: {birth_date} (EET)")
#print(f"Время по UTC: {utc_date}")
#print(f"Координаты: {format_angle(lat)} с.ш., {format_angle(lon)} в.д.")
#print("=" * 50)

# Порядок вывода планет
planet_order = [
    "Ascendant", "Midheaven", "Sun", "Moon", "Mercury",
    "Venus", "Mars", "Jupiter", "Saturn", "Uranus",
    "Neptune", "Pluto", "Mean Node", "Lilith", "Chiron",
    # Дополнительные объекты
    "True Node", "True Lilith", "Ceres", "Pallas", "Juno",
    "Vesta", "Pholus", "Eris", "Sedna", "Haumea",
    "Makemake", "Quaoar", "Orcus"
]

# Переводим названия на русский
planet_names_ru = {
    "Ascendant": "АСЦЕНДЕНТ",
    "Midheaven": "МЕДИУМ КОЭЛИ",
    "Sun": "СОЛНЦЕ",
    "Moon": "ЛУНА",
    "Mercury": "МЕРКУРИЙ",
    "Venus": "ВЕНЕРА",
    "Mars": "МАРС",
    "Jupiter": "ЮПИТЕР",
    "Saturn": "САТУРН",
    "Uranus": "УРАН",
    "Neptune": "НЕПТУН",
    "Pluto": "ПЛУТОН",
    "True Node": "ИСТИННЫЙ СЕВЕРНЫЙ УЗЕЛ",
    "Mean Node": "СЕВЕРНЫЙ УЗЕЛ",  # Astro-seek использует средний узел по умолчанию
    "Lilith": "ЧЕРНАЯ ЛУНА (ЛИЛИТ)",
    "True Lilith": "ИСТИННАЯ ЧЕРНАЯ ЛУНА",
    "Chiron": "ХИРОН",
    "Ceres": "ЦЕРЕРА",
    "Pallas": "ПАЛЛАДА",
    "Juno": "ЮНОНА",
    "Vesta": "ВЕСТА",
    "Pholus": "ФОЛУС",
    "Eris": "ЭРИДА",
    "Sedna": "СЕДНА",
    "Haumea": "ХАУМЕА",
    "Makemake": "МАКЕМАКЕ",
    "Quaoar": "КВАВАР",
    "Orcus": "ОРКУС"
}

# Вывод данных для каждой планеты
def analyze_planets(planets, planets_decl, output_format='cli'):
    result = {}

    for planet_name in planet_order:
        if planet_name not in planets:
            continue

        deg = planets[planet_name]
        sign, deg_in_sign = get_sign(deg)
        house = get_house(deg)

        if output_format == 'cli':
            print(f"\n{planet_names_ru[planet_name]}:")
            print(f"  Знак: {sign} {deg_in_sign:.2f}° ({format_angle(deg_in_sign)})")
            print(f"  Дом: {house}")
            print("  Аспекты:")

        planet_data = {
            "sign": {
                "name": sign,
                "degree": round(deg_in_sign, 2),
                "formatted": format_angle(deg_in_sign)
            },
            "house": house,
            "aspects": []
        }

        has_aspect = False

        for other_name in planets:
            if other_name != planet_name:
                other_deg = planets[other_name]

                aspects_list = get_aspect(deg, other_deg, planet_name, other_name)

                if aspects_list:
                    for aspect_name, orb_exact, applying in aspects_list:
                        aspect_entry = {
                            "type": aspect_name,
                            "target": planet_names_ru.get(other_name, other_name),
                            "orb": round(orb_exact, 2),
                            "applying": applying
                        }
                        planet_data["aspects"].append(aspect_entry)

                        if output_format == 'cli':
                            print(f"    - {aspect_name} {aspect_entry['target']} ({aspect_entry['orb']:.2f}°, {applying})")
                        has_aspect = True

                # Параллели/контрпараллели
                if planet_name in planets_decl and other_name in planets_decl:
                    decl1 = planets_decl[planet_name]
                    decl2 = planets_decl[other_name]

                    parallel_aspects = get_parallel_aspects(decl1, decl2, planet_name, other_name)

                    if parallel_aspects:
                        for aspect_name, orb_exact, applying in parallel_aspects:
                            aspect_entry = {
                                "type": aspect_name,
                                "target": planet_names_ru.get(other_name, other_name),
                                "orb": round(orb_exact, 2),
                                "applying": applying
                            }
                            planet_data["aspects"].append(aspect_entry)

                            if output_format == 'cli':
                                print(f"    - {aspect_name} {aspect_entry['target']} ({aspect_entry['orb']:.2f}°, {applying})")
                            has_aspect = True

        if not has_aspect and output_format == 'cli':
            print("    - Нет значимых аспектов")

        result[planet_name] = planet_data

    if output_format == 'json':
        import json
        print(json.dumps(result, ensure_ascii=False, indent=2))

analyze_planets(planets, planets_decl, output_format='json')

# print("\n" + "=" * 50)
# print("Примечания:")
# print("1. Сходящийся аспект: планеты движутся к точному аспекту")
# print("2. Расходящийся аспект: планеты удаляются от точного аспекта")
# print("3. Орбис указан в градусах отклонения от точного аспекта")
# print("4. Используются орбисы по умолчанию согласно astro-seek.com:")
# print("   - Основные аспекты (0°, 90°, 120°, 180°): 7° / 10° для светил")
# print("   - Секстиль (60°): 4° / 5°30' для светил")
# print("   - Минорные аспекты: 2°30'")
# print("   - Параллели и контрпараллели: 1°12'")
# print("=" * 50)
#
# # Отладочная информация для сравнения с astro-seek
# if "True Node" in planets_decl and "Ascendant" in planets_decl and "Sun" in planets_decl:
#     node_decl = planets_decl["True Node"]
#     asc_decl = planets_decl["Ascendant"]
#     sun_decl = planets_decl["Sun"]
#     moon_decl = planets_decl["Moon"]
#
#     print("\nОтладочная информация:")
#     print(f"Склонение Истинного Узла: {node_decl:.4f}°")
#     print(f"Склонение Асцендента: {asc_decl:.4f}°")
#     print(f"Склонение Солнца: {sun_decl:.4f}°")
#     print(f"Склонение Луны: {moon_decl:.4f}°")
#
#     print(f"Разница склонений Узел-Асцендент: {abs(abs(node_decl) - abs(asc_decl)):.4f}°")
#     print(f"Разница склонений Узел-Солнце: {abs(abs(node_decl) - abs(sun_decl)):.4f}°")
#     print(f"Разница склонений Узел-Луна: {abs(abs(node_decl) - abs(moon_decl)):.4f}°")