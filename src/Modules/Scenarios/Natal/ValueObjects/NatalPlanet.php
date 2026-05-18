<?php

namespace Modules\Actors\Astrology\ValueObjects;

use Modules\Actors\Astrology\Containers\AspectCollection;
use Modules\Actors\Astrology\Dictionary\HouseTypes;
use Modules\Actors\Astrology\Dictionary\PlanetTypes;
use Modules\Actors\Astrology\Dictionary\SignTypes;

/**
 * Планета - это агрегат данных, внутри которого скрываются детали.
 * Она должна содержать всю базовую информацию, взятую из астро-расчёта.
 * Понадобится она в дальнейшем для интерпретаций и сырого вывода значений.
 * Заполняется она там, где есть доступ к калькулятору, в нашем случае PyClient.
 */
final readonly class NatalPlanet
{
    public function __construct(

        # Тип планеты. Например - PlanetTypes::Sun.
        public PlanetTypes $planetType,

        # Тип знака зодиака. Например - SignTypes::Capricorn.
        public SignTypes $signType,

        # Номер дома. Например - HouseTypes::Five.
        public HouseTypes $houseType,

        # Коллекция аспектов к другим планетам.
        public AspectCollection $aspects,

        # Неотформатированный градус Планеты.
        public float $rawDegree,

        # Отформатированный градус Планеты.
        public string $degreeFormatted,

        # Флаг, указывающий на ретроградность Планеты.
        public bool $retrograde,

        # Флаг, указывающий на стационарность Планеты.
        public bool $stationary,

    ) {}
}
