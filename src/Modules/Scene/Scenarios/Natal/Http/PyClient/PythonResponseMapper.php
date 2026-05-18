<?php

namespace Modules\Scene\Scenarios\Natal\Http\PyClient;

use Modules\Actors\Astrology\Containers\AspectContainer;
use Modules\Actors\Astrology\Containers\ElementContainer;
use Modules\Actors\Astrology\Types\AspectType;
use Modules\Actors\Astrology\Types\HouseType;
use Modules\Actors\Astrology\Types\PlanetType;
use Modules\Actors\Astrology\Types\SignType;
use Modules\Actors\Astrology\Containers\HouseContainer;
use Modules\Actors\Astrology\Containers\PlanetContainer;
use Modules\Actors\Astrology\ValueObjects\Aspect;
use Modules\Actors\Astrology\ValueObjects\AspectTo;
use Modules\Actors\Astrology\ValueObjects\House;
use Modules\Actors\Astrology\ValueObjects\Planet;
use Modules\Scenarios\Natal\Types\HouseSystemTypes;
use Modules\Scenarios\Natal\ValueObjects\DominantSign;
use Modules\Scenarios\Natal\ValueObjects\Natal;

final readonly class PythonResponseMapper
{
    public static function map(array $payload): Natal
    {
        return new Natal(
            planets:        self::mapPlanets( $payload['planets'] ),
            houses:         self::mapHouses( $payload['houses'] ),
            elements:       self::mapElements( $payload['alchemy']['elements'] ),
            dominantSign:   self::mapDominantSign( $payload['alchemy']['dominant_sign'] ),
            houseSystem:    HouseSystemTypes::Placidius,
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

    private static function mapElements(array $elements): ElementContainer
    {
        return new ElementContainer(
            fire:   (int) ( $elements['Fire'] ?? 0 ),
            earth:  (int) ( $elements['Earth'] ?? 0 ),
            air:    (int) ( $elements['Air'] ?? 0 ),
            water:  (int) ( $elements['Water'] ?? 0 ),
        );
    }

    private static function mapAspects(array $items): AspectContainer
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

        return new AspectContainer(...$aspects);
    }

    private static function mapAspect(string $aspect): AspectType
    {
        return match ($aspect) {
            'Conjunction'       => AspectType::Conjunction,
            'Square'            => AspectType::Square,
            'Opposition'        => AspectType::Opposition,
            'Trine'             => AspectType::Trine,
            'Sextile'           => AspectType::Sextile,
            'Semisquare'        => AspectType::Semisquare,
            'Sesquiquadrate'    => AspectType::Sesquiquadrate,
            'Contraparallel'    => AspectType::Contraparallel,
            'Parallel'          => AspectType::Parallel,
            'Quincunx'          => AspectType::Quincunx,
            'Quintile'          => AspectType::Quintile,
            'Biquintile'        => AspectType::Biquintile,
            'Semisextile'       => AspectType::Semisextile,

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

    private static function mapPlanet(string $planet): PlanetType
    {
        return match ($planet) {
            'Sun'       => PlanetType::Sun,
            'Moon'      => PlanetType::Moon,
            'Mercury'   => PlanetType::Mercury,
            'Venus'     => PlanetType::Venus,
            'Mars'      => PlanetType::Mars,
            'Jupiter'   => PlanetType::Jupiter,
            'Saturn'    => PlanetType::Saturn,
            'Uranus'    => PlanetType::Uranus,
            'Neptune'   => PlanetType::Neptune,
            'Pluto'     => PlanetType::Pluto,
            'NorthNode' => PlanetType::NorthNode,
            'SouthNode' => PlanetType::SouthNode,
            'Lilith'    => PlanetType::Lilith,
            'Chiron'    => PlanetType::Chiron,
            'Fortune'   => PlanetType::Fortune,

            default =>
                throw new \DomainException( "Unknown planet {$planet}" )
        };
    }

    private static function mapSign(string $sign): SignType
    {
        return SignType::from( strtolower( $sign ) );
    }

    private static function mapDominantSign(array $sign): DominantSign
    {
        $dominantSignName = SignType::from( strtolower( $sign['sign'] ) );
        $dominantSign = new DominantSign(
            signName: $dominantSignName,
            count: $sign['count']
        );

        return $dominantSign;
    }

    private static function mapHouse(int $house): HouseType
    {
        return match($house) {
            1   => HouseType::One,
            2   => HouseType::Two,
            3   => HouseType::Three,
            4   => HouseType::Four,
            5   => HouseType::Five,
            6   => HouseType::Six,
            7   => HouseType::Seven,
            8   => HouseType::Eight,
            9   => HouseType::Nine,
            10  => HouseType::Ten,
            11  => HouseType::Eleven,
            12  => HouseType::Twelve,
        };
    }
}
