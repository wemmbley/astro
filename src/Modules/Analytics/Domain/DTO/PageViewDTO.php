<?php

namespace Modules\Analytics\Domain\DTO;

final readonly class PageViewDTO
{
    public function __construct(
        public string  $ip,
        public string  $url,
        public string  $fingerprint,
        public ?int    $userId,
        public ?string $utmSource,
        public ?string $utmMedium,
        public ?string $utmCampaign,
    ) {}
}
