import Vue from 'vue';
import VueEvents from 'vue-events';
import ErrorsIndexTable from '@/vue/tables/errors/ErrorsIndexTable.vue';
import SampleRangePicker from '@/vue/common/SampleRangePicker.vue';
import ErrorsDetailAreaChart from '@/vue/charts/errors/ErrorsDetailAreaChart.vue';

Vue.use(VueEvents);
// Create our vue instance
new Vue({
  el: "#cp-nav-content",
  components: {
    ErrorsIndexTable,
    SampleRangePicker,
    ErrorsDetailAreaChart,
  },
  mounted() {
    this.$events.$on('refresh-table', eventData => this.onTableRefresh(eventData));
  },
  methods: {
    onTableRefresh(vuetable) {
      Vue.nextTick(() => vuetable.refresh());
    }
  },
});
