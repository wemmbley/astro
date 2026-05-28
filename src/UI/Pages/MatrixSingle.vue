<script setup lang="ts">
import { computed, ref } from "vue";
import MainLayout from "@/Resources/Layouts/MainLayout.vue";
import Tabber from "@/Modules/Shared/Components/Tabber.vue";

const props = defineProps<{
    chakras: Record<string, {
        physics: number
        energy: number
        emotion: number
    }>
}>();

const activeTab = ref('radar');

const tabs = [
    { key: 'radar', label: 'Паутина' },
    { key: 'triangle', label: 'Треугольник' },
];

const chakraMeta: Record<string, {
    title: string
    dot: string
    soft: string
    hex: string
}> = {
    sahasrara: { title: "Сахасрара", dot: "bg-purple-500", soft: "bg-purple-500/20", hex: "#a855f7" },
    ajna:      { title: "Аджна",     dot: "bg-indigo-500", soft: "bg-indigo-500/20", hex: "#6366f1" },
    vishuddha: { title: "Вишудха",   dot: "bg-cyan-500",   soft: "bg-cyan-500/20",   hex: "#06b6d4" },
    anahata:   { title: "Анахата",   dot: "bg-green-500",  soft: "bg-green-500/20",  hex: "#22c55e" },
    manipura:  { title: "Манипура",  dot: "bg-yellow-400", soft: "bg-yellow-400/20", hex: "#facc15" },
    svadhisthana: { title: "Свадхистхана", dot: "bg-orange-500", soft: "bg-orange-500/20", hex: "#f97316" },
    muladhara: { title: "Муладхара", dot: "bg-red-500",    soft: "bg-red-500/20",    hex: "#ef4444" },
};

const labels: Record<string, string> = {
    physics: "Физика",
    energy:  "Энергия",
    emotion: "Эмоции",
};

const chakraEntries = computed(() => Object.entries(props.chakras));

const maxStat = 25;

const getPercent = (val: number) => `${(val / maxStat) * 100}%`;

// ── RADAR ─────────────────────────────────────────────────────────────────────
const radarSize = 500;
const radarCx = radarSize / 2;
const radarCy = radarSize / 2;
const radarMaxR = 190;
const radarRings = [1, 0.75, 0.5, 0.25];

const angleForIndex = (i: number, total: number) =>
    (i * (2 * Math.PI)) / total - Math.PI / 2;

const polarToCart = (r: number, angle: number) => ({
    x: radarCx + r * Math.cos(angle),
    y: radarCy + r * Math.sin(angle),
});

const ringPath = (ratio: number) => {
    const n = chakraEntries.value.length;
    return chakraEntries.value
        .map((_, i) => {
            const { x, y } = polarToCart(radarMaxR * ratio, angleForIndex(i, n));
            return `${i === 0 ? 'M' : 'L'}${x},${y}`;
        })
        .join(' ') + ' Z';
};

const axisLines = computed(() =>
    chakraEntries.value.map((_, i) => {
        const angle = angleForIndex(i, chakraEntries.value.length);
        const end = polarToCart(radarMaxR, angle);
        return { x1: radarCx, y1: radarCy, x2: end.x, y2: end.y };
    })
);

const labelPositions = computed(() =>
    chakraEntries.value.map(([key], i) => {
        const angle = angleForIndex(i, chakraEntries.value.length);
        const pos = polarToCart(radarMaxR + 36, angle);
        return { ...pos, key };
    })
);

const statKeys: Array<'physics' | 'energy' | 'emotion'> = ['physics', 'energy', 'emotion'];
const statColors: Record<string, string> = {
    physics: '#22d3ee',
    energy:  '#a78bfa',
    emotion: '#f472b6',
};

const statPolygons = computed(() =>
    statKeys.map(stat => {
        const n = chakraEntries.value.length;
        const points = chakraEntries.value
            .map(([, vals], i) => {
                const r = (vals[stat] / maxStat) * radarMaxR;
                const { x, y } = polarToCart(r, angleForIndex(i, n));
                return `${x},${y}`;
            })
            .join(' ');
        return { stat, points, color: statColors[stat] };
    })
);

// ── TRIANGLE ──────────────────────────────────────────────────────────────────
// Vertices: physics = top, energy = bottom-left, emotion = bottom-right
const triSize = 460;
const triCx = triSize / 2;
const triCy = triSize / 2;
const triR = 185;

const triV = {
    physics: {
        x: triCx + triR * Math.cos(Math.PI * 1.5),
        y: triCy + triR * Math.sin(Math.PI * 1.5),
    },
    energy: {
        x: triCx + triR * Math.cos(Math.PI * (1.5 + 2 / 3)),
        y: triCy + triR * Math.sin(Math.PI * (1.5 + 2 / 3)),
    },
    emotion: {
        x: triCx + triR * Math.cos(Math.PI * (1.5 + 4 / 3)),
        y: triCy + triR * Math.sin(Math.PI * (1.5 + 4 / 3)),
    },
};

