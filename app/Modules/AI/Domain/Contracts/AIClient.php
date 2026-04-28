<?php

namespace App\Modules\AI\Domain\Contracts;

use App\Modules\AI\Domain\DTO\AIResponse;
use App\Modules\AI\Domain\VO\MessageBag;

interface AIClient
{
    public function generate(MessageBag $messages);
}
