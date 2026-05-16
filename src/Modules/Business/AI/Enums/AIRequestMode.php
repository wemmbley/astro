<?php

namespace Modules\Business\AI\Enums;

enum AIRequestMode: string
{
    case REST = 'rest';
    case SSE = 'sse';
}
