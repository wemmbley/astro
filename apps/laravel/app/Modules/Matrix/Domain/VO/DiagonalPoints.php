<?php

namespace App\Modules\Matrix\Domain\VO;

final readonly class DiagonalPoints
{
    public function __construct(
        private ArcanePoint $k, // Мужской род
        private ArcanePoint $l, // Женский род
        private ArcanePoint $m, // Левая диагональ
        private ArcanePoint $n, // Правая диагональ
        private ArcanePoint $o, // Низ матрицы
        private ArcanePoint $p, // Правая нижняя
        private ArcanePoint $r, // Левая нижняя
    ) {}

    public function k(): ArcanePoint { return $this->k; }
    public function l(): ArcanePoint { return $this->l; }
    public function m(): ArcanePoint { return $this->m; }
    public function n(): ArcanePoint { return $this->n; }
    public function o(): ArcanePoint { return $this->o; }
    public function p(): ArcanePoint { return $this->p; }
    public function r(): ArcanePoint { return $this->r; }
}
