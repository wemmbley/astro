<script setup>
import { track } from '@/Libs/Analytics'
import {onMounted} from "vue";

onMounted(() => track('pageview'))
</script>
