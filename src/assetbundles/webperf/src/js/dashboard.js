import Vue from 'vue';
import VueEvents from 'vue-events';
import Confetti from '../vue/Confetti.vue';
import DashboardRadialBarChart from '../vue/DashboardRadialBarChart.vue';
import DashboardSimpleBarChart from '../vue/DashboardSimpleBarChart.vue';
import DashboardFileList from '../vue/DashboardFileList.vue';
import SampleRangePicker from '../vue/SampleRangePicker.vue';
import SamplePaneFooter from '../vue/SamplePaneFooter.vue';
import RecommendationsList from '../vue/RecommendationsList.vue';

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
        'sample-pane-footer': SamplePaneFooter,
        'recommendations-list': RecommendationsList,
    },
    data: {
    },
    mounted() {
    },
});
