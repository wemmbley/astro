<?php

namespace Modules\Scenarios\AI\Exceptions;

final class AIProviderException extends \Exception
{
    public function __construct(
        public readonly int    $statusCode,
        public readonly string $cause,
        public readonly string $solution   = '',
        public readonly array  $context    = []
    ) {
        parent::__construct($this->formatMessage(), $statusCode);
    }

    private function formatMessage(): string
    {
        return "[{$this->statusCode}] {$this->cause} | Solution: {$this->solution}";
    }

    public function toArray(): array
    {
        return [
            'status_code' => $this->statusCode,
            'cause'       => $this->cause,
            'solution'    => $this->solution,
            'context'     => $this->context,
        ];
    }
}
