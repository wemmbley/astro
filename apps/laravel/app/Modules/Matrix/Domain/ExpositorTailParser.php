<?php

namespace App\Modules\Matrix\Domain;

final readonly class ExpositorTailParser
{
    public function parse(ArcanePoint $z, ArcanePoint $j, ArcanePoint $i): KarmicTailInterpretation
    {
        $triplet = [$z->getValue(), $j->getValue(), $i->getValue()];

        $file = resource_path('interpretations/points/karmic_tail.md');
        $content = file_get_contents($file);
        $frontmatter = $this->parseFrontmatter($content);

        // Ищем точное совпадение триплета
        foreach ($frontmatter['triplets'] as $item) {
            if ($item['values'] === $triplet) {
                return KarmicTailInterpretation::fromArray($item);
            }
        }

        // Если нет точного совпадения — генерируем из отдельных арканов
        return $this->generateFromArcanes($z, $j, $i);
    }

    private function generateFromArcanes(ArcanePoint $z, ArcanePoint $j, ArcanePoint $i): KarmicTailInterpretation
    {
        $arcaneParser = new ArcaneParser();

        $pastLife = $arcaneParser->parse($z);
        $talent = $arcaneParser->parse($j);
        $solution = $arcaneParser->parse($i);

        return new KarmicTailInterpretation(
            title: "Индивидуальный кармический хвост {$z->getValue()}-{$j->getValue()}-{$i->getValue()}",
            pastLife: "В прошлом воплощении энергия была связана с арканом {$z->getValue()} ({$pastLife->title}). " . $pastLife->karmic_context,
            currentManifestation: "В этой жизни проявляется через аркан {$j->getValue()} ({$talent->title}). " . $talent->manifestation_context,
            solution: "Путь исцеления лежит через аркан {$i->getValue()} ({$solution->title}). " . $solution->healing_context,
            professionsForHealing: $solution->professions,
        );
    }
}
