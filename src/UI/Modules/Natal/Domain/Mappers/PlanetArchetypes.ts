import sunImage from '@/Resources/Assets/Astrology/Archetype/Sun.png'
import moonImage from '@/Resources/Assets/Astrology/Archetype/Moon.png'
import jupiterImage from '@/Resources/Assets/Astrology/Archetype/Jupiter.png'
import neptuneImage from '@/Resources/Assets/Astrology/Archetype/Neptune.png'
import plutoImage from '@/Resources/Assets/Astrology/Archetype/Pluto.jpg'
import uranusImage from '@/Resources/Assets/Astrology/Archetype/Uranus.png'
import venusImage from '@/Resources/Assets/Astrology/Archetype/Venus.png'
import lilithImage from '@/Resources/Assets/Astrology/Archetype/Lilith.png'
import mercuryImage from '@/Resources/Assets/Astrology/Archetype/Mercury.jpg'
import saturnImage from '@/Resources/Assets/Astrology/Archetype/Saturn.png'
import chironImage from '@/Resources/Assets/Astrology/Archetype/Chiron.png'
import marsImage from '@/Resources/Assets/Astrology/Archetype/Mars.png'
import astrologerImage from '@/Resources/Assets/Astrology/Archetype/Astrologer.png'

const IMAGE_NAME_MAPPER: Record<string, string> = {
    sun: sunImage,
    moon: moonImage,
    jupiter: jupiterImage,
    neptune: neptuneImage,
    pluto: plutoImage,
    uranus: uranusImage,
    venus: venusImage,
    lilith: lilithImage,
    mercury: mercuryImage,
    saturn: saturnImage,
    chiron: chironImage,
    mars: marsImage,
    astrologer: astrologerImage,
}

export function getPlanetArchetypeImage(name: string)
{
    return IMAGE_NAME_MAPPER[name];
}
