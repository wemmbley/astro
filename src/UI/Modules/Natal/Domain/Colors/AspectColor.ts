const ASPECT_COLOR: Record<string, string> = {
    conjunction:    '#3b82f6', // слияние в чистом свете, начало цикла
    opposition:     '#c23c3c', // противостояние, столкновение двух истин
    square:         '#c23c3c', // трение, высекающее искру действия
    trine:          '#eebe21', // природная лёгкость, дар потока
    sextile:        '#eebe21', // свежий ветер возможностей
    semisquare:     '#c23c3c', // назойливый зуд, требующий внимания
    sesquiquadrate: '#c23c3c', // застарелое напряжение, подтачивающее изнутри
    quincunx:       '#ba54ee', // иррациональная нестыковка, вынужденная адаптация
    quintile:       '#3b82f6', // творческая искра, игра ума
    biquintile:     '#3b82f6', // оформленный талант, двойная квинтэссенция
    semisextile:    '#9ca3af', // едва заметная связь, требующая осознанности
    parallel:       '#3b82f6', // глубинный резонанс, подобный соединению на уровне склонения
    contraparallel: '#c23c3c', // скрытое противостояние, подобное оппозиции
};

export function getAspectColor(name: string): string
{
    return ASPECT_COLOR.name;
}
