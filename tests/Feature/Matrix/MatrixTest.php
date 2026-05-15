<?php

use Matrix\Domain\Matrix;
use Matrix\Domain\VO\Birthday;

test('Matrix calculation for 22.12.2000 matches expected values', function () {
    $birthday = new Birthday(
        day: 22,
        month: 12,
        year: 2000
    );

    $matrix = new Matrix($birthday);
    $aggregate = $matrix->calculate();

    $base = $aggregate->base();
    $diagonal = $aggregate->diagonal();
    $chakras = $aggregate->chakras();

    // ==================================================
    // BASE POINTS
    // ==================================================
    expect($base->day()->getValue())->toBe(22, 'A (Day)');
    expect($base->month()->getValue())->toBe(12, 'B (Month)');
    expect($base->year()->getValue())->toBe(2, 'C (Year)');
    expect($base->earth()->getValue())->toBe(9, 'D (Earth)');
    expect($base->sky()->getValue())->toBe(9, 'E (Sky)');
    expect($base->portrait()->getValue())->toBe(7, 'F (Portrait)');
    expect($base->talent()->getValue())->toBe(14, 'G (Talent)');
    expect($base->background()->getValue())->toBe(4, 'H (Background)');
    expect($base->money()->getValue())->toBe(11, 'I (Money)');

    // ==================================================
    // DIAGONAL POINTS
    // ==================================================
    expect($diagonal->k()->getValue())->toBe(4, 'K (A + E)');
    expect($diagonal->l()->getValue())->toBe(21, 'L (B + E)');
    expect($diagonal->m()->getValue())->toBe(11, 'M (E + C)');
    expect($diagonal->n()->getValue())->toBe(18, 'N (E + D)');
    expect($diagonal->o()->getValue())->toBe(11, 'O (M + N)');
    expect($diagonal->p()->getValue())->toBe(9, 'P (N + D)');
    expect($diagonal->r()->getValue())->toBe(13, 'R (M + C)');

    // ==================================================
    // MULADHARA (Root)
    // ==================================================
    $muladhara = $chakras->muladhara();
    expect($muladhara->getPhysics()->getValue())->toBe(2, 'Muladhara: Physics');
    expect($muladhara->getEnergy()->getValue())->toBe(9, 'Muladhara: Energy');
    expect($muladhara->getEmotion()->getValue())->toBe(11, 'Muladhara: Emotion');

    // ==================================================
    // SVADHISTHANA (Sacral)
    // ==================================================
    $svadhisthana = $chakras->svadhisthana();
    expect($svadhisthana->getPhysics()->getValue())->toBe(11, 'Svadhisthana: Physics');
    expect($svadhisthana->getEnergy()->getValue())->toBe(13, 'Svadhisthana: Energy');
    expect($svadhisthana->getEmotion()->getValue())->toBe(6, 'Svadhisthana: Emotion');

    // ==================================================
    // MANIPURA (Solar Plexus)
    // ==================================================
    $manipura = $chakras->manipura();
    expect($manipura->getPhysics()->getValue())->toBe(9, 'Manipura: Physics');
    expect($manipura->getEnergy()->getValue())->toBe(9, 'Manipura: Energy');
    expect($manipura->getEmotion()->getValue())->toBe(18, 'Manipura: Emotion');

    // ==================================================
    // ANAHATA (Heart)
    // ==================================================
    $anahata = $chakras->anahata();
    expect($anahata->getPhysics()->getValue())->toBe(13, 'Anahata: Physics');
    expect($anahata->getEnergy()->getValue())->toBe(20, 'Anahata: Energy');
    expect($anahata->getEmotion()->getValue())->toBe(6, 'Anahata: Emotion');

    // ==================================================
    // VISHUDDHA (Throat)
    // ==================================================
    $vishuddha = $chakras->vishuddha();
    expect($vishuddha->getPhysics()->getValue())->toBe(4, 'Vishuddha: Physics');
    expect($vishuddha->getEnergy()->getValue())->toBe(11, 'Vishuddha: Energy');
    expect($vishuddha->getEmotion()->getValue())->toBe(15, 'Vishuddha: Emotion');

    // ==================================================
    // AJNA (Third Eye)
    // ==================================================
    $ajna = $chakras->ajna();
    expect($ajna->getPhysics()->getValue())->toBe(21, 'Ajna: Physics');
    expect($ajna->getEnergy()->getValue())->toBe(18, 'Ajna: Energy');
    expect($ajna->getEmotion()->getValue())->toBe(12, 'Ajna: Emotion');

    // ==================================================
    // SAHASRARA (Crown)
    // ==================================================
    $sahasrara = $chakras->sahasrara();
    expect($sahasrara->getPhysics()->getValue())->toBe(22, 'Sahasrara: Physics');
    expect($sahasrara->getEnergy()->getValue())->toBe(12, 'Sahasrara: Energy');
    expect($sahasrara->getEmotion()->getValue())->toBe(7, 'Sahasrara: Emotion');
});