// Interpolate a point along the triangle edge between center and vertex by ratio t
const triInterp = (t: number, vx: number, vy: number) => ({
    x: triCx + (vx - triCx) * t,
    y: triCy + (vy - triCy) * t,
});

// Build a scaled-down triangle polygon string (ratio 0..1 from center)
const scaledTriPoints = (t: number) => {
    const p = triInterp(t, triV.physics.x, triV.physics.y);
    const e = triInterp(t, triV.energy.x, triV.energy.y);
    const em = triInterp(t, triV.emotion.x, triV.emotion.y);
    return `${p.x},${p.y} ${e.x},${e.y} ${em.x},${em.y}`;
};

// For each chakra: barycentric position mapped onto the triangle
// The "pull" toward each vertex is proportional to normalised stat values
const triChakraPolygons = computed(() =>
    chakraEntries.value.map(([key, vals]) => {
        const total = vals.physics + vals.energy + vals.emotion || 1;
        const wp  = vals.physics / total;
        const we  = vals.energy  / total;
        const wem = vals.emotion / total;

        // centroid of this chakra inside the triangle
        const cx = wp * triV.physics.x + we * triV.energy.x + wem * triV.emotion.x;
        const cy = wp * triV.physics.y + we * triV.energy.y + wem * triV.emotion.y;

        // size of the mini-triangle: scaled by max stat
        const maxVal = Math.max(vals.physics, vals.energy, vals.emotion);
        const r = 18 + (maxVal / maxStat) * 30;

        // build a small triangle around centroid, pointed toward dominant vertex
        // offset each vertex in the direction of each stat's vertex
        const pv = { x: cx + (triV.physics.x - triCx) * 0.22, y: cy + (triV.physics.y - triCy) * 0.22 };
        const ev = { x: cx + (triV.energy.x  - triCx) * 0.22, y: cy + (triV.energy.y  - triCy) * 0.22 };
        const emv= { x: cx + (triV.emotion.x - triCx) * 0.22, y: cy + (triV.emotion.y - triCy) * 0.22 };

        // scale each arm by its normalised weight to show the pull
        const arm = (wx: number, wy: number, w: number) => ({
            x: cx + (wx - cx) * w * 2.8 + (wx - cx) * 0.05,
            y: cy + (wy - cy) * w * 2.8 + (wy - cy) * 0.05,
        });

        const pt1 = arm(pv.x,  pv.y,  wp);
        const pt2 = arm(ev.x,  ev.y,  we);
        const pt3 = arm(emv.x, emv.y, wem);

        return {
            key,
            points: `${pt1.x},${pt1.y} ${pt2.x},${pt2.y} ${pt3.x},${pt3.y}`,
            meta: chakraMeta[key],
        };
    })
);

const triRings = [1, 0.75, 0.5, 0.25];
const triOutlinePoints = scaledTriPoints(1);

const hoveredChakra = ref<string | null>(null);
</script>

