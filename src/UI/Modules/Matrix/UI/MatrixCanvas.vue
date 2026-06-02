<script setup lang="ts">
import { computed, ref } from 'vue';

// ─── Интерфейсы ──────────────────────────────────────────────────────────────
interface BasePoints {
    A: number | null;   // День рождения   — 0 лет
    B: number | null;   // Месяц рождения  — 20 лет
    C: number | null;   // Год рождения    — 40 лет
    D: number | null;   // Земля           — 60 лет
    E: number | null;   // Центр / Предназначение
    F: number | null;   // Духовный портрет
    G: number | null;   // Таланты
    H: number | null;   // Отношения
    I: number | null;   // Деньги
}

interface DiagonalPoints {
    k: number | null;   // СЗ угол квадрата
    l: number | null;   // СВ угол квадрата
    m: number | null;   // ЮВ угол квадрата
    n: number | null;   // ЮЗ угол квадрата
    o: number | null;   // диагональ 1
    p: number | null;   // диагональ 2
    r: number | null;   // диагональ 3
}

interface OctagonPoints {
    D: number | null;   // 10 лет — Д
    E: number | null;   // 30 лет — Е
    Zh: number | null;  // 50 лет — Ж
    Z: number | null;   // 70 лет — З
    G60: number | null; // 60 лет — Г
}

// ─── Пропсы ──────────────────────────────────────────────────────────────────
const props = defineProps<{
    destinyNumber: number;
    basePoints: BasePoints;
    diagonalPoints: DiagonalPoints;
    octagonPoints?: OctagonPoints;
}>();

// ─── Тултип ──────────────────────────────────────────────────────────────────
const tooltip = ref({ visible: false, x: 0, y: 0, label: '', value: null as number | null });
const hoveredKey = ref<string | null>(null);

const LABELS: Record<string, string> = {
    A:   'День рождения',
    B:   'Месяц рождения',
    C:   'Год рождения',
    D:   'Земля (60 лет)',
    E:   'Центр / Предназначение',
    F:   'Духовный портрет',
    G:   'Таланты',
    H:   'Отношения',
    I:   'Деньги',
    k:   'Родовая точка СЗ',
    l:   'Родовая точка СВ',
    m:   'Родовая точка ЮВ',
    n:   'Родовая точка ЮЗ',
    o:   'Канал (диагональ)',
    p:   'Канал (диагональ)',
    r:   'Канал (диагональ)',
    D10: '10 лет',
    E30: '30 лет',
    Zh50:'50 лет',
    Z70: '70 лет',
};

// ─── SVG размеры ─────────────────────────────────────────────────────────────
const CX = 300, CY = 300;
const OCT_R = 252;   // радиус октагона
const DIA_R = 195;   // радиус ромба (ось)
const SQ    = 155;   // половина стороны внутреннего квадрата

// ─── Вспомогательная функция полярных координат ──────────────────────────────
function polar(r: number, deg: number) {
    const a = deg * Math.PI / 180;
    return { x: CX + r * Math.cos(a), y: CY + r * Math.sin(a) };
}

// ─── Октагон ─────────────────────────────────────────────────────────────────
// Вершины: A=180°(лево), Д=135°, Б=90°(верх), Е=45°, В=0°(право), Ж=315°, Г=270°(низ), З=225°
const OCT_CONFIG = [
    { key: 'A',   deg: 180, age: '0 лет',  label: 'А' },
    { key: 'D10', deg: 135, age: '10 лет', label: 'Д' },
    { key: 'B',   deg: 90,  age: '20 лет', label: 'Б' },
    { key: 'E30', deg: 45,  age: '30 лет', label: 'Е' },
    { key: 'C',   deg: 0,   age: '40 лет', label: 'В' },
    { key: 'Zh50',deg: 315, age: '50 лет', label: 'Ж' },
    { key: 'D',   deg: 270, age: '60 лет', label: 'Г' },
    { key: 'Z70', deg: 225, age: '70 лет', label: 'З' },
] as const;

const octagonPoints = computed(() =>
    OCT_CONFIG.map(cfg => ({ ...cfg, ...polar(OCT_R, cfg.deg) }))
);

