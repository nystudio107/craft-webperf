import Vue from 'vue';
import VueEvents from 'vue-events';
import Confetti from '../vue/Confetti.vue';
import DashboardRadialBarChart from '../vue/DashboardRadialBarChart.vue';
import DashboardSimpleBarChart from '../vue/DashboardSimpleBarChart.vue';
import DashboardFileList from '../vue/DashboardFileList.vue';
import SampleRangePicker from '../vue/SampleRangePicker.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'confetti': Confetti,
        'dashboard-radial-bar-chart': DashboardRadialBarChart,
        'dashboard-simple-bar-chart': DashboardSimpleBarChart,
        'dashboard-file-list': DashboardFileList,
        'sample-range-picker': SampleRangePicker,
    },
    data: {
    },
    mounted() {
        setTimeout(() => {
            //this.$events.fire('change-range', 'day');
        }, 5000);
    },
});
