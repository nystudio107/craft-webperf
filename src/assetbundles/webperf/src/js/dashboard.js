import Vue from 'vue';
import VueEvents from 'vue-events';
import Confetti from '../vue/Confetti.vue';
import DashboardRadialBarChart from '../vue/DashboardRadialBarChart.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'confetti': Confetti,
        'dashboard-radial-bar-chart': DashboardRadialBarChart,
    },
    data: {
    },
    mounted() {
        setTimeout(() => {
            //this.$events.fire('change-range', 'day');
        }, 5000);
    },
});
