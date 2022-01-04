import VueEvents from 'vue-events';
import PerformanceIndexTable from '@/vue/tables/performance/PerformanceIndexTable.vue';
import SampleRangePicker from '@/vue/common/SampleRangePicker.vue';
import PerformanceDetailAreaChart from '@/vue/charts/performance/PerformanceDetailAreaChart.vue';
import RecommendationsList from '@/vue/common/RecommendationsList.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'performance-index-table': PerformanceIndexTable,
        'sample-range-picker': SampleRangePicker,
        'performance-detail-area-chart': PerformanceDetailAreaChart,
        'recommendations-list': RecommendationsList,
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