const octagonPolygon = computed(() =>
    octagonPoints.value.map(p => `${p.x},${p.y}`).join(' ')
);

const diamondPolygon = computed(() =>
    [0, 90, 180, 270].map(d => polar(DIA_R, d)).map(p => `${p.x},${p.y}`).join(' ')
);

// ─── Стили для разных типов узлов ────────────────────────────────────────────
function getNodeStyle(key: string) {
    if (key === 'E')
        return { fill: '#451a03', stroke: '#f59e0b', text: '#fef3c7', r: 26, strokeW: 2.5 };
    if (['A', 'B'].includes(key))
        return { fill: '#2e1065', stroke: '#a855f7', text: '#f3e8ff', r: 30, strokeW: 2 };
    if (['C', 'D'].includes(key))
        return { fill: '#7f1d1d', stroke: '#f87171', text: '#fecaca', r: 30, strokeW: 2 };
    if (['D10', 'E30', 'Zh50', 'Z70'].includes(key))
        return { fill: '#1e3a5f', stroke: '#3b82f6', text: '#bfdbfe', r: 22, strokeW: 2 };
    if (['F', 'G', 'H', 'I'].includes(key))
        return { fill: '#0d1f3c', stroke: '#38bdf8', text: '#e0f2fe', r: 18, strokeW: 2 };
    if (['k', 'l', 'm', 'n'].includes(key))
        return { fill: '#14352e', stroke: '#34d399', text: '#a7f3d0', r: 16, strokeW: 2 };
    return { fill: '#1a1f30', stroke: '#64748b', text: '#cbd5e1', r: 13, strokeW: 1.5 };
}

// ─── Значение узла ───────────────────────────────────────────────────────────
function getVal(key: string): number | null {
    const b = props.basePoints, d = props.diagonalPoints, o = props.octagonPoints;
    const map: Record<string, number | null | undefined> = {
        A: b.A, B: b.B, C: b.C, D: b.D, E: b.E,
        F: b.F, G: b.G, H: b.H, I: b.I,
        k: d.k, l: d.l, m: d.m, n: d.n, o: d.o, p: d.p, r: d.r,
        D10:  o?.D,
        E30:  o?.E,
        Zh50: o?.Zh,
        Z70:  o?.Z,
    };
    return map[key] ?? null;
}

// ─── Все узлы ────────────────────────────────────────────────────────────────
const allNodes = computed(() => {
    const oct = octagonPoints.value.map(p => ({
        key: p.key, x: p.x, y: p.y, style: getNodeStyle(p.key), value: getVal(p.key)
    }));

    const inner = [
        // Ось — между вершиной октагона и центром (55% расстояния)
        { key: 'F', x: CX - DIA_R * 0.55, y: CY },
        { key: 'G', x: CX,                y: CY - DIA_R * 0.55 },
        { key: 'H', x: CX + DIA_R * 0.55, y: CY },
        { key: 'I', x: CX,                y: CY + DIA_R * 0.55 },
        // Углы внутреннего квадрата
        { key: 'k', x: CX - SQ, y: CY - SQ },
        { key: 'l', x: CX + SQ, y: CY - SQ },
        { key: 'm', x: CX + SQ, y: CY + SQ },
        { key: 'n', x: CX - SQ, y: CY + SQ },
        // Диагональные точки
        { key: 'o', x: CX - SQ * 0.52, y: CY - SQ * 0.52 },
        { key: 'p', x: CX + SQ * 0.52, y: CY - SQ * 0.52 },
        { key: 'r', x: CX + SQ * 0.52, y: CY + SQ * 0.52 },
        // Центр
        { key: 'E', x: CX, y: CY },
    ].map(n => ({ ...n, style: getNodeStyle(n.key), value: getVal(n.key) }));

    return [...oct, ...inner];
});

