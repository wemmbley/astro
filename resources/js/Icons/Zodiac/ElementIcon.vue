<script setup lang="ts">
const props = defineProps({
    element: {
        type: String,
        validator: (value: string) => {
            const validElements = [
                'fire',
                'air',
                'earth',
                'water',
            ];
            return validElements.indexOf(value) !== -1;
        },
        required: true,
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
</script>

<template>
    <div v-if="element === 'fire'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.3215 47.6298L30.6903 61.6514C31.3317 62.4424 32.6071 61.8804 32.456 60.8732L30.0559 44.8724C30.0199 44.6323 30.0724 44.3874 30.2036 44.1833L33.5284 39.0113C33.9523 38.352 34.9355 38.4145 35.2725 39.1222L39.4029 47.796C39.4668 47.9303 39.5 48.0772 39.5 48.2259V64.2457C39.5 64.6922 39.796 65.0846 40.2253 65.2072L42.2739 65.7925C42.7036 65.9153 43.1626 65.7381 43.3982 65.3584L51.8631 51.7205C51.9529 51.5759 52.0042 51.4108 52.0123 51.2407L52.9306 31.9578C52.964 31.2558 52.2821 30.7393 51.6155 30.9615L49.8162 31.5613C49.1687 31.7771 48.5 31.2951 48.5 30.6126V23.7038C48.5 22.8446 47.4881 22.3854 46.8415 22.9512L45.8372 23.8299C45.2505 24.3433 44.3281 24.0177 44.1937 23.2497L41.5229 7.98796C41.3567 7.03803 40.0747 6.85058 39.6434 7.71313L33.8147 19.3706C33.4618 20.0764 32.4687 20.1146 32.0628 19.4379L29.6186 15.3644C29.1791 14.6318 28.0826 14.7521 27.8125 15.5626L25.0513 23.8461C25.0173 23.948 25 24.0548 25 24.1623V45C25 45.5523 24.5523 46 24 46H20.0982C19.2567 46 18.7914 46.9761 19.3215 47.6298Z" fill="url(#paint0_linear_2125_17)" stroke="#FF332D"/>
            <defs>
                <linearGradient id="paint0_linear_2125_17" x1="35.5" y1="5" x2="35.5" y2="66" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#FF332D"/>
                    <stop offset="1" stop-color="#FF8800"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <div v-else-if="element === 'water'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.3621 57.7012L36.7735 67.3742C36.922 67.4567 37.0892 67.5 37.2591 67.5H44.5401C44.832 67.5 45.1093 67.3724 45.2993 67.1508L56.6886 53.8633C56.8855 53.6336 56.9678 53.327 56.9125 53.0296L53.0375 32.2014C53.0127 32.0685 52.9613 31.942 52.8864 31.8296L35.939 6.40857C35.5169 5.7754 34.5704 5.82699 34.2196 6.50228L15.1834 43.1469C15.0656 43.3736 15.0391 43.6369 15.1093 43.8826L18.8862 57.1017C18.9591 57.3567 19.1302 57.5724 19.3621 57.7012Z" fill="url(#paint0_linear_2125_15)" stroke="#3090FF"/>
            <defs>
                <linearGradient id="paint0_linear_2125_15" x1="48.5" y1="63.5" x2="28" y2="-9.5" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#3090FF"/>
                    <stop offset="1" stop-color="#1D5799"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <div v-else-if="element === 'earth'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.2766 58H54.1855C54.9731 58 55.4516 57.1318 55.031 56.4659L29.1085 15.4289C28.7025 14.7861 27.7559 14.8137 27.388 15.4791L16.7994 34.627C16.7568 34.7039 16.7246 34.7861 16.7036 34.8715L11.3056 56.7606C11.1502 57.3909 11.6273 58 12.2766 58Z" fill="url(#paint0_linear_2125_16)" stroke="#676767"/>
            <path d="M60.5887 58H13.2454C12.3796 58 11.9229 56.9746 12.5021 56.331L41.7059 23.8824C42.1208 23.4214 42.8508 23.4453 43.2347 23.9325L55.3971 39.3694C55.4652 39.4559 55.5186 39.553 55.5551 39.6568L61.5322 56.6685C61.7607 57.3189 61.2781 58 60.5887 58Z" fill="url(#paint1_linear_2125_16)" stroke="#676767"/>
            <defs>
                <linearGradient id="paint0_linear_2125_16" x1="29.0882" y1="17.7714" x2="37.8293" y2="57.0362" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#B9B9B9"/>
                    <stop offset="1" stop-color="#676767"/>
                </linearGradient>
                <linearGradient id="paint1_linear_2125_16" x1="41.5" y1="26" x2="36.5" y2="58" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#B9B9B9"/>
                    <stop offset="1" stop-color="#676767"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <div v-else-if="element === 'air'">
        <svg :width="width" :height="height" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 32L28.352 23.3487C28.7016 23.138 29.1441 23.1609 29.4701 23.4065L40.3935 31.6372C40.6897 31.8604 41.085 31.9013 41.4206 31.7435L57 24.4211" stroke="url(#paint0_linear_2125_18)" stroke-width="8"/>
            <path d="M14 48L28.352 39.3487C28.7016 39.138 29.1441 39.1609 29.4701 39.4065L40.3935 47.6372C40.6897 47.8604 41.085 47.9013 41.4206 47.7435L57 40.4211" stroke="url(#paint1_linear_2125_18)" stroke-width="8"/>
            <defs>
                <linearGradient id="paint0_linear_2125_18" x1="38" y1="29.5" x2="39.5" y2="37" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#27C81F"/>
                    <stop offset="1" stop-color="#13620F"/>
                </linearGradient>
                <linearGradient id="paint1_linear_2125_18" x1="37.5" y1="41.5" x2="39" y2="54.5" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#27C81F"/>
                    <stop offset="1" stop-color="#13620F"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
</template>
