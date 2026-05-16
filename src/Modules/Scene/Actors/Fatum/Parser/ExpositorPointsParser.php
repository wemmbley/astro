<?php

namespace Modules\Technical\Esoteric\Matrix\Parser;

use App\Modules\Matrix\Domain\ArcanePoint;
use App\Modules\Matrix\Domain\PointInterpretation;

final readonly class ExpositorPointsParser
{
    public function parseMoneyKarma(ArcanePoint $moneyKarma): PointInterpretation
    {
        $file = resource_path('interpretations/points/money_karma.md');
        $content = file_get_contents($file);
        $frontmatter = $this->parseFrontmatter($content);

        $arcane = $moneyKarma->getValue();

        // Ищем контекст для конкретного аркана
        foreach ($frontmatter['contexts'] as $context) {
            if ($context['arcane'] === $arcane) {
                return new PointInterpretation(
                    title: $frontmatter['title'],
                    subtitle: $frontmatter['subtitle'],
                    label: $context['label'],
                    description: $context['description'],
                    advice: $context['advice'] ?? null,
                    shadow: $context['shadow'] ?? null,
                );
            }
        }

        // Fallback на общую интерпретацию
        return new PointInterpretation(
            title: $frontmatter['title'],
            subtitle: $frontmatter['subtitle'],
            label: "Аркан {$arcane}",
            description: "Индивидуальная интерпретация для аркана {$arcane} в этой точке.",
            advice: null,
            shadow: null,
        );
    }
}
