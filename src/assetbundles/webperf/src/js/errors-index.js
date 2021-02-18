import VueEvents from 'vue-events';
import ErrorsIndexTable from '@vue/tables/Errors/ErrorsIndexTable.vue';
import SampleRangePicker from '@vue/common/SampleRangePicker.vue';
import ErrorsDetailAreaChart from '@vue/charts/Errors/ErrorsDetailAreaChart.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'errors-index-table': ErrorsIndexTable,
        'sample-range-picker': SampleRangePicker,
        'errors-detail-area-chart': ErrorsDetailAreaChart,
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
