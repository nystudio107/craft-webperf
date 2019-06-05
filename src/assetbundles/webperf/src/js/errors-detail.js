import Vue from 'vue';
import VueEvents from 'vue-events';
import ErrorsDetailAreaChart from '../vue/charts/Errors/ErrorsDetailAreaChart.vue';
import ErrorsDetailTable from '../vue/tables/Errors/ErrorsDetailTable.vue';
import RadialBarChart from '../vue/charts/common/RadialBarChart.vue';
import SimpleBarChart from '../vue/charts/common/SimpleBarChart.vue';
import SampleRangePicker from '../vue/common/SampleRangePicker.vue';
import SamplePaneFooter from '../vue/common/SamplePaneFooter.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'errors-detail-area-chart': ErrorsDetailAreaChart,
        'errors-detail-table': ErrorsDetailTable,
        'radial-bar-chart': RadialBarChart,
        'simple-bar-chart': SimpleBarChart,
        'sample-range-picker': SampleRangePicker,
        'sample-pane-footer': SamplePaneFooter,
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
