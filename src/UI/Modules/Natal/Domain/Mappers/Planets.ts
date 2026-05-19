import sunImage from '@/Resources/Assets/Astrology/PlanetArts/Sun.jpg'
import moonImage from '@/Resources/Assets/Astrology/PlanetArts/Moon.png'
import jupiterImage from '@/Resources/Assets/Astrology/PlanetArts/Jupiter.png'
import neptuneImage from '@/Resources/Assets/Astrology/PlanetArts/Neptune.png'
import northNodeImage from '@/Resources/Assets/Astrology/PlanetArts/NorthNode.png'
import southNodeImage from '@/Resources/Assets/Astrology/PlanetArts/SouthNode.png'
import plutoImage from '@/Resources/Assets/Astrology/PlanetArts/Pluto.jpg'
import uranusImage from '@/Resources/Assets/Astrology/PlanetArts/Uranus.png'
import venusImage from '@/Resources/Assets/Astrology/PlanetArts/Venus.png'
import lilithImage from '@/Resources/Assets/Astrology/PlanetArts/Lilith.png'
import mercuryImage from '@/Resources/Assets/Astrology/PlanetArts/Mercury.jpg'
import fortuneImage from '@/Resources/Assets/Astrology/PlanetArts/Fortune.png'
import saturnImage from '@/Resources/Assets/Astrology/PlanetArts/Saturn.png'
import chironImage from '@/Resources/Assets/Astrology/PlanetArts/Chiron.png'
import marsImage from '@/Resources/Assets/Astrology/PlanetArts/Mars.png'

const IMAGE_NAME_MAPPER: Record<string, string> = {
    sun: sunImage,
    moon: moonImage,
    jupiter: jupiterImage,
    neptune: neptuneImage,
    north_node: northNodeImage,
    south_node: southNodeImage,
    pluto: plutoImage,
    uranus: uranusImage,
    venus: venusImage,
    lilith: lilithImage,
    mercury: mercuryImage,
    fortune: fortuneImage,
    saturn: saturnImage,
    chiron: chironImage,
    mars: marsImage,
}

export function getPlanetImage(name: string)
{
    return IMAGE_NAME_MAPPER[name];
}