// ─── Дополнительные кружки-спутники вокруг вершин октагона ──────────────────
// (как на скрине — несколько пустых кружков нанизаны вдоль рёбер)
const satellites = computed(() => {
    const result: { x: number, y: number, r: number, stroke: string }[] = [];
    const pairs = [
        [0, 1], [1, 2], [2, 3], [3, 4], [4, 5], [5, 6], [6, 7], [7, 0]
    ] as const;
    pairs.forEach(([i, j]) => {
        const a = octagonPoints.value[i];
        const b = octagonPoints.value[j];
        // 2 маленьких кружка между вершинами
        [0.33, 0.66].forEach(t => {
            result.push({
                x: a.x + (b.x - a.x) * t,
                y: a.y + (b.y - a.y) * t,
                r: 8,
                stroke: '#1e2d50',
            });
        });
    });
    return result;
});

// ─── Hover ───────────────────────────────────────────────────────────────────
function onEnter(node: { key: string, x: number, y: number, style: ReturnType<typeof getNodeStyle>, value: number | null }, e: MouseEvent) {
    hoveredKey.value = node.key;
    const svg = (e.currentTarget as SVGElement).closest('svg') as SVGSVGElement;
    const rect = svg.getBoundingClientRect();
    const wrap = (e.currentTarget as SVGElement).closest('.dm-container') as HTMLElement;
    const wrect = wrap.getBoundingClientRect();
    const scale = 600 / rect.width;
    tooltip.value = {
        visible: true,
        x: node.x / scale + (rect.left - wrect.left) + node.style.r / scale + 8,
        y: node.y / scale + (rect.top - wrect.top) - 20,
        label: LABELS[node.key] || node.key,
        value: node.value,
    };
}

function onLeave() {
    hoveredKey.value = null;
    tooltip.value.visible = false;
}

function nodeRadius(node: { key: string, style: ReturnType<typeof getNodeStyle> }) {
    return hoveredKey.value === node.key ? node.style.r + 4 : node.style.r;
}
</script>

