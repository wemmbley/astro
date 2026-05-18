<?php

namespace Modules\Scene\Scenarios\AI\Contracts;

use Modules\Scenarios\AI\DTO\AIRequest;
use Modules\Scenarios\AI\DTO\AIResponse;

interface AIDriver
{
    public function send(AIRequest $request): AIResponse;
}
