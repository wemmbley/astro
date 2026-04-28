<?php

namespace app\Modules\AI\Infrastructure\Drivers\DeepSeek\Enums;

enum DeepSeekRoles: string
{
    case ASTROLOG = 'system-astrolog';
    case CLIENT = 'user';
}