<template>
    <div class="dm-wrapper">
        <div class="dm-heading">
            <span class="dm-title">Матрица судьбы</span>
            <span class="dm-destiny">Число судьбы: {{ destinyNumber }}</span>
        </div>

        <div class="dm-container">
            <!-- Тултип -->
            <Transition name="tip-fade">
                <div v-if="tooltip.visible" class="dm-tooltip"
                     :style="{ left: tooltip.x + 'px', top: tooltip.y + 'px' }">
                    <span class="tip-label">{{ tooltip.label }}</span>
                    <span v-if="tooltip.value !== null" class="tip-value">{{ tooltip.value }}</span>
                    <span v-else class="tip-empty">не заполнено</span>
                </div>
            </Transition>

            <svg viewBox="0 0 600 600" class="dm-svg">
                <defs>
                    <radialGradient id="dmBg" cx="50%" cy="50%" r="50%">
                        <stop offset="0%"   stop-color="#1e1b4b" stop-opacity="0.6"/>
                        <stop offset="100%" stop-color="#090912" stop-opacity="0"/>
                    </radialGradient>
                    <filter id="dmGlow" x="-50%" y="-50%" width="200%" height="200%">
                        <feGaussianBlur stdDeviation="5" result="blur"/>
                        <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                    </filter>
                    <marker id="arrBlue" markerWidth="7" markerHeight="7" refX="6" refY="3.5" orient="auto">
                        <path d="M0,0 L7,3.5 L0,7 Z" fill="#60a5fa"/>
                    </marker>
                    <marker id="arrRed" markerWidth="7" markerHeight="7" refX="6" refY="3.5" orient="auto">
                        <path d="M0,0 L7,3.5 L0,7 Z" fill="#f87171"/>
                    </marker>
                </defs>

                <!-- Фон -->
                <rect width="600" height="600" rx="18" fill="#0a0a15"/>
                <circle cx="300" cy="300" r="285" fill="url(#dmBg)"/>

                <!-- Сетка ────────────────────────────────────────────── -->
                <!-- Октагон -->
                <polygon :points="octagonPolygon" class="line-oct"/>

                <!-- Ромб (ось: соединяет A–B–C–D) -->
                <polygon :points="diamondPolygon" class="line-diamond"/>

                <!-- Внутренний квадрат -->
                <rect :x="CX-SQ" :y="CY-SQ" :width="SQ*2" :height="SQ*2" class="line-sq"/>

                <!-- Оси -->
                <line :x1="CX-DIA_R" :y1="CY" :x2="CX+DIA_R" :y2="CY" class="line-axis"/>
                <line :x1="CX" :y1="CY-DIA_R" :x2="CX" :y2="CY+DIA_R" class="line-axis"/>
                <!-- Диагонали квадрата -->
                <line :x1="CX-SQ" :y1="CY-SQ" :x2="CX+SQ" :y2="CY+SQ" class="line-diag"/>
                <line :x1="CX+SQ" :y1="CY-SQ" :x2="CX-SQ" :y2="CY+SQ" class="line-diag"/>

                <!-- Зона комфорта -->
                <circle :cx="CX" :cy="CY" r="85" class="comfort-circle"/>
                <text :x="CX" :y="CY+100" class="comfort-label">ЗОНА КОМФОРТА</text>

                <!-- Линии рода ─────────────────────────────────────── -->
                <!-- Мужской род: от А(лево) вправо-вверх к E(центру) -->
                <line :x1="CX-100" :y1="CY+25" :x2="CX+55" :y2="CY-55"
                      class="line-male" marker-end="url(#arrBlue)"/>
                <text :x="CX-95" :y="CY-5" class="label-male"
                      transform="rotate(-26 205 295)">линия мужского рода</text>

                <!-- Женский род: от B(верх-право) вниз-влево -->
                <line :x1="CX+100" :y1="CY-25" :x2="CX-55" :y2="CY+75"
                      class="line-female" marker-end="url(#arrRed)"/>
                <text :x="CX+25" :y="CY-18" class="label-female"
                      transform="rotate(24 325 282)">линия женского рода</text>

                <!-- Подписи сторон / возрастов ──────────────────────── -->
                <g v-for="oct in octagonPoints" :key="oct.key + '_lbl'">
                    <text
                        :x="CX + (OCT_R + 22) * Math.cos(oct.deg * Math.PI / 180)"
                        :y="CY + (OCT_R + 22) * Math.sin(oct.deg * Math.PI / 180)"
                        class="age-label"
                    >{{ oct.age }}</text>
                    <text
                        :x="CX + (OCT_R + 6) * Math.cos(oct.deg * Math.PI / 180)"
                        :y="CY + (OCT_R + 6) * Math.sin(oct.deg * Math.PI / 180)"
                        class="oct-key-label"
                    >{{ oct.label }}</text>
                </g>

                <!-- Кружки-спутники между вершинами октагона ──────── -->
                <circle
                    v-for="(sat, i) in satellites" :key="'sat' + i"
                    :cx="sat.x" :cy="sat.y" :r="sat.r"
                    fill="transparent" :stroke="sat.stroke" stroke-width="1.2"
                />

                <!-- Все узлы ─────────────────────────────────────────── -->
                <g
                    v-for="node in allNodes"
                    :key="node.key"
                    class="dm-node"
                    @mouseenter="onEnter(node, $event)"
                    @mouseleave="onLeave"
                >
                    <circle
                        :cx="node.x"
                        :cy="node.y"
                        :r="nodeRadius(node)"
                        :fill="node.value === null ? 'transparent' : node.style.fill"
                        :stroke="node.style.stroke"
                        :stroke-width="node.style.strokeW"
                        :stroke-dasharray="node.value === null ? '5 3' : 'none'"
                        :filter="node.key === 'E' ? 'url(#dmGlow)' : undefined"
                    />
                    <!-- Значение -->
                    <text
                        v-if="node.value !== null"
                        :x="node.x"
                        :y="node.key === 'E' ? node.y - 4 : node.y"
                        :font-size="node.style.r > 24 ? 15 : node.style.r > 17 ? 13 : node.style.r > 14 ? 11 : 10"
                        :fill="node.style.text"
                        text-anchor="middle"
                        dominant-baseline="central"
                        font-weight="700"
                        font-family="system-ui, sans-serif"
                        pointer-events="none"
                    >{{ node.value }}</text>
                    <!-- Подпись ЗК у центра -->
                    <text
                        v-if="node.key === 'E' && node.value !== null"
                        :x="node.x"
                        :y="node.y + 9"
                        font-size="8"
                        fill="#d97706"
                        text-anchor="middle"
                        dominant-baseline="central"
                        font-family="system-ui, sans-serif"
                        pointer-events="none"
                    >ЗК</text>
                </g>
            </svg>
        </div>
    </div>
