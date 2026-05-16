<?php

namespace Modules\Technical\Business\Natal\Http\PyClient;

use Modules\Business\Natal\ValueObjects\DominantSign;
use Modules\Business\Natal\ValueObjects\Natal;
use Modules\Esoteric\Astrology\Containers\HouseContainer;
use Modules\Esoteric\Astrology\Containers\PlanetContainer;
use Modules\Esoteric\Astrology\ValueObjects\Aspect;
use Modules\Esoteric\Astrology\ValueObjects\AspectTo;
use Modules\Esoteric\Astrology\ValueObjects\House;
use Modules\Natal\Domain\Containers\AspectCollection;
use Modules\Natal\Domain\Containers\Elements;
use Modules\Natal\Domain\Dictionary\AspectName;
use Modules\Natal\Domain\Dictionary\HouseName;
use Modules\Natal\Domain\Dictionary\HouseSystemName;
use Modules\Natal\Domain\Dictionary\PlanetName;
use Modules\Natal\Domain\Dictionary\SignName;
use Modules\Natal\Domain\Entity\Organisms\Planet;

final readonly class PythonResponseMapper
{
    public static function map(array $payload): Natal
    {
        return new Natal(
            planets:        self::mapPlanets( $payload['planets'] ),
            houses:         self::mapHouses( $payload['houses'] ),
            elements:       self::mapElements( $payload['alchemy']['elements'] ),
            dominantSign:   self::mapDominantSign( $payload['alchemy']['dominant_sign'] ),
            houseSystem:    HouseSystemName::Placidius,
        );
    }

    private static function mapPlanets(array $items): PlanetContainer
    {
        $planets = [];

        foreach ($items as $name => $body) {
            $planets[] = new Planet(
                name:               self::mapPlanet( $name ),
                sign:               self::mapSign( $body['sign']['name'] ),
                house:              self::mapHouse( (int) $body['house'] ),
                aspects:            self::mapAspects( $body['aspects'] ?? [] ),
                longitude:          (float) ( $body['longitude'] ?? 0 ),
                degree:             (float) $body['sign']['degree'],
                degreeFormatted:    (string) $body['sign']['formatted'],
                retrograde:         (bool) ( $body['retrograde'] ?? false ),
                stationary:         ( $body['motion'] === 'stationary' ?? false ),
            );
        }

        return new PlanetContainer(...$planets);
    }

    private static function mapHouses(array $items): HouseContainer
    {
        $houses = [];

        foreach ($items as $name => $body) {
            preg_match('/House(\d+)/', $name, $match);

            $number = (int)$match[1];

            $houses[] = new House(
                house:              self::mapHouse($number),
                sign:               self::mapSign( $body['sign']['name'] ),
                aspects:            self::mapAspects( $body['aspects'] ?? [] ),
                degree:             (float) $body['sign']['degree'],
                degreeFormatted:    (string) $body['sign']['formatted'],
                longitude:          (float) $body['cusp_longitude'],
            );
        }

        return new HouseContainer(...$houses);
    }

    private static function mapElements(array $elements): Elements
    {
        return new Elements(
            fire:   (int) ( $elements['Fire'] ?? 0 ),
            earth:  (int) ( $elements['Earth'] ?? 0 ),
            air:    (int) ( $elements['Air'] ?? 0 ),
            water:  (int) ( $elements['Water'] ?? 0 ),
        );
    }

    private static function mapAspects(array $items): AspectCollection
    {
        $aspects = [];

        foreach ($items as $item) {
            $aspects[] = new Aspect(
                name:         self::mapAspect( $item['type'] ),
                target:       self::mapAspectTarget( $item['target'] ),
                orb:          (float) $item['orb'],
                orbFormatted: (string) $item['orb_fmt'],
            );
        }

        return new AspectCollection(...$aspects);
    }

    private static function mapAspect(string $aspect): AspectName
    {
        return match ($aspect) {
            'Conjunction'       => AspectName::Conjunction,
            'Square'            => AspectName::Square,
            'Opposition'        => AspectName::Opposition,
            'Trine'             => AspectName::Trine,
            'Sextile'           => AspectName::Sextile,
            'Semisquare'        => AspectName::Semisquare,
            'Sesquiquadrate'    => AspectName::Sesquiquadrate,
            'Contraparallel'    => AspectName::Contraparallel,
            'Parallel'          => AspectName::Parallel,
            'Quincunx'          => AspectName::Quincunx,
            'Quintile'          => AspectName::Quintile,
            'Biquintile'        => AspectName::Biquintile,
            'Semisextile'       => AspectName::Semisextile,

            default => throw new \DomainException("Unknown aspect {$aspect}")
        };
    }

    private static function mapAspectTarget(string $target): AspectTo
    {
        if (str_starts_with($target, 'House')) {

            preg_match('/House(\d+)/', $target, $match);

            if (!isset($match[1])) {
                throw new \DomainException("Invalid house target: {$target}");
            }

            return new AspectTo(
                self::mapHouse((int) $match[1])
            );
        }

        return new AspectTo(
            self::mapPlanet($target)
        );
    }

    private static function mapPlanet(string $planet): PlanetName
    {
        return match ($planet) {
            'Sun'       => PlanetName::Sun,
            'Moon'      => PlanetName::Moon,
            'Mercury'   => PlanetName::Mercury,
            'Venus'     => PlanetName::Venus,
            'Mars'      => PlanetName::Mars,
            'Jupiter'   => PlanetName::Jupiter,
            'Saturn'    => PlanetName::Saturn,
            'Uranus'    => PlanetName::Uranus,
            'Neptune'   => PlanetName::Neptune,
            'Pluto'     => PlanetName::Pluto,
            'NorthNode' => PlanetName::NorthNode,
            'SouthNode' => PlanetName::SouthNode,
            'Lilith'    => PlanetName::Lilith,
            'Chiron'    => PlanetName::Chiron,
            'Fortune'   => PlanetName::Fortune,

            default =>
                throw new \DomainException( "Unknown planet {$planet}" )
        };
    }

    private static function mapSign(string $sign): SignName
    {
        return SignName::from( strtolower( $sign ) );
    }

    private static function mapDominantSign(array $sign): DominantSign
    {
        $dominantSignName = SignName::from( strtolower( $sign['sign'] ) );
        $dominantSign = new DominantSign(
            signName: $dominantSignName,
            count: $sign['count']
        );

        return $dominantSign;
    }

    private static function mapHouse(int $house): HouseName
    {
        return match($house) {
            1   => HouseName::One,
            2   => HouseName::Two,
            3   => HouseName::Three,
            4   => HouseName::Four,
            5   => HouseName::Five,
            6   => HouseName::Six,
            7   => HouseName::Seven,
            8   => HouseName::Eight,
            9   => HouseName::Nine,
            10  => HouseName::Ten,
            11  => HouseName::Eleven,
            12  => HouseName::Twelve,
        };
    }
}
