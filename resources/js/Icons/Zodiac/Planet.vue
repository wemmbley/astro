<script setup lang="ts">
import { computed } from 'vue';

const defaultColors = {
    fire: '#FF332D',
    water: '#3090FF',
    air: '#27C81F',
    earth: '#676767',
};

const planetColors: Record<string, string> = {
    sun: 'fire',
    moon: 'water',
    mercury: 'fire',
    venus: 'air',
    mars: 'fire',
    jupiter: 'fire',
    saturn: 'earth',
    uranus: 'air',
    neptune: 'water',
    pluto: 'water',
    lilith: 'earth',
    chiron: 'earth',
    northNode: 'earth',
    southNode: 'earth',
    fortune: 'earth',
};

const props = defineProps({
    planet: {
        type: String,
        validator: (value: string) => {
            const validPlanets = [
                'sun', 'moon', 'mercury', 'venus', 'mars',
                'jupiter', 'saturn', 'uranus', 'neptune', 'pluto',
                'lilith', 'chiron', 'northNode', 'southNode', 'fortune'
            ];
            return validPlanets.indexOf(value) !== -1;
        },
        required: true,
    },
    color: {
        type: String,
        default: null,
    },
    width: {
        type: Number,
        default: 64,
    },
    height: {
        type: Number,
        default: 64,
    },
});

const computedColor = computed(() => {
    if (props.color) {
        return props.color;
    }
    const element = planetColors[props.planet];
    return defaultColors[element as keyof typeof defaultColors] || '#FF332D';
});
</script>

