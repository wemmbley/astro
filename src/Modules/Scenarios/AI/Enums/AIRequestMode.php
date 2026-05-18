<?php

namespace Modules\Scenarios\AI\Enums;

enum AIRequestMode: string
{
    case REST = 'rest';
    case SSE = 'sse';
}
