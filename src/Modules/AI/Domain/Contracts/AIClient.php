<?php

namespace Modules\AI\Domain\Contracts;

use Modules\AI\Domain\DTO\AIResponse;
use Modules\AI\Domain\VO\MessageBag;

interface AIClient
{
    public function generate(MessageBag $messages);
}
