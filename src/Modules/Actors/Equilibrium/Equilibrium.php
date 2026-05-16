<?php

namespace Modules\Actors\Equilibrium;

use InvalidArgumentException;

/**
 * Эквилибриум - энергия взаимного энергообмена.
 *
 * Это плата за доступ к энергии.
 * При низком пороге Эквилибриума нарушается сама структура Эквилибриума.
 * Эквилибриум есть баланс-равновесие.
 *
 * На сцене Эквилибриум духовно привязан к котировкам Ethereum в соотношении 1:1000.
 * Если Ethereum на сценах котируется в "95 979,32 UAH", то это эквивалентно "95,97932 EQB".
 */
readonly class Equilibrium
{
    /**
     * Храним энергию в минимальных неделимых квантах,
     * чтобы избежать энтропии и искажений при делении.
     */
    private function __construct(
        private int $quanta
    ) {}

    /**
     * Проявление Эквилибриума из определенного объема квантов энергии.
     */
    public static function fromQuanta(int $quanta): self
    {
        if ($quanta < 0) {
            throw new InvalidArgumentException(
                "Эквилибриум не может уходить в отрицательную энтропию."
            );
        }

        return new self($quanta);
    }

    /**
     * Возвращает чистое количество энергии.
     */
    public function getQuanta(): int
    {
        return $this->quanta;
    }

    /**
     * Проверка: достаточно ли текущего уровня Эквилибриума для преодоления порога.
     */
    public function satisfies(self $threshold): bool
    {
        return $this->quanta >= $threshold->getQuanta();
    }

    /**
     * Поглощение энергии.
     * Возвращает новый Актор Эквилибриума, сохраняя неизменяемость Абсолюта.
     */
    public function take(self $requiredEnergy): self
    {
        if (!$this->satisfies($requiredEnergy)) {
            throw new InvalidArgumentException(
                "Нарушение структуры Эквилибриума: недостаточно потенциала для обмена энергией."
            );
        }

        return new self($this->quanta - $requiredEnergy->getQuanta());
    }
}
