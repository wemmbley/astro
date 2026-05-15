<?php

namespace Modules\AI\Domain\Enums;

enum AIRequestMode: string
{
    case REST = 'rest';
    case SSE = 'sse';
}
