import Vue from 'vue';
import Confetti from '../vue/Confetti.vue';
import DashboardRadialBarChart from '../vue/DashboardRadialBarChart.vue';

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
    },
});
