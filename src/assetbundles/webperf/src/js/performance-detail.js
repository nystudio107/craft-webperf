import VueEvents from 'vue-events';
import PerformanceDetailAreaChart from '@vue/charts/performance/PerformanceDetailAreaChart.vue';
import PerformanceDetailTable from '@vue/tables/performance/PerformanceDetailTable.vue';
import RadialBarChart from '@vue/charts/common/RadialBarChart.vue';
import SimpleBarChart from '@vue/charts/common/SimpleBarChart.vue';
import SampleRangePicker from '@vue/common/SampleRangePicker.vue';
import SamplePaneFooter from '@vue/common/SamplePaneFooter.vue';
import RecommendationsList from '@vue/common/RecommendationsList.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'performance-detail-area-chart': PerformanceDetailAreaChart,
        'performance-detail-table': PerformanceDetailTable,
        'radial-bar-chart': RadialBarChart,
        'simple-bar-chart': SimpleBarChart,
        'sample-range-picker': SampleRangePicker,
        'sample-pane-footer': SamplePaneFooter,
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

// Accept HMR as per: https://webpack.js.org/api/hot-module-replacement#accept
if (module.hot) {
    module.hot.accept();
}
