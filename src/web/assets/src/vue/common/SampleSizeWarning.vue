<template>
  <div class="field webperf-tooltip text-sm font-normal inline-block">
    <p
      v-if="sample < 100"
      class="warning display-block"
    >
&nbsp;
    </p>
    <span class="webperf-tooltiptext webperf-sample-tooltip">
      Only {{ sample }} data sample<span v-if="sample !== 1">s</span>.
    </span>
  </div>
</template>
<script>
export default {
  name: 'SampleSizeWarning',
  props: {
    sample: Number,
  },
}
</script>
