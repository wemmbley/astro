<?php

namespace Modules\Scenarios\AI\Contracts;

use Modules\Scenarios\AI\ValueObjects\MessageBag;

interface AIClient
{
    public function generate(MessageBag $messages);
}
