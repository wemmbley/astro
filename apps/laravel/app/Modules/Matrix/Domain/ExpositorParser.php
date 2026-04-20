<?php

namespace App\Modules\Matrix\Domain;

final readonly class ExpositorParser
{
    public function parseMuladhara(
        ArcanePoint $physics,
        ArcanePoint $energy,
        ArcanePoint $emotion
    ): ChakraInterpretation {
        $file = resource_path('interpretations/chakras/muladhara.md');
        $content = file_get_contents($file);

        $frontmatter = $this->parseFrontmatter($content);

        $physicsValue = $physics->getValue();
        $energyValue = $energy->getValue();
        $emotionValue = $emotion->getValue();

        return new ChakraInterpretation(
            physics: $this->findRange($frontmatter['physics'], $physicsValue),
            energy: $this->findRange($frontmatter['energy'], $energyValue),
            emotion: $this->findRange($frontmatter['emotion'], $emotionValue),
            combination: $this->findCombination($frontmatter['combinations'], [
                'physics' => $physicsValue,
                'energy' => $energyValue,
                'emotion' => $emotionValue,
            ]),
            general: $this->parseBody($content),
        );
    }

    private function findRange(array $ranges, int $value): RangeInterpretation
    {
        foreach ($ranges as $range) {
            if ($value >= $range['range'][0] && $value <= $range['range'][1]) {
                return new RangeInterpretation(
                    label: $range['label'],
                    description: $range['description'],
                    recommendations: $range['recommendations'] ?? [],
                );
            }
        }

        throw new \RuntimeException("No range found for value {$value}");
    }

    private function findCombination(array $combinations, array $values): ?CombinationInterpretation
    {
        foreach ($combinations as $combo) {
            $condition = $combo['condition'];

            // Простой eval для демонстрации (в продакшене лучше использовать ExpressionLanguage)
            $result = $this->evaluateCondition($condition, $values);

            if ($result) {
                return new CombinationInterpretation(
                    label: $combo['label'],
                    description: $combo['description'],
                );
            }
        }

        return null;
    }
}
