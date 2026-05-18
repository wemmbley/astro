<?php

namespace Modules\Actors\Astrology\Services;

use Modules\Actors\Astrology\ValueObjects\Natal;

/**
 * Сервис интерпретации натальной карты.
 *
 * Принимает в себя всю Натальную Карту пользователя, которую нужно проинтерпретировать.
 * Вторым параметром принимает в себя ключ репозитория, на интерпретации которого будем опираться.
 *
 * После чего мы можем выбрать конкретную область с помощью методов, которую необходимо проинтерпретировать.
 */
final readonly class InterpretNatalService
{
    public function __construct(
        private Natal $natal,
        private string $repoKey,
    ) {}

    /**
     * Интерпретация всей натальной карты: планеты, знаки, дома и куспиды в знаках.
     * Так же выдаёт интерпретацию всех необходимых аспектов, если есть в БД.
     *
     * @return void
     */
    public function interpretFullNatal()
    {

    }

    public function interpretPlanet()
    {
    }

    public function interpretPlanetSign()
    {
    }

    public function interpretPlanetHouse()
    {
    }

    public function interpretCuspid()
    {
    }

    public function interpretCuspidSign()
    {
    }
}
