import VueEvents from 'vue-events';
import Confetti from '@/vue/common/Confetti.vue';
import RadialBarChart from '@/vue/charts/common/RadialBarChart.vue';
import SimpleBarChart from '@/vue/charts/common/SimpleBarChart.vue';
import DashboardFileList from '@/vue/charts/dashboard/DashboardFileList.vue';
import SampleRangePicker from '@/vue/common/SampleRangePicker.vue';
import SamplePaneFooter from '@/vue/common/SamplePaneFooter.vue';
import RecommendationsList from '@/vue/common/RecommendationsList.vue';

Vue.use(VueEvents);
// Create our vue instance
const vm = new Vue({
    el: "#cp-nav-content",
    components: {
        'confetti': Confetti,
        'radial-bar-chart': RadialBarChart,
        'simple-bar-chart': SimpleBarChart,
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
