<template>
  <span
    :class="className"
    :title="title"
    class="cursor-default"
  > {{ device }}</span>
</template>
<script>
export default {
  name: 'DataSampleDevice',
  props: {
    device: String,
    mobile: Boolean,
  },
  computed: {
    className() {
      let className = '';

      if (this.device && this.mobile !== undefined) {
        className = this.mobile === true ? 'webperf-mobile-icon' : 'webperf-desktop-icon';
      }

      return className;
    },
    title() {
      let title = '';

      if (this.device && this.mobile !== undefined) {
        title = this.mobile === true ? 'Mobile device' : 'Desktop device';
      }

      return title;
    }
  }
}
</script>
