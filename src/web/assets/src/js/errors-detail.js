import Vue from 'vue';
import VueEvents from 'vue-events';
import ErrorsDetailAreaChart from '@/vue/charts/Errors/ErrorsDetailAreaChart.vue';
import ErrorsDetailTable from '@/vue/tables/Errors/ErrorsDetailTable.vue';
import RadialBarChart from '@/vue/charts/common/RadialBarChart.vue';
import SimpleBarChart from '@/vue/charts/common/SimpleBarChart.vue';
import SampleRangePicker from '@/vue/common/SampleRangePicker.vue';
import SamplePaneFooter from '@/vue/common/SamplePaneFooter.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        ErrorsDetailAreaChart,
        ErrorsDetailTable,
        RadialBarChart,
        SimpleBarChart,
        SampleRangePicker,
        SamplePaneFooter,
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