<template>
    <MainLayout>
        <div class="max-w-5xl mx-auto text-surface-100">
            <!-- header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold">Матрица чакр</h1>
                    <div class="text-surface-100/40 text-sm mt-1">Энергетический профиль системы</div>
                </div>
                <div class="bg-surface-800 rounded-xl">
                    <Tabber :tabs="tabs" v-model="activeTab" />
                </div>
            </div>

            <!-- graph -->
            <div class="surface-ui rounded-3xl p-8 mb-8 overflow-hidden relative">

                <!-- RADAR -->
                <div v-if="activeTab === 'radar'" class="flex flex-col items-center gap-6">
                    <svg
                        :width="radarSize"
                        :height="radarSize"
                        :viewBox="`0 0 ${radarSize} ${radarSize}`"
                        class="max-w-full"
                    >
                        <path
                            v-for="ratio in radarRings"
                            :key="ratio"
                            :d="ringPath(ratio)"
                            fill="none"
                            stroke="rgba(255,255,255,0.08)"
                            stroke-width="1"
                        />
                        <line
                            v-for="(ax, i) in axisLines"
                            :key="i"
                            v-bind="ax"
                            stroke="rgba(255,255,255,0.10)"
                            stroke-width="1"
                        />
                        <polygon
                            v-for="p in statPolygons"
                            :key="p.stat"
                            :points="p.points"
                            :fill="p.color + '33'"
                            :stroke="p.color"
                            stroke-width="1.5"
                            stroke-linejoin="round"
                        />
                        <text
                            v-for="lp in labelPositions"
                            :key="lp.key"
                            :x="lp.x"
                            :y="lp.y"
                            text-anchor="middle"
                            dominant-baseline="middle"
                            font-size="11"
                            font-weight="600"
                            :fill="chakraMeta[lp.key]?.hex ?? '#fff'"
                        >{{ chakraMeta[lp.key]?.title ?? lp.key }}</text>
                        <circle :cx="radarCx" :cy="radarCy" r="4" fill="var(--color-accent, #a78bfa)" />
                    </svg>
                    <div class="flex items-center gap-6">
                        <div v-for="s in statKeys" :key="s" class="flex items-center gap-2 text-xs">
                            <span class="w-6 h-0.5 rounded" :style="{ background: statColors[s] }"></span>
                            <span class="text-surface-100/60">{{ labels[s] }}</span>
                        </div>
                    </div>
                </div>

                <!-- TRIANGLE -->
                <div v-if="activeTab === 'triangle'" class="flex flex-col items-center gap-4">
                    <div class="h-7 flex items-center justify-center">
                        <div
                            v-if="hoveredChakra"
                            class="px-3 py-1 rounded-xl text-xs font-semibold bg-surface-700 text-surface-100 shadow-lg"
                        >{{ chakraMeta[hoveredChakra]?.title ?? hoveredChakra }}</div>
                    </div>
                    <svg
                        :width="triSize"
                        :height="triSize"
                        :viewBox="`0 0 ${triSize} ${triSize}`"
                        class="max-w-full"
                    >
                        <!-- grid rings (scaled triangles) -->
                        <polygon
                            v-for="t in triRings"
                            :key="t"
                            :points="scaledTriPoints(t)"
                            fill="none"
                            stroke="rgba(255,255,255,0.08)"
                            stroke-width="1"
                        />
                        <!-- axes from center to each vertex -->
                        <line
                            :x1="triCx" :y1="triCy"
                            :x2="triV.physics.x" :y2="triV.physics.y"
                            stroke="rgba(255,255,255,0.10)" stroke-width="1"
                        />
                        <line
                            :x1="triCx" :y1="triCy"
                            :x2="triV.energy.x" :y2="triV.energy.y"
                            stroke="rgba(255,255,255,0.10)" stroke-width="1"
                        />
                        <line
                            :x1="triCx" :y1="triCy"
                            :x2="triV.emotion.x" :y2="triV.emotion.y"
                            stroke="rgba(255,255,255,0.10)" stroke-width="1"
                        />
                        <!-- chakra polygons -->
                        <g
                            v-for="pt in triChakraPolygons"
                            :key="pt.key"
                            style="cursor: pointer"
                            @mouseenter="hoveredChakra = pt.key"
                            @mouseleave="hoveredChakra = null"
                        >
                            <polygon
                                :points="pt.points"
                                :fill="pt.meta?.hex ?? '#fff'"
                                :fill-opacity="hoveredChakra === pt.key ? 0.50 : 0.25"
                                :stroke="pt.meta?.hex ?? '#fff'"
                                :stroke-opacity="hoveredChakra === pt.key ? 1 : 0.55"
                                stroke-width="1.5"
                                stroke-linejoin="round"
                                style="transition: fill-opacity 0.2s, stroke-opacity 0.2s"
                            />
                        </g>
                        <!-- vertex labels -->
                        <text
                            :x="triV.physics.x"
                            :y="triV.physics.y - 16"
                            text-anchor="middle"
                            font-size="11"
                            font-weight="600"
                            fill="#22d3ee"
                        >Физика</text>
                        <text
                            :x="triV.energy.x - 10"
                            :y="triV.energy.y + 20"
                            text-anchor="middle"
                            font-size="11"
                            font-weight="600"
                            fill="#a78bfa"
                        >Энергия</text>
                        <text
                            :x="triV.emotion.x + 10"
                            :y="triV.emotion.y + 20"
                            text-anchor="middle"
                            font-size="11"
                            font-weight="600"
                            fill="#f472b6"
                        >Эмоции</text>
                        <!-- center dot -->
                        <circle :cx="triCx" :cy="triCy" r="4" fill="var(--color-accent, #a78bfa)" />
                    </svg>
                </div>
            </div>

            <!-- chakra cards -->
            <div class="flex flex-col gap-5">
                <div
                    v-for="(values, key) in props.chakras"
                    :key="key"
                    class="surface-ui rounded-2xl p-5 border border-surface-700"
                >
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-3 h-3 rounded-full shrink-0" :class="chakraMeta[key]?.dot"></span>
                        <span class="h-3 rounded-full flex-1" :class="chakraMeta[key]?.soft"></span>
                        <div class="font-semibold whitespace-nowrap">{{ chakraMeta[key]?.title ?? key }}</div>
                    </div>
                    <div class="space-y-4">
                        <div v-for="(val, type) in values" :key="type">
                            <div class="flex justify-between mb-2 text-sm">
                                <span class="text-surface-100/70">{{ labels[type] }}</span>
                                <span class="text-accent font-bold">{{ val }}</span>
                            </div>
                            <div class="h-2 bg-surface-800 rounded-full overflow-hidden">
                                <div
                                    class="h-full rounded-full transition-all duration-500"
                                    :class="chakraMeta[key]?.dot"
                                    :style="{ width: getPercent(val) }"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
