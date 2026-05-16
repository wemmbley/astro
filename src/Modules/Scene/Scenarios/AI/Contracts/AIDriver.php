<?php

namespace Modules\Technical\Business\AI\Contracts;

use Modules\Business\AI\DTO\AIRequest;
use Modules\Business\AI\DTO\AIResponse;

interface AIDriver
{
    public function send(AIRequest $request): AIResponse;
}
