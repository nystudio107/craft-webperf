import Vue from 'vue';
import VueEvents from 'vue-events';
import PerformanceDetailAreaChart from '@/vue/charts/performance/PerformanceDetailAreaChart.vue';
import PerformanceDetailTable from '@/vue/tables/performance/PerformanceDetailTable.vue';
import RadialBarChart from '@/vue/charts/common/RadialBarChart.vue';
import SimpleBarChart from '@/vue/charts/common/SimpleBarChart.vue';
import SampleRangePicker from '@/vue/common/SampleRangePicker.vue';
import SamplePaneFooter from '@/vue/common/SamplePaneFooter.vue';
import RecommendationsList from '@/vue/common/RecommendationsList.vue';

Vue.use(VueEvents);
// Create our vue instance
new Vue({
    el: "#cp-nav-content",
    components: {
        PerformanceDetailAreaChart,
        PerformanceDetailTable,
        RadialBarChart,
        SimpleBarChart,
        SampleRangePicker,
        SamplePaneFooter,
        RecommendationsList,
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
