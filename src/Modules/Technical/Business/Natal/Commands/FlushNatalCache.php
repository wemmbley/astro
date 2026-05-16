<?php

namespace Modules\Technical\Business\Natal\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FlushNatalCache extends Command
{
    protected $signature = 'natal:cache-flush';

    protected $description =
        'Invalidate all natal cache';

    public function handle(): int
    {
        $version = Cache::increment(
            'natal_cache_version'
        );

        $this->info(
            "Natal cache invalidated. Version: {$version}"
        );

        return self::SUCCESS;
    }
}
