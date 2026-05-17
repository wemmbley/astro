<?php

namespace Modules\Scenarios\Equilibrium;

/**
 * Таблица соотношений Эквилибриума к действиям.
 */
enum EquilibriumPricing: int
{
    # Цена за интерпретацию всей Натальной Карты.
    case NATAL_FULL_AI_INTERPRET = 124;

    # Цена за интерпретацию одной планеты.
    case PLANET_AI_INTERPRET = 58;

    # Цена за отправку смс АИ в открытом диалоге.
    case AI_MESSAGE_RESEND = 49;

}
