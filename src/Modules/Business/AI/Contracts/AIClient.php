<?php

namespace Modules\Business\AI\Contracts;

use Modules\Business\AI\ValueObjects\MessageBag;

interface AIClient
{
    public function generate(MessageBag $messages);
}
