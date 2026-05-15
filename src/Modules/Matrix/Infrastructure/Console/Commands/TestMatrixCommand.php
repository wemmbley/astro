<?php

namespace Modules\Matrix\Infrastructure\Console\Commands;

use App\Modules\AI\Core\Contracts\AIProvider;
use Modules\Matrix\Domain\Matrix;
use Modules\Matrix\Domain\VO\Birthday;
use Illuminate\Console\Command;

class TestMatrixCommand extends Command
{
    protected $signature = 'matrix {day} {month} {year}';
    protected $description = 'Get Matrix.';

    public function handle(): int
    {
        $day = $this->argument('day');
        $month = $this->argument('month');
        $year = $this->argument('year');

        $birthday = new Birthday(
            day: $day,
            month: $month,
            year: $year
        );

        $matrix = new Matrix($birthday);
        $matrix = $matrix->calculate();

        dump($matrix);
        dd($matrix->chakras()->toArray());
    }
}
