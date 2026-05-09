import type {
    AspectType,
    SignType,
    HouseType,
    PlanetType,
} from '@/Types/NatalTypes'

export const aspectTranslations: Record<AspectType, string> = {
    conjunction: 'Соединение',
    opposition: 'Оппозиция',
    sextile: 'Секстиль',
    square: 'Квадрат',
    trine: 'Трин',
}

export const signTranslations: Record<SignType, string> = {
    aries: 'Овен',
    taurus: 'Телец',
    gemini: 'Близнецы',
    cancer: 'Рак',
    leo: 'Лев',
    virgo: 'Дева',
    libra: 'Весы',
    scorpio: 'Скорпион',
    sagittarius: 'Стрелец',
    capricorn: 'Козерог',
    aquarius: 'Водолей',
    pisces: 'Рыбы',
}

export const houseTranslations: Record<HouseType, string> = {
    one: '1 дом',
    two: '2 дом',
    three: '3 дом',
    four: '4 дом',
    five: '5 дом',
    six: '6 дом',
    seven: '7 дом',
    eight: '8 дом',
    nine: '9 дом',
    ten: '10 дом',
    eleven: '11 дом',
    twelve: '12 дом',
}

export const planetTranslations: Record<PlanetType, string> = {
    sun: 'Солнце',
    moon: 'Луна',
    mercury: 'Меркурий',
    venus: 'Венера',
    mars: 'Марс',
    jupiter: 'Юпитер',
    saturn: 'Сатурн',
    uranus: 'Уран',
    neptune: 'Нептун',
    pluto: 'Плутон',
    lilith: 'Лилит',
    chiron: 'Хирон',
    fortune: 'Парс Фортуны',
    north_node: 'Северный узел',
    south_node: 'Южный узел',
}
