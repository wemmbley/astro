<?php

namespace Modules\AI\Infrastructure\Drivers\DeepSeek\Enums;

enum DeepSeekTemperature: string
{
    case CODING_OR_MATH = '0.0';
    case DATA_CLEAN_ANALYSIS = '1.0';
    case GENERAL_CONVERSATION_OR_TRANSLATION = '1.3';
    case CREATIVE_WRITING_POETRY = '1.5';
}
