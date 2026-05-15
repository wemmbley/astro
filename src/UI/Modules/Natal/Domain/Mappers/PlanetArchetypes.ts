import sunImage from '@/../img/Astro/Archetype/Sun.png'
import moonImage from '@/../img/Astro/Archetype/Moon.png'
import jupiterImage from '@/../img/Astro/Archetype/Jupiter.png'
import neptuneImage from '@/../img/Astro/Archetype/Neptune.png'
import plutoImage from '@/../img/Astro/Archetype/Pluto.jpg'
import uranusImage from '@/../img/Astro/Archetype/Uranus.png'
import venusImage from '@/../img/Astro/Archetype/Venus.png'
import lilithImage from '@/../img/Astro/Archetype/Lilith.png'
import mercuryImage from '@/../img/Astro/Archetype/Mercury.jpg'
import saturnImage from '@/../img/Astro/Archetype/Saturn.png'
import chironImage from '@/../img/Astro/Archetype/Chiron.png'
import marsImage from '@/../img/Astro/Archetype/Mars.png'
import astrologerImage from '@/../img/Astro/Archetype/Astrologer.png'

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
