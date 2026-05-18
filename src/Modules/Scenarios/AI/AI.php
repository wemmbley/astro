<?php

namespace Modules\Scenarios\AI;

use App\Modules\AI\AbstractAIDriver;

class AI
{
    public function __construct(
        private AbstractAIDriver $client
    ) {}

    public function prompt(string $prompt)
    {

    }

    public function using(string $model)
    {

    }

    public function generate(string $prompt)
    {

    }

    public function stream(callable $callback): iterable
    {

    }
}
