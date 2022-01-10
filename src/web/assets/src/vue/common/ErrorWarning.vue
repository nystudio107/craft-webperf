<template>
  <div class="field text-sm font-normal inline-block">
    <p
      v-if="sample > 0"
      class="warning display-block webperf-error-color"
    >
      {{ sample }}
    </p>
    <p
      v-else
      class="display-block text-grey-500"
    >
      -
    </p>
  </div>
</template>
<script>
export default {
  name: 'ErrorWarning',
  props: {
    sample: Number,
  },
}
</script>
