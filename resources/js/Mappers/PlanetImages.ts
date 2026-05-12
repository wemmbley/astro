import sunImage from '@/../img/Astro/PlanetArts/Sun.jpg'
import moonImage from '@/../img/Astro/PlanetArts/Moon.png'
import jupiterImage from '@/../img/Astro/PlanetArts/Jupiter.png'
import neptuneImage from '@/../img/Astro/PlanetArts/Neptune.png'
import northNodeImage from '@/../img/Astro/PlanetArts/NorthNode.jpg'
import southNodeImage from '@/../img/Astro/PlanetArts/SouthNode.jpg'
import plutoImage from '@/../img/Astro/PlanetArts/Pluto.jpg'
import uranusImage from '@/../img/Astro/PlanetArts/Uranus.png'
import venusImage from '@/../img/Astro/PlanetArts/Venus.png'
import lilithImage from '@/../img/Astro/PlanetArts/Lilith.png'
import mercuryImage from '@/../img/Astro/PlanetArts/Mercury.jpg'
import fortuneImage from '@/../img/Astro/PlanetArts/Fortune.png'
import saturnImage from '@/../img/Astro/PlanetArts/Saturn.png'
import chironImage from '@/../img/Astro/PlanetArts/Chiron.png'
import marsImage from '@/../img/Astro/PlanetArts/Mars.png'

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
