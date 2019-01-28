import Vue from 'vue';
import VueEvents from 'vue-events';
import PageDetailAreaChart from '../vue/PageDetailAreaChart.vue';
import PageDetailTable from '../vue/PageDetailTable.vue';
import DashboardRadialBarChart from '../vue/DashboardRadialBarChart.vue';
import DashboardSimpleBarChart from '../vue/DashboardSimpleBarChart.vue';
import SampleRangePicker from '../vue/SampleRangePicker.vue';
import SamplePaneFooter from '../vue/SamplePaneFooter.vue';
import RecommendationsList from '../vue/RecommendationsList.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'page-detail-area-chart': PageDetailAreaChart,
        'page-detail-table': PageDetailTable,
        'dashboard-radial-bar-chart': DashboardRadialBarChart,
        'dashboard-simple-bar-chart': DashboardSimpleBarChart,
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