<template>
    <div v-if="planet === 'sun'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M66.9832 37.5582C66.9832 37.5582 68.7209 3.67028 36.8604 4.00251C23.9926 4.13669 16.3219 9.63607 11.7492 16.145C3.04722 28.5316 4.8112 46.4587 14.8101 57.8243C19.6484 63.3239 26.7043 67.7907 36.8604 67.7907C63.2826 67.7907 66.9832 37.5582 66.9832 37.5582Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M34.7893 42.3996C34.7893 42.3996 26.9812 40.2267 29.1106 33.1045C31.2401 25.9822 38.9694 28.2758 38.9694 28.2758C38.9694 28.2758 45.7916 31.1401 43.3072 37.4942C40.8228 43.8482 34.7893 42.3996 34.7893 42.3996Z" :fill="computedColor"/>
        </svg>
    </div>
    <div v-else-if="planet === 'moon'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M35.3976 37.9566C35.3976 10.8159 58.8546 5 54.4489 5H50.4449C50.4449 5 14.6179 5.64621 17.1258 36.018C19.6337 66.3897 47.937 66.7128 47.937 66.7128C47.937 66.7128 55.7706 67.359 54.4489 66.7128C53.1272 66.0666 35.3976 65.0973 35.3976 37.9566Z" :stroke="computedColor" stroke-width="7"/>
        </svg>
    </div>
    <div v-else-if="planet === 'mercury'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M52.2216 31.5278C52.2216 31.5278 52.746 13.385 35.7907 13.5628C18.8354 13.7407 18.8354 31.5278 18.8354 31.5278C18.8354 31.5278 21.1078 48.6035 35.7907 47.7141C50.4736 46.8247 52.2216 31.5278 52.2216 31.5278Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M17 2L27.8374 15.5182" :stroke="computedColor" stroke-width="6"/>
            <path d="M55.9795 2.53369L45.1421 15.3404" :stroke="computedColor" stroke-width="6"/>
            <path d="M43.8335 60.0459L27.2257 59.8965" :stroke="computedColor" stroke-width="6"/>
            <path d="M35.7129 48.0688L35.4403 70.0001" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'venus'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M55.4423 23.6919C55.4423 23.6919 56.0461 2.79664 36.523 3.0015C17 3.20635 17 23.6919 17 23.6919C17 23.6919 19.6165 43.3581 36.523 42.3338C53.4296 41.3095 55.4423 23.6919 55.4423 23.6919Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M45.7842 56.5376L26.662 56.3655" :stroke="computedColor" stroke-width="6"/>
            <path d="M36.4346 42.7422L36.121 68.0001" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'mars'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M48.1024 45.9667C48.1024 45.9667 48.6852 26.9137 29.8426 27.1005C11 27.2873 11 45.9667 11 45.9667C11 45.9667 13.5253 63.899 29.8426 62.965C46.1599 62.0311 48.1024 45.9667 48.1024 45.9667Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M40.3672 30.5292L62.3925 10.0586" :stroke="computedColor" stroke-width="6"/>
            <path d="M39.6731 16.3914L61.5117 10.6606" :stroke="computedColor" stroke-width="6"/>
            <path d="M55.9491 30.526L61.4441 10.6607" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'jupiter'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 15.003C24 15.003 28.1347 8.77678 31.0312 7.27687C33.9278 5.77695 38.764 4.92111 42.2812 8.6709C45.7985 12.4207 46.7586 15.003 46.7586 15.003C46.7586 15.003 49.4483 23.0026 46.7586 28.7523C44.069 34.502 24 56.7508 24 56.7508H54M46.7586 48.0012V70" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'saturn'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24.309 1V43.5745M24.309 68.5319V43.5745M9 14.2128H39.09M24.309 43.5745C24.309 43.5745 34.8668 26.4468 47.5363 26.9362C60.2058 27.4255 62.8453 35.2553 61.7895 46.0213C60.7337 56.7872 50.1758 70 50.1758 70" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'uranus'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M60.0752 45.6089C57.4264 44.6793 52.9415 41.3818 51.2644 29.805C48.8207 12.9365 59.3878 5.00005 59.3878 5.00005" :stroke="computedColor" stroke-width="6"/>
            <path d="M11.9248 46.7486C14.5736 45.819 19.0585 42.5215 20.7356 30.9446C23.1793 14.0762 12.6122 6.1397 12.6122 6.1397" :stroke="computedColor" stroke-width="6"/>
            <path d="M45.6094 58.5319C45.6094 58.5319 45.9514 49.0597 34.8937 49.1525C34.5793 49.1552 34.2739 49.1652 33.9772 49.1823C23.8263 49.7664 24.7379 67.4752 34.8937 66.9827C44.4694 66.5184 45.6094 58.5319 45.6094 58.5319Z" :stroke="computedColor" stroke-width="4"/>
            <path d="M35.7128 49.6213V17.6821M20.3716 31.3033H50.5591" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'neptune'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M47.2065 56.2324L23.2793 56.0258" :stroke="computedColor" stroke-width="6"/>
            <path d="M35.813 4.10156L35.8041 69.9999" :stroke="computedColor" stroke-width="6"/>
            <path d="M13.4779 4.32447C13.4779 4.32447 11.5503 19.2283 14.8491 26.2121C18.1478 33.196 18.5881 33.4565 22.7073 35.3163C26.8265 37.1761 28.1505 37.4346 35.9678 37.2032C43.785 36.9719 47.3908 35.8806 50.1288 33.923C52.8667 31.9654 54.6478 28.9053 56.504 25.336C58.3601 21.7667 58.2732 4.45726 58.2732 4.45726" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'pluto'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M49.3453 20.0834C49.3453 20.0834 49.7728 4.85176 35.9504 5.00109C22.1279 5.15042 22.1279 20.0834 22.1279 20.0834C22.1279 20.0834 23.9804 34.4192 35.9504 33.6725C47.9203 32.9259 49.3453 20.0834 49.3453 20.0834Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M43.9019 57.2227L27.3333 57.0607" :stroke="computedColor" stroke-width="6"/>
            <path d="M36 42.5649L35.3333 68.0002" :stroke="computedColor" stroke-width="6"/>
            <path d="M12 22.2905C12 22.2905 13.1111 29.6631 16 34.0866C18.8889 38.5101 22.6667 40.7218 22.6667 40.7218C22.6667 40.7218 25.3334 44.4081 32.6667 44.4081C40 44.4081 42.3333 44.0395 46 42.1963C49.6667 40.3532 49.5952 40.7218 53 36.667C56.4048 32.6121 60 23.0278 60 23.0278" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'lilith'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.0491 29.064C22.9198 16.7215 38.81 7.05323 43.599 6.23039C48.388 5.40756 51 7.05323 51 7.05323C51 7.05323 42.0756 14.6645 39.6811 18.1615C37.2865 21.6586 36.1983 24.3328 36.6336 31.5326C37.0688 38.7324 51 48.812 51 48.812C51 48.812 48.6057 54.3662 40.3339 52.7205C32.0621 51.0749 21.1784 41.4065 22.0491 29.064Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M43.3814 53.1318V69.9999M35.9805 61.5659H50.1294" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'chiron'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M52.5501 52.1895C52.5501 52.1895 53.0771 35.6229 36.0385 35.7854C32.9413 35.8149 30.407 36.3757 28.3335 37.2738C16.9858 42.1883 18.0804 62.304 29.8132 66.2109C31.5906 66.8028 33.6514 67.1008 36.0385 66.9694C50.7936 66.1574 52.5501 52.1895 52.5501 52.1895Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M28.9419 36.5292V17.6466M28.9419 1V17.6466M28.9419 17.6466L43.9895 2.24228M28.9419 17.6466L43.9895 27.5848" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'northNode'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M58.5188 20.1402C58.5188 20.1402 68.2238 18.2582 63.8821 9.79183C59.5404 1.32549 54.4324 6.65595 54.4324 6.65595C54.4324 6.65595 46.7706 9.79183 46.7706 20.1402C46.7706 30.4886 55.454 36.4478 54.4324 46.7957C53.4108 57.1435 52.3892 56.5163 46.7706 62.1609C41.1519 67.8055 30.1699 69.3731 24.0405 62.1609C17.911 54.9487 16.3787 54.0076 16.1233 44.9141C15.8679 35.8206 24.0405 30.4886 24.0405 20.1402C24.0405 9.79182 17.911 6.65595 17.911 6.65595C17.911 6.65595 11.5262 1.95266 7.9507 9.79182C4.37518 17.631 12.0369 20.1402 12.0369 20.1402" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'southNode'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.4812 51.8598C13.4812 51.8598 3.77623 53.7418 8.11793 62.2082C12.4596 70.6745 17.5676 65.344 17.5676 65.344C17.5676 65.344 25.2294 62.2082 25.2294 51.8598C25.2294 41.5114 16.546 35.5522 17.5676 25.2043C18.5892 14.8565 19.6108 15.4837 25.2294 9.83908C30.8481 4.19451 41.8301 2.62688 47.9595 9.83908C54.089 17.0513 55.6213 17.9923 55.8767 27.0859C56.1321 36.1794 47.9595 41.5114 47.9595 51.8598C47.9595 62.2082 54.089 65.344 54.089 65.344C54.089 65.344 60.4738 70.0473 64.0493 62.2082C67.6248 54.369 59.9631 51.8598 59.9631 51.8598" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
    <div v-else-if="planet === 'fortune'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M64.3007 37.4994C64.3007 37.4994 65.185 7.71008 36.5925 8.00213C8 8.29419 8 37.4994 8 37.4994C8 37.4994 11.832 65.5365 36.5925 64.0762C61.353 62.616 64.3007 37.4994 64.3007 37.4994Z" :stroke="computedColor" stroke-width="6"/>
            <path d="M17.4692 56.2509L57.601 15.5952M14.7637 18.2758L57.1501 56.2509" :stroke="computedColor" stroke-width="6"/>
        </svg>
    </div>
</template>
