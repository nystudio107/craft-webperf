<template>
  <main />
</template>

<script>
import Vue from 'vue';
import VueConfetti from 'vue-confetti';

Vue.use(VueConfetti);

export default Vue.extend({
  mounted: function () {
    this.$confetti.start({
      shape: 'rect',
      colors: ['DodgerBlue', 'OliveDrab', 'Gold', 'pink', 'SlateBlue', 'lightblue', 'Violet', 'PaleGreen', 'SteelBlue', 'SandyBrown', 'Chocolate', 'Crimson']
    });
    setTimeout(() => {
      this.$confetti.stop();
    }, 5000);
  },
  methods: {}
})
</script>
