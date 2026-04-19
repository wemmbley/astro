<?php

namespace App\Modules\AI\Infrastructure\Contracts;

use App\Modules\AI\Domain\DTO\AIRequest;
use App\Modules\AI\Domain\DTO\AIResponse;

interface AIDriver
{
    public function send(AIRequest $request): AIResponse;
}
