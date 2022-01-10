import Vue from 'vue';
import VueEvents from 'vue-events';
import PerformanceIndexTable from '@/vue/tables/performance/PerformanceIndexTable.vue';
import SampleRangePicker from '@/vue/common/SampleRangePicker.vue';
import PerformanceDetailAreaChart from '@/vue/charts/performance/PerformanceDetailAreaChart.vue';
import RecommendationsList from '@/vue/common/RecommendationsList.vue';

Vue.use(VueEvents);
// Create our vue instance
new Vue({
    el: "#cp-nav-content",
    components: {
        PerformanceIndexTable,
        SampleRangePicker,
        PerformanceDetailAreaChart,
        RecommendationsList,
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
