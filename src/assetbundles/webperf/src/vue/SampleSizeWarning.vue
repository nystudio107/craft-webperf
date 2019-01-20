<template>
    <div class="field webperf-tooltip text-sm font-normal inline-block">
        <p class="warning display-block" v-if="sample < 1000">&nbsp;</p>
        <span class="webperf-tooltiptext webperf-sample-tooltip">
            Only {{ sample }} data sample<span v-if="sample !== 1">s</span>.
        </span>
    </div>
</template>
<script>
    export default {
        name: 'sample-size-warning',
        props: {
            sample: Number,
        },
    }
</script>
