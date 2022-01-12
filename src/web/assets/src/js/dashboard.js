import Vue from 'vue';
import VueEvents from 'vue-events';
import ConfettiParty from '@/vue/common/ConfettiParty.vue';
import RadialBarChart from '@/vue/charts/common/RadialBarChart.vue';
import SimpleBarChart from '@/vue/charts/common/SimpleBarChart.vue';
import DashboardFileList from '@/vue/charts/dashboard/DashboardFileList.vue';
import SampleRangePicker from '@/vue/common/SampleRangePicker.vue';
import SamplePaneFooter from '@/vue/common/SamplePaneFooter.vue';
import RecommendationsList from '@/vue/common/RecommendationsList.vue';

Vue.use(VueEvents);
// Create our vue instance
new Vue({
    el: "#cp-nav-content",
    components: {
        ConfettiParty,
        RadialBarChart,
        SimpleBarChart,
        DashboardFileList,
        SampleRangePicker,
        SamplePaneFooter,
        RecommendationsList,
    },
});
