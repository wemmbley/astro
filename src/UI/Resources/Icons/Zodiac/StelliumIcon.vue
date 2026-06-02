<script setup lang="ts">
defineProps({
    stellium: String,
});
</script>

<template>
    <template v-if="stellium === 'bigBear'">
        <svg width="210" height="210" viewBox="0 0 210 210" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="35" r="9.5" stroke="currentColor" stroke-width="3"/>
            <circle cx="198.5" cy="162.5" r="10" stroke="currentColor" stroke-width="3"/>
            <circle cx="73" cy="46" r="6" stroke="currentColor" stroke-width="2"/>
            <circle cx="164" cy="195" r="6" stroke="currentColor" stroke-width="2"/>
            <circle cx="91" cy="93" r="6" stroke="currentColor" stroke-width="2"/>
            <circle cx="109" cy="127" r="6" stroke="currentColor" stroke-width="2"/>
            <circle cx="100" cy="169" r="6" stroke="currentColor" stroke-width="2"/>
            <line x1="120.553" y1="131.606" x2="183.553" y2="156.606" stroke="currentColor" stroke-width="3"/>
            <line x1="111.587" y1="174.62" x2="151.587" y2="191.62" stroke="currentColor" stroke-width="3"/>
            <line x1="102.536" y1="157.675" x2="106.536" y2="139.675" stroke="currentColor" stroke-width="3"/>
            <line x1="103.704" y1="115.756" x2="96.7043" y2="103.756" stroke="currentColor" stroke-width="3"/>
            <line x1="87.5887" y1="81.5081" x2="78.5887" y2="56.5081" stroke="currentColor" stroke-width="3"/>
            <line x1="60.7753" y1="42.4831" x2="27.7753" y2="37.4831" stroke="currentColor" stroke-width="3"/>
            <line x1="174.939" y1="187.939" x2="186.939" y2="175.939" stroke="currentColor" stroke-width="3"/>
            <path d="M105.5 25.5L102.5 35L99 25.5L91 21L99 18.5L102.5 8L105.5 18L114.5 21.5L105.5 25.5Z" stroke="currentColor" stroke-width="2"/>
            <path d="M48.3404 157.963L45.7872 165L42.8085 157.963L36 154.63L42.8085 152.778L45.7872 145L48.3404 152.407L56 155L48.3404 157.963Z" stroke="currentColor" stroke-width="2"/>
            <path d="M156.553 118.481L155.404 122L154.064 118.481L151 116.815L154.064 115.889L155.404 112L156.553 115.704L160 117L156.553 118.481Z" stroke="currentColor"/>
            <path d="M189.34 66.963L186.787 74L183.809 66.963L177 63.6296L183.809 61.7778L186.787 54L189.34 61.4074L197 64L189.34 66.963Z" stroke="currentColor" stroke-width="2"/>
        </svg>
    </template>
    <template v-if="stellium === 'sagittarius'">
        <svg width="160" height="160" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M83.2053 137.234L83.3147 136.347L83.9176 137.037L84.8981 137.172L84.0792 137.623L83.9382 138.609L83.3785 137.862L82.3115 137.84L83.2053 137.234Z" stroke="currentColor" stroke-width="2"/>
            <path d="M61 60.5L66.5 57L69.5 61V56.5L74 58L70 54.5L74 51.5H69.5L71 46L67.5 50.5L66.5 45.5L64.5 50.5L61.5 49.5L63.5 52.5L59 53.5L63.5 55L61 60.5Z" stroke="currentColor" stroke-width="2"/>
            <path d="M156.205 45.2336L156.315 44.3473L156.918 45.0372L157.898 45.1724L157.079 45.6235L156.938 46.6086L156.379 45.8617L155.312 45.8405L156.205 45.2336Z" stroke="currentColor" stroke-width="2"/>
            <path d="M18.6377 130.11L16.132 131.749L16.8673 128.782L15.4882 126.082L18.1115 127.123L20.9311 125.348L19.9708 128.332L21.8 130.999L18.6377 130.11Z" stroke="currentColor" stroke-width="2"/>
            <path d="M76.6533 94.7769L73.6817 94.4092L76.1598 92.6199L76.8521 89.6677L78.1816 92.1573L81.4801 92.6249L78.8196 94.2813L78.492 97.4992L76.6533 94.7769Z" stroke="currentColor" stroke-width="2"/>
            <path d="M22.8448 23.9683L19.8731 23.6006L22.3512 21.8113L23.0435 18.8591L24.373 21.3487L27.6715 21.8163L25.011 23.4727L24.6834 26.6906L22.8448 23.9683Z" stroke="currentColor" stroke-width="2"/>
            <path d="M134.845 57.9683L131.874 57.6006L134.352 55.8113L135.044 52.8591L136.374 55.3487L139.672 55.8163L137.011 57.4727L136.684 60.6906L134.845 57.9683Z" stroke="currentColor" stroke-width="2"/>
            <path d="M99.8448 45.9683L96.8731 45.6006L99.3512 43.8113L100.044 40.8591L101.373 43.3487L104.672 43.8163L102.011 45.4727L101.683 48.6906L99.8448 45.9683Z" stroke="currentColor" stroke-width="2"/>
            <path d="M104.845 15.9683L101.873 15.6006L104.351 13.8113L105.044 10.8591L106.373 13.3487L109.672 13.8163L107.011 15.4727L106.683 18.6906L104.845 15.9683Z" stroke="currentColor" stroke-width="2"/>
            <path d="M102.638 129.11L100.132 130.749L100.867 127.782L99.4882 125.082L102.111 126.123L104.931 124.348L103.971 127.332L105.8 129.999L102.638 129.11Z" stroke="currentColor" stroke-width="2"/>
            <path d="M6.82364 112.896L3.8296 112.939L6.0388 110.827L6.31948 107.808L7.97802 110.091L11.3095 110.102L8.90138 112.108L9.01848 115.34L6.82364 112.896Z" stroke="currentColor" stroke-width="2"/>
            <path d="M7.63769 146.11L5.13202 147.749L5.86728 144.782L4.48817 142.082L7.11149 143.123L9.93109 141.348L8.97076 144.332L10.8 146.999L7.63769 146.11Z" stroke="currentColor" stroke-width="2"/>
            <path d="M69.6377 114.11L67.132 115.749L67.8673 112.782L66.4882 110.082L69.1115 111.123L71.9311 109.348L70.9708 112.332L72.8 114.999L69.6377 114.11Z" stroke="currentColor" stroke-width="2"/>
            <circle cx="14.5" cy="136.5" r="1.5" fill="currentColor"/><circle cx="38.5" cy="122.5" r="1.5" fill="currentColor"/>
            <circle cx="48.5" cy="119.5" r="1.5" fill="currentColor"/><circle cx="58.5" cy="116.5" r="1.5" fill="currentColor"/>
            <circle cx="75.5" cy="121.5" r="1.5" fill="currentColor"/><circle cx="77.5" cy="126.5" r="1.5" fill="currentColor"/>
            <circle cx="80.5" cy="130.5" r="1.5" fill="currentColor"/><circle cx="90.5" cy="133.5" r="1.5" fill="currentColor"/>
            <circle cx="94.5" cy="130.5" r="1.5" fill="currentColor"/><circle cx="75.5" cy="101.5" r="1.5" fill="currentColor"/>
            <circle cx="76.5" cy="84.5" r="1.5" fill="currentColor"/><circle cx="74.5" cy="79.5" r="1.5" fill="currentColor"/>
            <circle cx="73.5" cy="73.5" r="1.5" fill="currentColor"/><circle cx="71.5" cy="68.5" r="1.5" fill="currentColor"/>
            <circle cx="78.5" cy="50.5" r="1.5" fill="currentColor"/><circle cx="82.5" cy="49.5" r="1.5" fill="currentColor"/>
            <circle cx="87.5" cy="48.5" r="1.5" fill="currentColor"/><circle cx="92.5" cy="47.5" r="1.5" fill="currentColor"/>
            <circle cx="103.5" cy="35.5" r="1.5" fill="currentColor"/><circle cx="104.5" cy="29.5" r="1.5" fill="currentColor"/>
            <circle cx="105.5" cy="23.5" r="1.5" fill="currentColor"/><circle cx="108.5" cy="48.5" r="1.5" fill="currentColor"/>
            <circle cx="113.5" cy="50.5" r="1.5" fill="currentColor"/><circle cx="118.5" cy="51.5" r="1.5" fill="currentColor"/>
            <circle cx="123.5" cy="52.5" r="1.5" fill="currentColor"/><circle cx="128.5" cy="53.5" r="1.5" fill="currentColor"/>
            <circle cx="144.5" cy="52.5" r="1.5" fill="currentColor"/><circle cx="150.5" cy="50.5" r="1.5" fill="currentColor"/>
            <circle cx="57.5" cy="48.5" r="1.5" fill="currentColor"/><circle cx="53.5" cy="45.5" r="1.5" fill="currentColor"/>
            <circle cx="48.5" cy="41.5" r="1.5" fill="currentColor"/><circle cx="44.5" cy="38.5" r="1.5" fill="currentColor"/>
            <circle cx="40.5" cy="35.5" r="1.5" fill="currentColor"/><circle cx="36.5" cy="32.5" r="1.5" fill="currentColor"/>
            <circle cx="31.5" cy="29.5" r="1.5" fill="currentColor"/><circle cx="53.5" cy="117.5" r="1.5" fill="currentColor"/>
            <circle cx="43.5" cy="121.5" r="1.5" fill="currentColor"/><circle cx="34.5" cy="124.5" r="1.5" fill="currentColor"/>
            <circle cx="29.5" cy="126.5" r="1.5" fill="currentColor"/><circle cx="11.5" cy="119.5" r="1.5" fill="currentColor"/>
        </svg>
    </template>
    <template v-if="stellium === 'scorpio'">
        <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M105.936 132.38L104.915 135.194L103.723 132.38L101 131.046L103.723 130.305L104.915 127.194L105.936 130.157L109 131.194L105.936 132.38Z" stroke="currentColor" stroke-width="2"/>
            <path d="M62.7861 115.881L65.524 117.093L62.634 118.089L61.1167 120.714L60.5648 117.946L57.543 116.544L60.5691 115.728L61.8142 112.743L62.7861 115.881Z" stroke="currentColor" stroke-width="2"/>
            <path d="M84.8981 82.393L85.2037 85.3718L82.9059 83.3561L79.8737 83.341L82.0032 81.4888L81.7219 78.1692L83.931 80.3923L87.1407 79.9925L84.8981 82.393Z" stroke="currentColor" stroke-width="2"/>
            <path d="M62.4945 65.56L65.3428 66.484L62.5705 67.7715L61.3315 70.5391L60.4977 67.8427L57.3475 66.7588L60.2736 65.6364L61.2048 62.5387L62.4945 65.56Z" stroke="currentColor" stroke-width="2"/>
            <path d="M39.6101 61.0049L41.6956 63.1536L38.6431 62.9952L36.2536 64.862L36.7775 62.0887L34.4999 59.6574L37.6113 60.0337L39.883 57.7312L39.6101 61.0049Z" stroke="currentColor" stroke-width="2"/>
            <path d="M19.2705 52.1737L21.5782 50.2657L21.1776 53.2959L22.8485 55.8263L20.1257 55.0835L17.521 57.1605L18.1435 54.0889L16.0288 51.6413L19.2705 52.1737Z" stroke="currentColor" stroke-width="2"/>
            <path d="M38.654 10.403L39.9315 7.69483L40.8573 10.6079L43.4455 12.1876L40.6652 12.673L39.1908 15.6605L38.4483 12.6157L35.4936 11.2994L38.654 10.403Z" stroke="currentColor" stroke-width="2"/>
            <path d="M32.0447 6.23355L32.154 5.34725L32.7569 6.03719L33.7374 6.17242L32.9186 6.62348L32.7775 7.60864L32.2179 6.86172L31.1509 6.84046L32.0447 6.23355Z" stroke="currentColor" stroke-width="2"/>
            <path d="M91.2053 91.4279L91.3147 90.5416L91.9176 91.2315L92.8981 91.3668L92.0792 91.8178L91.9382 92.803L91.3785 92.0561L90.3115 92.0348L91.2053 91.4279Z" stroke="currentColor" stroke-width="2"/>
            <path d="M51.2705 20.1737L53.5782 18.2657L53.1776 21.2959L54.8485 23.8263L52.1257 23.0835L49.521 25.1605L50.1435 22.0889L48.0288 19.6413L51.2705 20.1737Z" stroke="currentColor" stroke-width="2"/>
            <path d="M14.2705 17.1737L16.5782 15.2657L16.1776 18.2959L17.8485 20.8263L15.1257 20.0835L12.521 22.1605L13.1435 19.0889L11.0288 16.6413L14.2705 17.1737Z" stroke="currentColor" stroke-width="2"/>
            <path d="M82.4663 122.831L84.6078 124.924L81.5522 124.846L79.2129 126.776L79.6634 123.989L77.3224 121.619L80.4426 121.913L82.6528 119.551L82.4663 122.831Z" stroke="currentColor" stroke-width="2"/>
            <path d="M125.038 117.704L122.532 119.343L123.268 116.377L121.889 113.676L124.512 114.717L127.331 112.943L126.371 115.926L128.2 118.594L125.038 117.704Z" stroke="currentColor" stroke-width="2"/>
            <path d="M97.0267 107.704L94.5087 109.325L95.2663 106.364L93.9075 103.653L96.5229 104.713L99.3557 102.96L98.373 105.936L100.182 108.618L97.0267 107.704Z" stroke="currentColor" stroke-width="2"/>
            <circle cx="100.5" cy="114.694" r="1.5" fill="currentColor"/><circle cx="77.5" cy="78.6938" r="1.5" fill="currentColor"/>
            <circle cx="52.5" cy="64.6938" r="1.5" fill="currentColor"/><circle cx="15.5" cy="29.6938" r="1.5" fill="currentColor"/>
            <circle cx="26.5" cy="10.6938" r="1.5" fill="currentColor"/><circle cx="21.5" cy="13.6938" r="1.5" fill="currentColor"/>
            <circle cx="15.5" cy="35.6938" r="1.5" fill="currentColor"/><circle cx="16.5" cy="41.6938" r="1.5" fill="currentColor"/>
            <circle cx="17.5" cy="46.6938" r="1.5" fill="currentColor"/><circle cx="28.5" cy="59.6938" r="1.5" fill="currentColor"/>
            <circle cx="47.5" cy="63.6938" r="1.5" fill="currentColor"/><circle cx="69.5" cy="71.6938" r="1.5" fill="currentColor"/>
            <circle cx="73.5" cy="75.6938" r="1.5" fill="currentColor"/><circle cx="94.5" cy="98.6943" r="1.5" fill="currentColor"/>
            <circle cx="117.5" cy="121.694" r="1.5" fill="currentColor"/><circle cx="113.5" cy="125.694" r="1.5" fill="currentColor"/>
            <circle cx="95.5" cy="128.694" r="1.5" fill="currentColor"/><circle cx="90.5" cy="126.694" r="1.5" fill="currentColor"/>
            <circle cx="71.5" cy="120.694" r="1.5" fill="currentColor"/><circle cx="102.5" cy="120.694" r="1.5" fill="currentColor"/>
        </svg>
    </template>
</template>
