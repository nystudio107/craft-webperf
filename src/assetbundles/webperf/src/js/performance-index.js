import Vue from 'vue';
import VueEvents from 'vue-events';
import PerformanceIndexBarChart from '../vue/charts/performance/PerformanceIndexBarChart.vue';
import PerformanceIndexTable from '../vue/tables/performance/PerformanceIndexTable.vue';
import SampleRangePicker from '../vue/common/SampleRangePicker.vue';
import PerformanceDetailAreaChart from '../vue/charts/performance/PerformanceDetailAreaChart.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'performance-index-bar-chart': PerformanceIndexBarChart,
        'performance-index-table': PerformanceIndexTable,
        'sample-range-picker': SampleRangePicker,
        'performance-detail-area-chart': PerformanceDetailAreaChart,
    },
    data: {
    },
    methods: {
        onTableRefresh(vuetable) {
            Vue.nextTick(() => vuetable.refresh());
        }
    },
    mounted() {
        this.$events.$on('refresh-table', eventData => this.onTableRefresh(eventData));
    },
});