</template>

<style scoped>
/* ─── Обёртка ──────────────────────────────────────────────────────────── */
.dm-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.6rem;
    padding: 1rem 0;
}

.dm-heading {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
}

.dm-title {
    font-size: 11px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #3a4a6a;
    font-family: system-ui, sans-serif;
}

.dm-destiny {
    font-size: 13px;
    font-weight: 600;
    color: #f59e0b;
    font-family: system-ui, sans-serif;
}

.dm-container {
    position: relative;
    width: 100%;
    max-width: 560px;
}

.dm-svg {
    width: 100%;
    height: auto;
    display: block;
}

/* ─── Линии сетки ──────────────────────────────────────────────────────── */
.line-oct {
    fill: none;
    stroke: #2a3560;
    stroke-width: 1.5;
}
.line-diamond {
    fill: none;
    stroke: #2a3560;
    stroke-width: 1.5;
}
.line-sq {
    fill: none;
    stroke: #1f2d52;
    stroke-width: 1.2;
}
.line-axis {
    stroke: #19224a;
    stroke-width: 1;
    stroke-dasharray: 6 4;
}
.line-diag {
    stroke: #19224a;
    stroke-width: 1;
    stroke-dasharray: 5 4;
}

/* ─── Зона комфорта ─────────────────────────────────────────────────────── */
.comfort-circle {
    fill: none;
    stroke: #2a3560;
    stroke-width: 1.2;
    stroke-dasharray: 6 3;
}
.comfort-label {
    text-anchor: middle;
    fill: #2e3a5a;
    font-size: 9px;
    letter-spacing: 1.5px;
    font-family: system-ui, sans-serif;
}

/* ─── Линии рода ─────────────────────────────────────────────────────────── */
.line-male {
    stroke: #60a5fa;
    stroke-width: 1.5;
    opacity: 0.65;
}
.line-female {
    stroke: #f87171;
    stroke-width: 1.5;
    opacity: 0.65;
}
.label-male {
    font-size: 7.5px;
    fill: #3b5fa0;
    font-family: system-ui, sans-serif;
    text-anchor: middle;
}
.label-female {
    font-size: 7.5px;
    fill: #9a3535;
    font-family: system-ui, sans-serif;
    text-anchor: middle;
}

/* ─── Подписи возраста ──────────────────────────────────────────────────── */
.age-label {
    font-size: 9px;
    fill: #3a4a6a;
    text-anchor: middle;
    dominant-baseline: central;
    font-family: system-ui, sans-serif;
}
.oct-key-label {
    font-size: 8px;
    fill: #2a3868;
    text-anchor: middle;
    dominant-baseline: central;
    font-family: system-ui, sans-serif;
}

/* ─── Узлы ──────────────────────────────────────────────────────────────── */
.dm-node {
    cursor: pointer;
}

/* Ключевое: только r анимируем, никаких transform — нет дёрганья! */
.dm-node circle {
    transition: r 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* ─── Тултип ────────────────────────────────────────────────────────────── */
.dm-tooltip {
    position: absolute;
    background: #111827;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 7px 12px;
    pointer-events: none;
    z-index: 20;
    display: flex;
    flex-direction: column;
    gap: 2px;
    white-space: nowrap;
}

.tip-label {
    font-size: 11px;
    color: #94a3b8;
    font-family: system-ui, sans-serif;
}

.tip-value {
    font-size: 20px;
    font-weight: 700;
    color: #f1f5f9;
    font-family: system-ui, sans-serif;
    line-height: 1.1;
}

.tip-empty {
    font-size: 12px;
    color: #4b5563;
    font-style: italic;
    font-family: system-ui, sans-serif;
}

.tip-fade-enter-active,
.tip-fade-leave-active {
    transition: opacity 0.15s ease;
}
.tip-fade-enter-from,
.tip-fade-leave-to {
    opacity: 0;
}
</style>
