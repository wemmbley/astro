<?php

namespace Modules\AI\Infrastructure\Contracts;

use Modules\AI\Domain\DTO\AIRequest;
use Modules\AI\Domain\DTO\AIResponse;

interface AIDriver
{
    public function send(AIRequest $request): AIResponse;
}
