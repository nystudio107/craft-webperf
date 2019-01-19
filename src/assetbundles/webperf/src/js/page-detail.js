import Vue from 'vue';
import VueEvents from 'vue-events';
import PageDetailAreaChart from '../vue/PageDetailAreaChart.vue';
import PageDetailTable from '../vue/PageDetailTable.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'page-detail-area-chart': PageDetailAreaChart,
        'page-detail-table': PageDetailTable,
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
