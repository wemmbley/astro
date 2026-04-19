<?php

use App\Modules\AI\AI;
use app\Modules\AI\Infrastructure\Drivers\Gemini\Gemini;

test('Gemini sent successfully response.', function () {
    $gemini = new Gemini();
    $ai = new AI($gemini);

});
