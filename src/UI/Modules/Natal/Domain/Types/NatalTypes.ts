export type AspectType =
    | 'conjunction'
    | 'opposition'
    | 'sextile'
    | 'square'
    | 'trine'

export type SignType =
    | 'aries'
    | 'taurus'
    | 'gemini'
    | 'cancer'
    | 'leo'
    | 'virgo'
    | 'libra'
    | 'scorpio'
    | 'sagittarius'
    | 'capricorn'
    | 'aquarius'
    | 'pisces'

export type HouseType =
    | 'one'
    | 'two'
    | 'three'
    | 'four'
    | 'five'
    | 'six'
    | 'seven'
    | 'eight'
    | 'nine'
    | 'ten'
    | 'eleven'
    | 'twelve'

export type PlanetType =
    | 'sun'
    | 'moon'
    | 'mercury'
    | 'venus'
    | 'mars'
    | 'jupiter'
    | 'saturn'
    | 'uranus'
    | 'neptune'
    | 'pluto'
    | 'lilith'
    | 'chiron'
    | 'fortune'
    | 'north_node'
    | 'south_node'
    | 'asc'

export type Natal = {
    planets: Planet[],
    cusps: House[],
    elements: Elements,
    dominant_sign: DominantSign,
};

export type Planet = {
    name: PlanetType,
    sign: SignType,
    house: HouseType,
    aspects: Aspect[],
    longitude: string,
    degree: string,
    degreeFormatted: string,
    retrograde: boolean,
    stationary: boolean,
};

export type House = {
    house: HouseType,
    sign: SignType,
    aspects: Aspect[],
    longitude: string,
    degree: string,
    degreeFormatted: string,
}

export type Elements = {
    fire: number,
    earth: number,
    air: number,
    water: number,
}

export type Aspect = {
    name: string;
    target: string;
    orb: number;
    orbFormatted: string
};

export type DominantSign = {
    sign: SignType,
    count: number,
};
